@php    
	use App\Permissions\Abilities\CourseAbilities;
@endphp


@extends('admin-panel.layouts.master',['title' => 'Trashed course list'])
@section('title','Trashed course list')


@section('css-files')
    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- sweetalert2 CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">

@stop
@php
	//dd2($data);
@endphp




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
		                                <th>Teacher</th>
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

			                                <td>
			                                	{{$item['data']['teacherName'] ?? ''}}<br>
			                                	@if($item['data']['authorRecAvailability'])
			                                		<span class="text-red">{{$item['data']['authorRecAvailability']}}</span>
			                                	@endif

			                                </td>

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
			                                	@if($item['data']['status'] == App\Models\Course::PUBLISHED)
                                                    <span class="label label-primary">Published</span>
                                                @else
                                                    <span class="label label-disable">Draft</span>
                                                @endif
			                                </td>

			                                <td class="text-right">
			                                    <div class="btn-group">
			                                        
			                                        @can(CourseAbilities::ADMIN_PANEL_VIEW_COURSE, $item['dbRec'])
			                                        	<a href="{{route ('admin.courses.show',$item['data']['id'])}}" class="btn-white btn btn-xs">View</a>
			                                        @endcan
													
													@can(CourseAbilities::DELETE_SINGLE_COURSE, $item['dbRec'])
			                                        	<a href="javascript:void(0);" class="restore-course-btn btn-primary btn btn-xs">Restore</a>
			                                        @endcan
													
													@can(CourseAbilities::DELETE_SINGLE_COURSE, $item['dbRec'])
			                                        	<a 	href="javascript:void(0);" 
			                                        		data-courseId="{{$item['data']['id']}}"
			                                        		class="permanently-delete-course-btn btn-danger btn btn-xs">Delete</a>
			                                    	@endcan
			                                    </div>
			                                    
			                                    @can(CourseAbilities::DELETE_SINGLE_COURSE, $item['dbRec'])
				                                    <form class="course-restore" action="{{ route('admin.courses.restore', $item['data']['id']) }}" method="POST">
				                                        @method('PATCH')
				                                        @csrf
				                                    </form>
			                                    @endcan				                                    

			                                    @can(CourseAbilities::DELETE_SINGLE_COURSE, $item['dbRec'])
				                                    <form class="course-permanently-delete" action="{{ route('admin.courses.permanently-delete', $item['data']['id']) }}" method="POST">
				                                        @method('DELETE')
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
		                            <th>Teacher</th>		                           
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
                    class="flash-info"  
                    title="No Courses!" 
                    message=""  
                    message2=""  
                    :canClose="false" />
            @endif

        </div>
    </div>
@stop



@section('script-files')
    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- sweetalert2 js file-->
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@stop





@section('javascript')
<script>



    //delete course
	$('.permanently-delete-course-btn').on('click', function(event){

		var courseId = $(this).data('courseid');
        var form     = $(this).parent().parent().find('form.course-permanently-delete');

		Swal.fire({
			title: 'Permanently delete the course',
			text: "Are you sure you want permanently delete this course?",
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
													text: "Are you sure you want to permanently delete this course",
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
									title: 'Cannot permanently delete this course',
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



	$('.restore-course-btn').on('click', function(event){
        Swal.fire({
            title: 'Restore the course',
            text: "Are you sure you want to restore this course ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3fcc98',
            confirmButtonText: 'Restore'
        }).then((result) => {
            if (result.isConfirmed) {
                //todo
                $(this).parent().parent().find('form.course-restore').submit();
            }
        });
        event.preventDefault();
    });


	$(document).ready(function() {
		$('#course-list').DataTable({
			pageLength: 10,
			ordering: false,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [],
			"columnDefs": [{
				"targets": [1,2,3,4,5],
				"searchable": false

			}],			
		});
	});	

</script>
@stop


