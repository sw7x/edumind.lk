@php    
	use App\Permissions\Abilities\CourseAbilities;
@endphp


@extends('admin-panel.layouts.master',['title' => 'Course list'])
@section('title','Course list')


@section('css-files')
    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- toastr CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/toastr/toastr.min.css')}}">

    <!-- sweetalert2 CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">

@stop





@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            @if(Session::has('message'))
                <x-flash-message  
                    :class="Session::get('cls', 'flash-info')"  
                    :title="Session::get('msgTitle') ?? 'Info!'" 
                    :message="Session::get('message') ?? ''"  
                    :message2="Session::get('message2') ?? ''"  
                    :canClose="true" />
			@endif     

			@if(isset($data) && isNotEmptyArray($data))			
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
		                                <th>
		                                    Teacher<br>
		                                    Enrolled <small>(count)</small><br>
		                                    Completed <small>(count)</small><br>
		                                    Rating
		                                </th>
		                                <th>Price <br>Duration <br>Videos <small>(count)</small><br>Last updated</th>
		                                <th>Status</th>
		                                <th class="text-right">Action</th>
		                            </tr>
	                            </thead>

	                            <tbody>
		                            @foreach($data as $item)		                            	
			                            <tr class="course_{{$item['data']['id']}}">

			                                {{-- // todo add frontend link--}}
			                                <td width="22%"><a href="" target="_blank">{{ $item['data']['name']}}</a></td>

			                                {{-- // todo add frontend link--}}
			                                <td>
			                                	<a href="" target="_blank">
				                                	@if(isset($item['data']['subjectName']))
				                                		{{$item['data']['subjectName']}}
				                                	@else
				                                		<span class="text-gray-400">No subject</span>
				                                	@endif

				                                	@if($item['data']['subjectIsTrashed'])
				                                		<br><small class="font-bold text-red">{{$item['data']['subjectIsTrashed']}}</small>
													@endif					                                	
			                                	</a>
			                                </td>

			                                <td>{{$item['data']['teacherName'] ?? ''}}<br>
			                                	@if($item['data']['authorRecAvailability'])
			                                		<span class="text-red">{{$item['data']['authorRecAvailability']}}</span>
			                                	@endif
			                                	
			                                    {{--   
			                                    todo
			                                    123 <small>(Enrolled)</small><br>
			                                    345 <small>(Completed)</small><br>
			                                    4.9/5.0
			                                    --}}
			                                </td>

			                                <!-- <td>12/04/2015</td>-->
			                                <td>
			                                    @if(isset($item['data']['price']))
			                                        Rs {{$item['data']['price']}}<br>
			                                    @endif

			                                    @if(isset($item['data']['duration']))
			                                    	{{$item['data']['duration']}}<br>
			                                    @endif

			                                    @if(isset($item['data']['videoCount']))
			                                        {{$item['data']['videoCount']}} <small>(videos)</small><br>
			                                    @endif

			                                    @if(isset($item['data']['updatedAtAgo']))
			                                    	{{--$item->updated_at--}}
			                                    	{{$item['data']['updatedAtAgo']}}
			                                    @endif
			                                </td>
			                                
			                                <td>				                                    
			                                	@can(CourseAbilities::CHANGE_COURSE_STATUS, $item['dbRec'])
			                                    	<input type="checkbox" class="js-switch-course"
			                                           courseId="{{$item['data']['id']}}" {{($item['data']['status'] === App\Models\Course::PUBLISHED)?'checked':''}}/>
			                                	@else
			                                		{{($item['data']['status'] === App\Models\Course::PUBLISHED)?'published' : 'Draft'}}
			                                	@endcan
			                                </td>

			                                <td class="text-right">
			                                    <div class="btn-group">
			                                        @can(CourseAbilities::ADMIN_PANEL_VIEW_COURSE, $item['dbRec'])
			                                        	<a href="{{route ('admin.courses.show',$item['data']['id'])}}" class="btn-white btn btn-xs">View</a>
			                                        @endcan
													
													@can(CourseAbilities::EDIT_COURSE, $item['dbRec'])
			                                        	<a href="{{route ('admin.courses.edit',$item['data']['id'])}}" class="btn btn-blue btn-xs">Edit</a>
			                                        @endcan
													
													@can(CourseAbilities::DELETE_SINGLE_COURSE, $item['dbRec'])
			                                        	<a href="javascript:void(0);" 
			                                        		data-courseId="{{$item['data']['id']}}"
			                                        		class="remove-course-btn btn-warning btn btn-xs">Trash</a>
			                                    	@endcan
			                                    </div>
			                                    @can(CourseAbilities::DELETE_SINGLE_COURSE, $item['dbRec'])
				                                    <form class="course-remove" action="{{ route('admin.courses.destroy', $item['data']['id']) }}" method="POST">
				                                        @method('DELETE')
				                                        <input name="courseId" type="hidden" value="{{$item['data']['id']}}">
														@csrf
				                                    </form>
			                                    @endcan
			                                </td>
			                            </tr>			                            
		                            @endforeach
	                            </tbody>

	                            <tfoot>
		                            <th>Course</th>
		                            <th>Subject</th>
		                            <th>
		                                Teacher<br>
		                                Enrolled <small>(count)</small><br>
		                                Ecomplete <small>(count)</small><br>
		                                Rating
		                            </th>
		                            <th>Price <br>Duration <br>Videos <small>(count)</small><br>Last updated</th>
		                            <th>Status</th>
		                            <th class="text-right">Action</th>
	                            </tfoot>

	                        </table>
	                    </div>
	                </div>
	            </div>
            @else                
                <x-flash-message 
                    class="flash-danger"  
                    title="Data not available!" 
                    message="Course data list is not available or not in correct format"  
                    message2=""  
                    :canClose="false" />                
            @endif

        </div>
    </div>
@stop



@section('script-files')
    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Switchery -->
    <script src="{{asset('admin/js/plugins/switchery/switchery.js')}}"></script>
    
    <!-- toastr js file-->
    <script src="{{asset('admin/js/plugins/toastr/toastr.min.js')}}"></script>

    <!-- sweetalert2 js file-->
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@stop





@section('javascript')
<script>


    //delete course
	$('.remove-course-btn').on('click', function(event){

		var courseId = $(this).data('courseid');
        var form     = $(this).parent().parent().find('form.course-remove');


		Swal.fire({
			title: 'Move course to trash',
			text: "Are you sure you want to move this course to trash?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3fcc98',
			confirmButtonText: 'Trash'
		}).then((result) => {
			if (result.isConfirmed) {
				

				$.ajax({
					url: "{{route('admin.courses.check-can-delete')}}",
					type: "post",
					async:true,
					dataType:'json',
					data:{
						_token : '{{ csrf_token() }}',
						courseId : courseId
					},
					success: function (response) {

						if(response.status === 'success'){

							if(response.canDelete === true){
								
								$.ajax({
									url: "{{route('admin.courses.check-empty')}}",
									type: "post",
									async:true,
									dataType:'json',
									data:{
										_token : '{{ csrf_token() }}',
										courseId : courseId
									},
									success: function (response) {

										if(response.status === 'success'){

											if(response.isEmpty === true){
												// course content is empty - submit form
												form.submit();
				                            
				                            }else{
												
												// course content is empty
												Swal.fire({
													title: 'Course already have content',
													text: "Are you sure you want to move this course to trash",
													icon: 'warning',
													showCancelButton: true,
													confirmButtonColor: '#d33',
													cancelButtonColor: '#3fcc98',
													confirmButtonText: 'Trash'
												
												}).then((result) => {
													if (result.isConfirmed) {
														//sumit form
														form.submit();
				                                    }
				                                });

				                            }
				                        }else if(response.status == 'error'){
											toastr[response.status](response.message);
				                        }
									},
									error:function(request,errorType,errorMessage)
									{
										//alert ('error - '+errorType+'with message - '+errorMessage);
										//toastr["success"]("User updated successfully! ", "Good Job!")
										toastr["error"]("checking course content is empty failed!")
									}
								});
                            
                            }else{                           	
								// course content is empty
								Swal.fire({
									title: 'Cannot move this course to trash',
									text: "Course already have related child table recods (coupons, course selections)",
									icon: 'warning',
									confirmButtonColor: '#3fcc98',
								});

                            }
                        }else if(response.status == 'error'){
							toastr[response.status](response.message);
                        }
					},
					error:function(request,errorType,errorMessage)
					{
						//alert ('error - '+errorType+'with message - '+errorMessage);
						//toastr["success"]("User updated successfully! ", "Good Job!")
						toastr["error"]("checking course is linked failed!")
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
			buttons: [
			@can(CourseAbilities::CREATE_COURSES)
				{
					text: 'Add course',
					action: function ( e, dt, node, config ) {
						//$('#addProjectModal').modal('show');
						//$('#add-modal').modal('show');
						window.location = '{{route ('admin.courses.create')}}';
						//  alert( 'Button activated' );
					},
					className: 'add-ct mb-3 btn-green '
				}
			@endcan
			],
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
			url: "{{route('admin.courses.change-status')}}",
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


