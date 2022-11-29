@extends('admin-panel.layouts.master')
@section('title','User list')

@section('css-files')

    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">


    <!-- sweetalert2 CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">

    <!-- toastr CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/toastr/toastr.min.css')}}">
@stop



@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            @if(Session::has('message'))
                <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                    <p>{{ Session::get('message') ?? 'Info!' }}</p>
                    <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                </div>
            @endif

            @if(isset($message))
                <div class="flash-msg {{$cls ?? 'flash-info'}} rounded-none">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ $msgTitle ?? 'Info!'}}</strong></div>
                    <p>{{ $message ?? 'Info!' }}</p>
                    <div class="text-base">{!! $message2 ?? '' !!}</div>
                </div>
            @endif

            @if(isset($teachers) || isset($students) || isset($marketers) || isset($editors))
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container mb-5">

                        <ul class="nav nav-tabs" role="tablist" id="tab-button-wrapper">
                            @can('view',$teachers->first())
                                @if($teachers instanceof Illuminate\Support\Collection && $teachers->count()>0)
                                    <li><a class="nav-link __active" data-toggle="tab" href="#tab-teachers">Teachers</a></li>
                                @endif
                            @endcan

                            @can('view',$students->first())
                                @if(isset($students) && $students instanceof Illuminate\Support\Collection && $students->count()>0)
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-students">Students</a></li>
                                @endif
                            @endcan

                            @can('view',$marketers->first())
                                @if(isset($marketers) && $marketers instanceof Illuminate\Support\Collection && $marketers->count()>0)
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-marketers">Marketers</a></li>
                                @endif
                            @endcan

                            @can('view',$editors->first())
                                @if(isset($editors) && $editors instanceof Illuminate\Support\Collection && $editors->count()>0)
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-editors">Editors</a></li>
                                @endif                            
                            @endcan
                        </ul>

                        <div class="tab-content" id="tab-pane-wrapper">
                            @can('view',$teachers->first())
                                @if($teachers instanceof Illuminate\Support\Collection && $teachers->count()>0)
                                    <div role="tabpanel" id="tab-teachers" class="tab-pane __active">
                                        <div class="panel-body">

                                            <!--  -->
                                            <div class="table-responsive">
                                                <table id="user-list-teacher" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            {{--
                                                            full_name,email,username
                                                            phone, profile_pic, edu_qualifications |
                                                            profile_text ,gender, dob_year ==
                                                            status, activated
                                                            --}}

                                                            <th>Name</th>
                                                            <th>Email<br>
                                                                phone</th>
                                                            <th>Username</th>
                                                            <th>Image</th>
                                                            <th>Gender</th>
                                                            <th>Activated</th>
                                                            <th>status<br/> <small>Enable/Disable <br/> by admin</small></th>
                                                            <th class="text-right">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($teachers as $item)
                                                        <tr class="teacher_{{$item->id}}">
                                                            <td>{{$item->full_name}}</td>
                                                            <td>{{$item->email}}<br> {{$item->phone}}</td>
                                                            <td>{{$item->username}}</td>

                                                            <td>
                                                                @if($item->profile_pic != '')
                                                                    <a class="no-clickable popup-img effect" href="{{URL('/')}}/storage/{{$item->profile_pic}}" data-effect="mfp-zoom-in">
                                                                        <img src="{{URL('/')}}/storage/{{$item->profile_pic}}" width="100px" alt="">
                                                                    </a>
                                                                @endif
                                                            </td>

                                                            <td>{{$item->gender}}</td>

                                                            <td>
                                                                @if($item->isactivated() === true)
                                                                    <span class="label label-primary">Activated</span>
                                                                @elseif($item->isactivated() === false)
                                                                    <span class="label label-warning">Not Activated</span>
                                                                @else
                                                                    <span class="label">error</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <input type="checkbox" class="js-switch-teacher"
                                                                       userId="{{$item->id}}" {{($item->status === 1)?'checked':''}}/>
                                                            </td>

                                                            <td class="text-right">
                                                                <div class="btn-group">
                                                                    <a href="{{route ('admin.user.show',$item->id)}}" class="btn-white btn btn-xs">View</a>
                                                                    <a href="{{route ('admin.user.edit',$item->id)}}" class="btn btn-blue btn-xs">Edit</a>
                                                                    <a href="javascript:void(0);" class="delete-user-btn btn-danger btn btn-xs">Delete</a>
                                                                </div>
                                                                <form class="user-destroy" action="{{ route('admin.user.destroy', $item->id) }}" method="POST">
                                                                    @method('DELETE')
                                                                    <input name="userId" type="hidden" value="{{$item->id}}">
                                                                    <input name="userType" type="hidden" value="teacher">
                                                                    @csrf
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email<br>
                                                                phone</th>
                                                            <th>Username</th>
                                                            <th>Image</th>
                                                            <th>Gender</th>
                                                            <th>Activated</th>
                                                            <th>status<br/> <small>Enable/Disable <br/> by admin</small></th>
                                                            <th class="text-right">Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endcan

                            @can('view',$students->first())
                                @if(isset($students) && $students instanceof Illuminate\Support\Collection && $students->count()>0)
                                    <div role="tabpanel" id="tab-students" class="tab-pane">
                                        <div class="panel-body">


                                            <div class="table-responsive">
                                                <table id="user-list-stud" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email<br>
                                                            phone</th>
                                                        <th>Username</th>
                                                        <th>Gender</th>
                                                        <th>Activated</th>
                                                        <th>status<br/> <small>Enable/disable <br/> by admin</small></th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($students as $item)
                                                            <tr class="student_{{$item->id}}">
                                                                <td>{{$item->full_name}}</td>
                                                                <td>{{$item->email}}<br> {{$item->phone}}</td>
                                                                <td>{{$item->username}}</td>
                                                                <td>{{$item->gender}}</td>

                                                                <td>
                                                                    @if($item->isactivated() === true)
                                                                        <span class="label label-primary">Activated</span>
                                                                    @elseif($item->isactivated() === false)
                                                                        <span class="label label-warning">Not Activated</span>
                                                                    @else
                                                                        <span class="label">error</span>
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    <input type="checkbox" class="js-switch-student"
                                                                           userId="{{$item->id}}" {{($item->status === 1)?'checked':''}}/>
                                                                </td>

                                                                <td class="text-right">
                                                                    <div class="btn-group">
                                                                        <a href="{{route ('admin.user.show',$item->id)}}" class="btn-white btn btn-xs">View</a>
                                                                        <a href="{{route ('admin.user.edit',$item->id)}}" class="btn btn-blue btn-xs">Edit</a>
                                                                        <a href="javascript:void(0);" class="delete-user-btn btn-danger btn btn-xs">Delete</a>
                                                                    </div>
                                                                    <form class="user-destroy" action="{{ route('admin.user.destroy', $item->id) }}" method="POST">
                                                                        @method('DELETE')
                                                                        <input name="userId" type="hidden" value="{{$item->id}}">
                                                                        <input name="userType" type="hidden" value="student">
                                                                        @csrf
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email<br>
                                                                phone</th>
                                                            <th>Username</th>
                                                            <th>Gender</th>
                                                            <th>Activated</th>
                                                            <th>status<br/> <small>Enable/disable <br/> by admin</small></th>
                                                            <th class="text-right">Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                @endif
                            @endcan

                            @can('view',$marketers->first())    
                                @if(isset($marketers) && $marketers instanceof Illuminate\Support\Collection && $marketers->count()>0)
                                    <div role="tabpanel" id="tab-marketers" class="tab-pane">
                                        <div class="panel-body">


                                            <div class="table-responsive">
                                                <table id="user-list-marketer" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email<br>
                                                                phone</th>
                                                            <th>Username</th>
                                                            <th>Gender</th>
                                                            <th>Activated</th>
                                                            <th>status<br/> <small>Enable/disable <br/> by admin</small></th>
                                                            <th class="text-right">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($marketers as $item)
                                                        <tr class="marketer_{{$item->id}}">
                                                            <td>{{$item->full_name}}</td>
                                                            <td>{{$item->email}}<br> {{$item->phone}}</td>
                                                            <td>{{$item->username}}</td>
                                                            <td>{{$item->gender}}</td>

                                                            <td>
                                                                @if($item->isactivated() === true)
                                                                    <span class="label label-primary">Activated</span>
                                                                @elseif($item->isactivated() === false)
                                                                    <span class="label label-warning">Not Activated</span>
                                                                @else
                                                                    <span class="label">error</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <input type="checkbox" class="js-switch-marketer"
                                                                       userId="{{$item->id}}" {{($item->status === 1)?'checked':''}}/>
                                                            </td>

                                                            <td class="text-right">
                                                                <div class="btn-group">
                                                                    <a href="{{route ('admin.user.show',$item->id)}}" class="btn-white btn btn-xs">View</a>
                                                                    <a href="{{route ('admin.user.edit',$item->id)}}" class="btn btn-blue btn-xs">Edit</a>
                                                                    <a href="javascript:void(0);" class="delete-user-btn btn-danger btn btn-xs">Delete</a>
                                                                </div>
                                                                <form class="user-destroy" action="{{ route('admin.user.destroy', $item->id) }}" method="POST">
                                                                    @method('DELETE')
                                                                    <input name="userId" type="hidden" value="{{$item->id}}">
                                                                    <input name="userType" type="hidden" value="marketer">
                                                                    @csrf
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email<br>
                                                                phone</th>
                                                            <th>Username</th>
                                                            <th>Gender</th>
                                                            <th>Activated</th>
                                                            <th>status<br/> <small>Enable/disable <br/> by admin</small></th>
                                                            <th class="text-right">Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endcan

                            @can('view',$editors->first())    
                                @if(isset($editors) && $editors instanceof Illuminate\Support\Collection && $editors->count()>0)
                                    <div role="tabpanel" id="tab-editors" class="tab-pane">
                                        <div class="panel-body">

                                            <!--  -->
                                            <div class="table-responsive">
                                                <table id="user-list-editors" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email<br>
                                                                phone</th>
                                                            <th>Username</th>
                                                            <th>Gender</th>
                                                            <th>Activated</th>
                                                            <th>status<br/> <small>Enable/disable <br/> by admin</small></th>
                                                            <th class="text-right">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($editors as $item)
                                                        <tr class="editors_{{$item->id}}">
                                                            <td>{{$item->full_name}}</td>
                                                            <td>{{$item->email}}<br> {{$item->phone}}</td>
                                                            <td>{{$item->username}}</td>
                                                            <td>{{$item->gender}}</td>

                                                            <td>
                                                                @if($item->isactivated() === true)
                                                                    <span class="label label-primary">Activated</span>
                                                                @elseif($item->isactivated() === false)
                                                                    <span class="label label-warning">Not Activated</span>
                                                                @else
                                                                    <span class="label">error</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                <input type="checkbox" class="js-switch-editor"
                                                                       userId="{{$item->id}}" {{($item->status === 1)?'checked':''}}/>
                                                            </td>

                                                            <td class="text-right">
                                                                <div class="btn-group">
                                                                    <a href="{{route ('admin.user.show',$item->id)}}" class="btn-white btn btn-xs">View</a>
                                                                    <a href="{{route ('admin.user.edit',$item->id)}}" class="btn btn-blue btn-xs">Edit</a>
                                                                    <a href="javascript:void(0);" class="delete-user-btn btn-danger btn btn-xs">Delete</a>
                                                                </div>
                                                                <form class="user-destroy" action="{{ route('admin.user.destroy', $item->id) }}" method="POST">
                                                                    @method('DELETE')
                                                                    <input name="userId" type="hidden" value="{{$item->id}}">
                                                                    <input name="userType" type="hidden" value="editor">
                                                                    @csrf
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Email<br>
                                                                phone</th>
                                                            <th>Username</th>
                                                            <th>Gender</th>
                                                            <th>Activated</th>
                                                            <th>status<br/> <small>Enable/disable <br/> by admin</small></th>
                                                            <th class="text-right">Action</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                @endif
                            @endcan
                        </div>

                    </div>
                </div>
            </div>  
            @endif

        </div>
    </div>
