@extends('admin-panel.layouts.master')
@section('title','Course list')


@section('css-files')
    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- toastr CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/toastr/toastr.min.css')}}">

    <!-- sweetalert2 CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">

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


            <div class="ibox">
                <div class="ibox-content">
                    <div class="px-3 row mb-3">
                        <div class="offset-sm-3 col-sm-2 align-middle">
                            <h3><b>Filter by subject: </b></h3>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control" id="status">
                                <option value="all">All subjects</option>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="deleted">Deleted</option>
                            </select>
                        </div>
                    </div>
                    <hr>

                    <div class="table-responsive">
                        <table id="course-list" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Course</th>
                                <th>Subject</th>
                                <!-- <th>Teacher</th> -->
                                <th>
                                    Teacher<br>
                                    Enrolled <small>(count)</small><br>
                                    Completed <small>(count)</small><br>
                                    Rating
                                </th>
                                <!-- <th>Last updated</th> -->
                                <th>Price <br>Duration <br>Videos <small>(count)</small><br>Last updated</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($data as $item)
                            <tr class="course_{{$item->id}}">

                                {{-- // todo add frontend link--}}
                                <td width="22%"><a href="" target="_blank">{{ $item->name}}</a></td>

                                {{-- // todo add frontend link--}}
                                <td><a href="" target="_blank">{{$item->subject->name}}</a></td>

                                <td>{{$item->teacher->full_name}}<br>
                                    {{--   todo
                                    123 <small>(Enrolled)</small><br>
                                    345 <small>(Completed)</small><br>
                                    4.9/5.0
                                    --}}
                                </td>

                                <!-- <td>12/04/2015</td>-->
                                <td>
                                    @if($item->price)
                                        Rs {{$item->price}}<br>
                                    @endif

                                    @if($item->duration)
                                    {{$item->duration}}<br>
                                    @endif

                                    @if($item->video_count)
                                        {{$item->video_count}} <small>(videos)</small><br>
                                    @endif

                                    @if($item->updated_at)
                                    {{--$item->updated_at--}}
                                    {{$item->getLastUpdatedTime()}}
                                     @endif
                                </td>
                                <td>
                                    <input type="checkbox" class="js-switch-course"
                                           courseId="{{$item->id}}" {{($item->status === 'published')?'checked':''}}/>
                                </td>

                                <td class="text-right">
                                    <div class="btn-group">
                                        <a href="{{route ('admin.course.show',$item->id)}}" class="btn-white btn btn-xs">View</a>
                                        <a href="{{route ('admin.course.edit',$item->id)}}" class="btn btn-blue btn-xs">Edit</a>
                                        <a href="javascript:void(0);" data-courseId="{{$item->id}}" class="delete-course-btn btn-danger btn btn-xs">Delete</a>
                                    </div>
                                    <form class="course-destroy" action="{{ route('admin.course.destroy', $item->id) }}" method="POST">
                                        @method('DELETE')
                                        <input name="courseId" type="hidden" value="{{$item->id}}">
                                        @csrf
                                    </form>
                                </td>

                            </tr>
                            @endforeach

                            </tbody>

                            <tfoot>
                            <th>Course</th>
                            <th>Subject</th>
                            <!-- <th>Teacher</th> -->
                            <th>
                                Teacher<br>
                                Enrolled <small>(count)</small><br>
                                Ecomplete <small>(count)</small><br>
                                Rating
                            </th>
                            <!-- <th>Last updated</th> -->
                            <th>Price <br>Duration <br>Videos <small>(count)</small><br>Last updated</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
@stop



@section('script-files')


    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Switchery -->
    <script src="{{asset('admin/js/plugins/switchery/switchery.js')}}"></script>

    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>


    <!-- SUMMERNOTE -->
    <!-- <script src="../assets/summernote-0.8.18/summernote-lite.js"></script> -->
    <script src="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.js')}}"></script>

    <!-- toastr js file-->
    <script src="{{asset('admin/js/plugins/toastr/toastr.min.js')}}"></script>

    <!-- sweetalert2 js file-->
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

@stop





@section('javascript')
<script>



    //delete course
	$('.delete-course-btn').on('click', function(event){

		var courseId = $(this).data('courseid');
        var form     = $(this).parent().parent().find('form.course-destroy');

		Swal.fire({
			title: 'Delete course',
			text: "Are you sure you want to course this user ?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3fcc98',
			confirmButtonText: 'Delete'
		}).then((result) => {


			if (result.isConfirmed) {

				$.ajax({
					url: "{{route('admin.course.check-empty')}}",
					type: "post",
					async:true,
					dataType:'json',
					data:{
						_token : '{{ csrf_token() }}',
						courseId : courseId
					},
					success: function (response) {

						if(response.status === 'success'){

							if(response.message === true){
								// course content is empty
                                //submit form
								form.submit();
                            }else{
								// course content is empty
								Swal.fire({
									title: 'Course already have content',
									text: "Are you sure you want to delete this course",
									icon: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#d33',
									cancelButtonColor: '#3fcc98',
									confirmButtonText: 'Delete'
								}).then((result) => {

									if (result.isConfirmed) {
										//sumit form
										form.submit();
                                    }
                                })
                            }
                        }else if(response.status == 'error'){
							toastr[response.status](response.message);
                        }
					},
					error:function(request,errorType,errorMessage)
					{
						//alert ('error - '+errorType+'with message - '+errorMessage);
						//toastr["success"]("User updated successfully! ", "Good Job!")
						toastr["error"]("Course check failed!")
					}
				});
			}
		});
		event.preventDefault();
	});




	$(document).ready(function() {

		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": true,
			"progressBar": true,
			"positionClass": "toast-top-right",
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


		$('#course-list').DataTable({
			pageLength: 10,
			ordering: false,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [{
				text: 'Add course',
				action: function ( e, dt, node, config ) {
					//$('#addProjectModal').modal('show');
					//$('#add-modal').modal('show');
					window.location = '{{route ('admin.course.create')}}';
					//  alert( 'Button activated' );
				},
				className: 'add-ct mb-3 btn-green '
			}],
			"columnDefs": [{
				"targets": [1,2,3,4,5],
				"searchable": false

			}],
			fnDrawCallback:function (oSettings) {
				console.log("after table create");
				var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch-course'));

				elems.forEach(function(html) {
					//need to check that it has not already be instantiated.
					if(!html.getAttribute('data-switchery')){
						var switchery = new Switchery(html, { size: 'small' });
					}

					html.onchange = function () {
						console.log("on click");
						var checked = html.checked;
						var id = $(html).attr('courseId');
						if (checked == false) {
							checked = 2;
						} else {
							checked = 1;
						}
						//todo
						changeCourseStatus(id, checked);
					}
				});
			}
		});
	});

	function changeCourseStatus(id, checked){
		//alert(id);
		//alert(checked);
		//if switch in off state, before change checked = 1  then checked = 2
		//if switch in on  state, before change checked = 2  then checked = 1
		var status;
		if(checked === 1){
			status = 'published';
		}else if(checked === 2){
			status = 'draft';
		}else{
			status = 'draft';
		}

		$.ajax({
			url: "{{route('admin.course.change-status')}}",
			type: "post",
			async:true,
			dataType:'json',
			data:{
				status : status,
				_token : '{{ csrf_token() }}',
				courseId : id
			},
			success: function (response) {
				toastr[response.status](response.message);
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

</script>
@stop


