@php
    use App\Permissions\Abilities\SubjectAbilities;
@endphp

@extends('admin-panel.layouts.master',['title' => 'Trashed subject list'])
@section('title','Trashed subject list')

@section('css-files')
    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">

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

            @php
                //dd($data);
            @endphp


            @if(isset($data) && is_array($data))            
                @if(!empty($data))    
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table id="category-list-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Status <small>(Published/Draft)</small></th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($data as $item)
                                        <tr class="subject_{{$item['data']['id']}}">
                                            <td>{{$item['data']['name']}}</td>
                                            <td>{{mb_strimwidth($item['data']['description'], 0, 100, '...')}}</td>

                                            <td>
                                                @if($item['data']['image'] != '')
                                                    <a class="no-clickable popup-img effect" href="{{$item['data']['image']}}" data-effect="mfp-zoom-in">
                                                        <img src="{{$item['data']['image']}}" width="100px" alt="">
                                                    </a>
                                                @endif
                                            </td>

                                            <td>
                                                @if($item['data']['status'] == App\Models\Subject::PUBLISHED)
                                                    <span class="label label-primary">Published</span>
                                                @else
                                                    <span class="label label-disable">Draft</span>
                                                @endif
                                            </td>

                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <a href="{{route ('admin.subjects.show',$item['data']['id'])}}" class="btn-white btn btn-xs">View</a>
                                                    
                                                    @can(SubjectAbilities::DELETE_SINGLE_SUBJECT, $item['dbRec'])
                                                        <a href="javascript:void(0);" class="restore-subject-btn btn-primary btn btn-xs">Restore</a>
                                                    @endcan
                                                    
                                                    @can(SubjectAbilities::DELETE_SINGLE_SUBJECT, $item['dbRec'])
                                                        <a  href="javascript:void(0);" 
                                                            data-course_count={{$item['data']['course_count']}}
                                                            class="permanently-delete-subject-btn btn-danger btn btn-xs">Delete</a>
                                                    @endcan
                                                </div>
                                                
                                                @can(SubjectAbilities::DELETE_SINGLE_SUBJECT, $item['dbRec'])
                                                    <form class="subject-restore" action="{{ route('admin.subjects.restore', $item['data']['id']) }}" method="POST">
                                                        @method('PATCH')
                                                        @csrf
                                                    </form>
                                                @endcan

                                                @can(SubjectAbilities::DELETE_SINGLE_SUBJECT, $item['dbRec'])
                                                    <form class="subject-permanently-delete" action="{{ route('admin.subjects.permanently-delete', $item['data']['id']) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                    </form>
                                                @endcan
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Status <small>(Published/Draft)</small></th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <x-flash-message 
                        class="flash-info"  
                        title="No Subjects!" 
                        message=""  
                        message2=""  
                        :canClose="false" />
                @endif
            @else                
                <x-flash-message 
                    class="flash-danger"  
                    title="Data not available!" 
                    message="Subject list data is not available or not in correct format"  
                    message2=""  
                    :canClose="false" />                
            @endif

        </div>
    </div>
@stop



@section('script-files')
    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Magnific Popup core JS file -->
    <script src="{{asset('admin/js/jquery.magnific-popup.min.js')}}"></script>

    <!-- sweetalert2 js file-->
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
@stop


@section('javascript')
<script>

	$(document).ready(function() {

		$('.permanently-delete-subject-btn').on('click', function(event){

			Swal.fire({
				title: 'Permanently delete the subject',
				text: "Are you sure you want to permanently delete this subject?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3fcc98',
				confirmButtonText: 'Permanently delete'
			}).then((result) => {
				if (result.isConfirmed) {
					//todo
					
                    let courseCount = $(this).data('course_count');                    
                    let form        = $(this).parent().parent().find('form.subject-permanently-delete');

                    if(courseCount > 0){
                        Swal.fire({
                            title: 'Are you sure you want to permanently delete this subject',
                            text: "This subject has associated course records. Deleting it will cause the course to exist without a subject. Please confirm your action. ?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3fcc98',
                            confirmButtonText: 'Permanently delete'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    }else{
                        form.submit();
                    }            
                    //$(this).parent().parent().find('form.subject-permanently-delete').submit();
				}
			});
			event.preventDefault();
		});



        $('.restore-subject-btn').on('click', function(event){
            Swal.fire({
                title: 'Restore subject',
                text: "Are you sure you want to restore this subject ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3fcc98',
                confirmButtonText: 'Restore'
            }).then((result) => {
                if (result.isConfirmed) {
                    //todo
                    $(this).parent().parent().find('form.subject-restore').submit();
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


		$('#category-list-tbl').DataTable({
			"columns": [
				null,
				{ "width": "40%" },
				null,
				null,
				null
			],
			"ordering": false,
			pageLength: 10,
			responsive: true,
			// dom: '<"html5buttons"B>lTfgitp',
			dom: 'Bfrtip',
			lengthChange: false,
			
            buttons: []

		});
		$("#category-list-tbl thead tr").css("border-bottom","5px solid #000");
	});

</script>
@stop
