@extends('admin-panel.layouts.master')
@section('title','Approve student changes')


@section('css-files')

    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

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

            
            <div class="ibox">
                <div class="ibox-content">
                   
                    // todo - when approve record disappear from table
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
                                    <th>Approve /<br/> Reject<br/> <small>by admin</small></th>
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
                                            <a class="no-clickable popup-img effect" href="{{$item->profile_pic}}" data-effect="mfp-zoom-in">
                                                <img src="{{$item->profile_pic}}" width="100px" alt="">
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
                                            <a href="{{route ('admin.user.view-un-approved-teacher',$item->id)}}" class="btn-white btn btn-xs">View</a>
                                            <a href="javascript:void(0);" class="delete-user-btn btn-danger btn btn-xs">Delete</a>
                                        </div>
                                        <form class="user-destroy" action="{{ route('admin.user.destroy', $item->id) }}" method="POST">
                                            @method('DELETE')
                                            <input name="userId" type="hidden" value="{{$item->id}}">
                                            <input name="userType" type="hidden" value="approve.teacher">

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
                                    <th>Approve /<br/> Reject<br/> <small>by admin</small></th>
                                    <th class="text-right">Action</th>
                                </tr>
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

    <!-- Magnific Popup core JS file -->
    <script src="{{asset('admin/js/jquery.magnific-popup.min.js')}}"></script>


    <!-- sweetalert2 js file-->
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- toastr js file-->
    <script src="{{asset('admin/js/plugins/toastr/toastr.min.js')}}"></script>


@stop


@section('javascript')
<script>




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

//                  Swal.fire(
//                      'Deleted!',
//                      'Your file has been deleted.',
//                      'success'
//                  )
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
            buttons: [],
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

        





        

    });
</script>
@stop