@stop



@section('script-files')

    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Switchery -->
    <script src="{{asset('admin/js/plugins/switchery/switchery.js')}}"></script>

    <!-- Magnific Popup core JS file -->
    <script src="{{asset('admin/js/jquery.magnific-popup.min.js')}}"></script>


    <!-- sweetalert2 js file-->
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- toastr js file-->
    <script src="{{asset('admin/js/plugins/toastr/toastr.min.js')}}"></script>


@stop


@section('javascript')
<script>

	$(document).ready(function ($) {

		let selectedTab = window.location.hash;
		//selectedTab = (selectedTab=='')?'#tab-teachers':selectedTab;

        let firstTabId   = '#' + $('#tab-pane-wrapper .tab-pane').first().attr('id');
		selectedTab      = (selectedTab=='')? firstTabId : selectedTab;


        console.log(selectedTab);
        $('.nav-link[href="' + selectedTab + '"]' ).trigger('click');
        //window.location.hash = selectedTab;

		//Prevent default hash behavior on page load
		window.scrollTo(0,0);
    });



    $(document).ready(function() {


		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": true,
			"progressBar": true,
			"positionClass": "toast-top-right",
            //"positionClass": "toast-top-full-width",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};





        $('.delete-user-btn').on('click', function(event){

			Swal.fire({
				title: 'Delete user',
				text: "Are you sure you want to delete this user ?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3fcc98',
				confirmButtonText: 'Delete'
			}).then((result) => {


				if (result.isConfirmed) {
					//todo
					$(this).parent().parent().find('form.user-destroy').submit()

//					Swal.fire(
//						'Deleted!',
//						'Your file has been deleted.',
//						'success'
//					)
				}
			});

			event.preventDefault();
        });



		$('a.popup-img').magnificPopup({
			type: 'image',
			closeBtnInside: true,
			closeOnContentClick: true,
			tLoading: '', // remove text from preloader
			fixedContentPos : false,
			/* don't add this part, it's just to disable cache on image and test loading indicator */
			callbacks: {
				beforeChange: function() {
					this.items[0].src = this.items[0].src + '?=' + Math.random();
				},
                beforeOpen: function() {
					this.st.mainClass = this.st.el.attr('data-effect');
				},
				open: function() {
					jQuery('body').addClass('noscroll');
				},
				close: function() {
					jQuery('body').removeClass('noscroll');
				}
			},
            //removalDelay: 500, //delay removal by X to allow out-animation
			mainClass: 'mfp-with-fade',
		});



    	$('#user-list-teacher').DataTable({
			pageLength: 10,
			ordering: false,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [
                @can('createTeachers',"App\Models\User")
                    {
        				text: 'Add teacher',
        				href : 'uuu',
        				action: function ( e, dt, node, config ) {
        					//$('#addProjectModal').modal('show');
        					//$('#add-modal').modal('show');
        					window.location = '{{route('admin.user.create').'#tab-teachers'}}';
        					//  alert( 'Button activated' );
        				},
        				className: 'add-ct mb-3 btn-green '
        			}
                @endcan
            ],
			"columnDefs": [{
				"targets": [1,2,3,4,5,6],
				"searchable": false

			}],
			fnDrawCallback:function (oSettings) {
				console.log("after table create");
				var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-teacher'));

				elems.forEach(function(html) {
					//need to check that it has not already be instantiated.
					if(!html.getAttribute('data-switchery')){
						var switchery = new Switchery(html, { size: 'small' });
					}
					html.onchange = function () {
						console.log("on click");
						var checked = html.checked;
						var id = $(html).attr('userId');
						if (checked == false) {
							checked = 2;
						} else {
							checked = 1;
						}
						//todo
						changeUserState(id, checked);
					}
				});
			}
		});

		$('#user-list-stud').DataTable({
			pageLength: 10,
			ordering: false,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [
                @can('createStudents',"App\Models\User")
                    {
        				text: 'Add student',
        				href : 'uuu',
        				action: function ( e, dt, node, config ) {
        					//$('#addProjectModal').modal('show');
        					//$('#add-modal').modal('show');
        					window.location = '{{route('admin.user.create').'#tab-students'}}';
        					//  alert( 'Button activated' );
        				},
        				className: 'add-ct mb-3 btn-green '
        			}
                @endcan
            ],
			"columnDefs": [{
				"targets": [1,2,3,4,5,6],
				"searchable": false

			}],
			fnDrawCallback:function (oSettings) {
				console.log("after table create");
				var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-student'));

				elems.forEach(function(html) {
					//need to check that it has not already be instantiated.
					if(!html.getAttribute('data-switchery')){
						var switchery = new Switchery(html, { size: 'small' });
					}
					html.onchange = function () {
						console.log("on click");
						var checked = html.checked;
						var id = $(html).attr('userId');

						if (checked == false) {
							checked = 2;
						} else {
							checked = 1;
						}
						//todo
						changeUserState(id, checked);
					}
				});
			}
		});

		$('#user-list-marketer').DataTable({
			pageLength: 10,
			ordering: false,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [
                @can('createMarketers',"App\Models\User")
                    {
        				text: 'Add marketer',
        				href : 'uuu',
        				action: function ( e, dt, node, config ) {
        					//$('#addProjectModal').modal('show');
        					//$('#add-modal').modal('show');
        					window.location = '{{route('admin.user.create').'#tab-marketers'}}';
        					//  alert( 'Button activated' );
        				},
        				className: 'add-ct mb-3 btn-green '
        			}
                @endcan
            ],
			"columnDefs": [{
				"targets": [1,2,3,4,5,6],
				"searchable": false

			}],
			fnDrawCallback:function (oSettings) {
				console.log("after table create");
				var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-marketer'));

				elems.forEach(function(html) {
					//need to check that it has not already be instantiated.
					if(!html.getAttribute('data-switchery')){
						var switchery = new Switchery(html, { size: 'small' });
					}
					html.onchange = function () {
						console.log("on click");
						var checked = html.checked;
						var id = $(html).attr('userId');
						if (checked == false) {
							checked = 2;
						} else {
							checked = 1;
						}
						//todo
						changeUserState(id, checked);
					}
				});
			}
		});


		$('#user-list-editors').DataTable({
			pageLength: 10,
			ordering: false,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [
                @can('createEditors',"App\Models\User")
                    {
        				text: 'Add editor',
        				href : 'uuu',
        				action: function ( e, dt, node, config ) {
        					//$('#addProjectModal').modal('show');
        					//$('#add-modal').modal('show');
        					window.location = '{{route('admin.user.create').'#tab-editors'}}';
        					//  alert( 'Button activated' );
        				},
        				className: 'add-ct mb-3 btn-green '
    			    }
                @endcan
            ],
			"columnDefs": [{
				"targets": [1,2,3,4,5,6],
				"searchable": false

			}],
			fnDrawCallback:function (oSettings) {
				console.log("after table create");
				var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-editor'));

				elems.forEach(function(html) {
					//need to check that it has not already be instantiated.
					if(!html.getAttribute('data-switchery')){
						var switchery = new Switchery(html, { size: 'small' });
					}
					html.onchange = function () {
						console.log("on click");
						var checked = html.checked;
						var id = $(html).attr('userId');
						if (checked == false) {
							checked = 2;
						} else {
							checked = 1;
						}
						//todo
						changeUserState(id, checked);
					}
				});
			}
		});


		function changeUserState(id, checked){
            //alert(id);
			//alert(checked);
			//if switch in off state, before change checked = 1  then checked = 2
			//if switch in on  state, before change checked = 2  then checked = 1
			var status;
			if(checked === 1){
				status = 1;
            }else if(checked === 2){
				status = 0;
            }else{
				status = 0;
            }

			$.ajax({
				url: "{{route('admin.user.change-status')}}",
				type: "post",
				async:true,
				dataType:'json',
				data:{
					status : status,
					_token : '{{ csrf_token() }}',
					userId : id
				},
				success: function (response) {
					toastr[response.status](response.message,response.msgTitle);
					// You will get response from your PHP page (what you echo or print)
                },
				error:function(request,errorType,errorMessage)
				{
					//alert ('error - '+errorType+'with message - '+errorMessage);
					//toastr["success"]("User updated successfully! ", "Good Job!")
					toastr["error"]("User status update failed!")
				}
			});
        }

    });
</script>
@stop
