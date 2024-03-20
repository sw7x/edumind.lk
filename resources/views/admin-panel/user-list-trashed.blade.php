@php
    use App\Permissions\Abilities\UserManageAbilities;
@endphp

@extends('admin-panel.layouts.master',['title' => 'Trashed user list'])
@section('title','User list')

@section('css-files')

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
                <x-flash-message  
                    :class="Session::get('cls', 'flash-info')"  
                    :title="Session::get('msgTitle') ?? 'Info!'" 
                    :message="Session::get('message') ?? ''"  
                    :message2="Session::get('message2') ?? ''"  
                    :canClose="true" />
            @endif
            
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container mb-5">

                        <ul class="nav nav-tabs" role="tablist" id="tab-button-wrapper">                                
                            <li><a class="nav-link __active" data-toggle="tab" href="#tab-teachers">Teachers (Trashed)</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-students">Students (Trashed)</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-marketers">Marketers (Trashed)</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-editors">Editors (Trashed)</a></li>                                                           
                        </ul>

                        <div class="tab-content" id="tab-pane-wrapper">                                
                            @php
                            //dd($data);
                            //dd($teachers);
                            //dd($students);
                            //dd($marketers);
                            //dd($editors);
                            @endphp 

                            <div role="tabpanel" id="tab-teachers" class="tab-pane __active">
                                <div class="panel-body">
                                    @can(UserManageAbilities::VIEW_TEACHERS)

                                        @if(isset($teachers) && is_array($teachers))
                                            @if(!empty($teachers))                                                    
                                                <div class="table-responsive">
                                                    <table id="user-list-teacher" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                                                        <thead>
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
                                                        </thead>
                                                        <tbody>
                                                            @foreach($teachers as $item)                                                                
                                                                <tr class="teacher_{{$item['data']['id']}}">
                                                                    <td>{{$item['data']['fullName']}}</td>
                                                                    <td>{{$item['data']['email']}}<br> {{$item['data']['phone']}}</td>
                                                                    <td>{{$item['data']['username']}}</td>

                                                                    <td>
                                                                        @if($item['data']['profilePic'] != '')
                                                                            <a class="no-clickable popup-img effect" href="{{$item['data']['profilePic']}}" data-effect="mfp-zoom-in">
                                                                                <img src="{{$item['data']['profilePic']}}" width="100px" alt="">
                                                                            </a>
                                                                        @endif
                                                                    </td>

                                                                    <td>{{$item['data']['gender']}}</td>

                                                                    <td>
                                                                        @if(array_key_exists("isActivated", $item['data']))
                                                                            @if($item['data']['isActivated'] === true)
                                                                                <span class="label label-primary">Activated</span>
                                                                            @else
                                                                                <span class="label label-warning">Not Activated</span>
                                                                            @endif
                                                                        @else
                                                                            <span class="label">error</span>
                                                                        @endif
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        @if($item['data']['status'] === true)
                                                                            <span class="label label-primary">Active</span>
                                                                        @else
                                                                            <span class="label label-disable">Inactive</span>
                                                                        @endif
                                                                    </td>
                                                                    
                                                                    <td class="text-right">
                                                                        <div class="btn-group">
                                                                            @can(UserManageAbilities::ADMIN_PANEL_VIEW_USER, $item['dbRec'])
                                                                                <a href="{{route ('admin.users.show',$item['data']['id'])}}" class="btn-white btn btn-xs">View</a>
                                                                            @endcan

                                                                            @can(UserManageAbilities::DELETE_USERS)
                                                                                <a href="javascript:void(0);" class="restore-user-btn btn btn-primary btn-xs">Restore</a>
                                                                            @endcan

                                                                            @can(UserManageAbilities::DELETE_USERS)
                                                                                <a  href="javascript:void(0);" 
                                                                                    data-user-id="{{$item['data']['id']}}"
                                                                                    class="permanently-delete-user-btn btn-danger btn btn-xs">Delete</a>
                                                                            @endcan
                                                                        </div>
                                                                        
                                                                        @can(UserManageAbilities::DELETE_USERS)
                                                                            <form class="user-restore" action="{{ route('admin.users.restore', $item['data']['id']) }}" method="POST">
                                                                                @method('PATCH')
                                                                                @csrf
                                                                                <input name="userId" type="hidden" value="{{$item['data']['id']}}">
                                                                                <input name="userType" type="hidden" value="teacher">
                                                                            </form>
                                                                        @endcan

                                                                        @can(UserManageAbilities::DELETE_USERS)
                                                                            <form class="user-permanently-delete" action="{{ route('admin.users.permanently-delete', $item['data']['id']) }}" method="POST">
                                                                                @method('DELETE')
                                                                                @csrf
                                                                                <input name="userId" type="hidden" value="{{$item['data']['id']}}">
                                                                                <input name="userType" type="hidden" value="teacher">
                                                                            </form>
                                                                        @endcan
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
                                            @else
                                                <x-flash-message 
                                                    class="flash-info mt-3"  
                                                    title="No Trashed teachers!" 
                                                    message="" 
                                                    :canClose="false"/>
                                            @endif
                                        @else
                                            <x-flash-message 
                                                class="flash-danger mt-3" 
                                                title="Data not available!" 
                                                message="Teacher records are not available or not in correct format" 
                                                :canClose="false"/>
                                        @endif
                                    @else
                                        <div class="mt-3 px-2">
                                            <x-flash-message 
                                                class="flash-danger"  
                                                title="Permission Denied!" 
                                                message="you dont have permissions to view teachers table"  
                                                message2=""  
                                                :canClose="false" />
                                        </div>
                                    @endcan                              
                                </div>
                            </div>
                            <!--  -->

                            
                            <div role="tabpanel" id="tab-students" class="tab-pane">
                                <div class="panel-body">
                                    @can(UserManageAbilities::VIEW_STUDENTS)
                                        @if(isset($students) && is_array($students))
                                            @if(!empty($students))     
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
                                                                <tr class="student_{{$item['data']['id']}}">
                                                                    <td>{{$item['data']['fullName']}}</td>
                                                                    <td>{{$item['data']['email']}}<br> {{$item['data']['phone']}}</td>
                                                                    <td>{{$item['data']['username']}}</td>
                                                                    <td>{{$item['data']['gender']}}</td>

                                                                    <td>
                                                                        @if(array_key_exists("isActivated", $item['data']))
                                                                            @if($item['data']['isActivated'] === true)
                                                                                <span class="label label-primary">Activated</span>
                                                                            @else
                                                                                <span class="label label-warning">Not Activated</span>
                                                                            @endif
                                                                        @else
                                                                            <span class="label">error</span>
                                                                        @endif
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        @if($item['data']['status'] === true)
                                                                            <span class="label label-primary">Active</span>
                                                                        @else
                                                                            <span class="label label-disable">Inactive</span>
                                                                        @endif
                                                                    </td>
                                                                    
                                                                    <td class="text-right">
                                                                        <div class="btn-group">
                                                                            @can(UserManageAbilities::ADMIN_PANEL_VIEW_USER, $item['dbRec'])
                                                                                <a href="{{route ('admin.users.show',$item['data']['id'])}}" class="btn-white btn btn-xs">View</a>
                                                                            @endcan

                                                                            @can(UserManageAbilities::DELETE_USERS)
                                                                                <a href="javascript:void(0);" class="restore-user-btn btn btn-primary btn-xs">Restore</a>
                                                                            @endcan

                                                                            @can(UserManageAbilities::DELETE_USERS)
                                                                                <a  href="javascript:void(0);" 
                                                                                    data-user-id="{{$item['data']['id']}}"
                                                                                    class="permanently-delete-user-btn btn-danger btn btn-xs">Delete</a>
                                                                            @endcan
                                                                        </div>
                                                                        
                                                                        @can(UserManageAbilities::DELETE_USERS)
                                                                            <form class="user-restore" action="{{ route('admin.users.restore', $item['data']['id']) }}" method="POST">
                                                                                @method('PATCH')
                                                                                @csrf
                                                                                <input name="userId" type="hidden" value="{{$item['data']['id']}}">
                                                                                <input name="userType" type="hidden" value="student">
                                                                            </form>
                                                                        @endcan

                                                                        @can(UserManageAbilities::DELETE_USERS)
                                                                            <form class="user-permanently-delete" action="{{ route('admin.users.permanently-delete', $item['data']['id']) }}" method="POST">
                                                                                @method('DELETE')
                                                                                @csrf
                                                                                <input name="userId" type="hidden" value="{{$item['data']['id']}}">
                                                                                <input name="userType" type="hidden" value="student">
                                                                            </form>
                                                                        @endcan
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
                                            @else
                                                <x-flash-message 
                                                    class="flash-info mt-3"  
                                                    title="No Trashed students!" 
                                                    message="" 
                                                    :canClose="false"/>
                                            @endif
                                        @else
                                            <x-flash-message 
                                                class="flash-danger mt-3" 
                                                title="Data not available!" 
                                                message="Student records are not available or not in correct format" 
                                                :canClose="false"/>
                                        @endif
                                    @else
                                        <div class="mt-3 px-2">
                                            <x-flash-message 
                                                class="flash-danger"  
                                                title="Permission Denied!" 
                                                message="you dont have permissions to view students table"  
                                                message2=""  
                                                :canClose="false" />
                                        </div>
                                    @endcan
                                </div>
                            </div>                                    
                            <!--  -->


                            <div role="tabpanel" id="tab-marketers" class="tab-pane">
                                <div class="panel-body">
                                    @can(UserManageAbilities::VIEW_MARKETERS)
                                        @if(isset($marketers) && is_array($marketers))
                                            @if(!empty($marketers))    
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
                                                            <tr class="marketer_{{$item['data']['id']}}">
                                                                <td>{{$item['data']['fullName']}}</td>
                                                                <td>{{$item['data']['email']}}<br> {{$item['data']['phone']}}</td>
                                                                <td>{{$item['data']['username']}}</td>
                                                                <td>{{$item['data']['gender']}}</td>

                                                                <td>
                                                                    @if(array_key_exists("isActivated", $item['data']))
                                                                        @if($item['data']['isActivated'] === true)
                                                                            <span class="label label-primary">Activated</span>
                                                                        @else
                                                                            <span class="label label-warning">Not Activated</span>
                                                                        @endif
                                                                    @else
                                                                        <span class="label">error</span>
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    @if($item['data']['status'] === true)
                                                                        <span class="label label-primary">Active</span>
                                                                    @else
                                                                        <span class="label label-disable">Inactive</span>
                                                                    @endif
                                                                </td>

                                                                <td class="text-right">
                                                                    <div class="btn-group">
                                                                        @can(UserManageAbilities::ADMIN_PANEL_VIEW_USER, $item['dbRec'])
                                                                            <a href="{{route ('admin.users.show',$item['data']['id'])}}" class="btn-white btn btn-xs">View</a>
                                                                        @endcan

                                                                        @can(UserManageAbilities::DELETE_USERS)
                                                                            <a href="javascript:void(0);" class="restore-user-btn btn btn-primary btn-xs">Restore</a>
                                                                        @endcan

                                                                        @can(UserManageAbilities::DELETE_USERS)
                                                                            <a  href="javascript:void(0);" 
                                                                                data-user-id="{{$item['data']['id']}}"
                                                                                class="permanently-delete-user-btn btn-danger btn btn-xs">Delete</a>
                                                                        @endcan
                                                                    </div>
                                                                    
                                                                    @can(UserManageAbilities::DELETE_USERS)
                                                                        <form class="user-restore" action="{{ route('admin.users.restore', $item['data']['id']) }}" method="POST">
                                                                            @method('PATCH')
                                                                            @csrf
                                                                            <input name="userId" type="hidden" value="{{$item['data']['id']}}">
                                                                            <input name="userType" type="hidden" value="marketer">
                                                                        </form>
                                                                    @endcan

                                                                    @can(UserManageAbilities::DELETE_USERS)
                                                                        <form class="user-permanently-delete" action="{{ route('admin.users.permanently-delete', $item['data']['id']) }}" method="POST">
                                                                            @method('DELETE')
                                                                            @csrf
                                                                            <input name="userId" type="hidden" value="{{$item['data']['id']}}">
                                                                            <input name="userType" type="hidden" value="marketer">
                                                                        </form>
                                                                    @endcan
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
                                            @else
                                                <x-flash-message 
                                                    class="flash-info mt-3"  
                                                    title="No Trashed marketers!" 
                                                    message="" 
                                                    :canClose="false"/>
                                            @endif
                                        @else
                                            <x-flash-message 
                                                class="flash-danger mt-3" 
                                                title="Data not available!" 
                                                message="Marketer records are not available or not in correct format" 
                                                :canClose="false"/>
                                        @endif
                                    @else
                                        <div class="mt-3 px-2">
                                            <x-flash-message 
                                                class="flash-danger"  
                                                title="Permission Denied!" 
                                                message="you dont have permissions to view marketers table"  
                                                message2=""  
                                                :canClose="false" />
                                        </div>
                                    @endcan
                                </div>
                            </div>
                            <!--  -->


                            <div role="tabpanel" id="tab-editors" class="tab-pane">
                                <div class="panel-body">
                                    @can(UserManageAbilities::VIEW_EDITORS)
                                        @if(isset($editors) && is_array($editors))
                                            @if(!empty($editors))    
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
                                                            <tr class="editors_{{$item['data']['id']}}">
                                                                <td>{{$item['data']['fullName']}}</td>
                                                                <td>{{$item['data']['email']}}<br> {{$item['data']['phone']}}</td>
                                                                <td>{{$item['data']['username']}}</td>
                                                                <td>{{$item['data']['gender']}}</td>

                                                                <td>
                                                                    @if(array_key_exists("isActivated", $item['data']))
                                                                        @if($item['data']['isActivated'] === true)
                                                                            <span class="label label-primary">Activated</span>
                                                                        @else
                                                                            <span class="label label-warning">Not Activated</span>
                                                                        @endif
                                                                    @else
                                                                        <span class="label">error</span>
                                                                    @endif
                                                                </td>
                                                                
                                                                <td>
                                                                    @if($item['data']['status'] === true)
                                                                        <span class="label label-primary">Active</span>
                                                                    @else
                                                                        <span class="label label-disable">Inactive</span>
                                                                    @endif
                                                                </td>
                                                        
                                                                <td class="text-right">
                                                                    <div class="btn-group">
                                                                        @can(UserManageAbilities::ADMIN_PANEL_VIEW_USER, $item['dbRec'])
                                                                            <a href="{{route ('admin.users.show',$item['data']['id'])}}" class="btn-white btn btn-xs">View</a>
                                                                        @endcan

                                                                        @can(UserManageAbilities::DELETE_USERS)
                                                                            <a href="javascript:void(0);" class="restore-user-btn btn btn-primary btn-xs">Restore</a>
                                                                        @endcan

                                                                        @can(UserManageAbilities::DELETE_USERS)
                                                                            <a  href="javascript:void(0);"
                                                                                data-user-id="{{$item['data']['id']}}"
                                                                                class="permanently-delete-user-btn btn-danger btn btn-xs">Delete</a>
                                                                        @endcan
                                                                    </div>
                                                                    
                                                                    @can(UserManageAbilities::DELETE_USERS)
                                                                        <form class="user-restore" action="{{ route('admin.users.restore', $item['data']['id']) }}" method="POST">
                                                                            @method('PATCH')
                                                                            @csrf
                                                                            <input name="userId" type="hidden" value="{{$item['data']['id']}}">
                                                                            <input name="userType" type="hidden" value="editor">
                                                                        </form>
                                                                    @endcan

                                                                    @can(UserManageAbilities::DELETE_USERS)
                                                                        <form class="user-permanently-delete" action="{{ route('admin.users.permanently-delete', $item['data']['id']) }}" method="POST">
                                                                            @method('DELETE')
                                                                            @csrf
                                                                            <input name="userId" type="hidden" value="{{$item['data']['id']}}">
                                                                            <input name="userType" type="hidden" value="editor">
                                                                        </form>
                                                                    @endcan
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
                                            @else
                                                <x-flash-message 
                                                    class="flash-info mt-3"  
                                                    title="No Trashed editors!" 
                                                    message="" 
                                                    :canClose="false"/>
                                            @endif
                                        @else
                                            <x-flash-message 
                                                class="flash-danger mt-3" 
                                                title="Data not available!" 
                                                message="Editor records are not available or not in correct format" 
                                                :canClose="false"/>
                                        @endif
                                    @else
                                        <div class="mt-3 px-2">
                                            <x-flash-message 
                                                class="flash-danger"  
                                                title="Permission Denied!" 
                                                message="you dont have permissions to view editors table"  
                                                message2=""  
                                                :canClose="false" />
                                        </div>
                                    @endcan
                                </div>
                            </div>                                       
                            <!--  -->

                        
                        </div>
                    </div>
                </div>
            </div>
              
            

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



        $('.restore-user-btn').on('click', function(event){

			Swal.fire({
				title: 'Restore user',
				text: "Are you sure you want to Restore this user ?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3fcc98',
				confirmButtonText: 'Restore'
			}).then((result) => {
				if (result.isConfirmed) {
					$(this).parent().parent().find('form.user-restore').submit();               
				}
			});

			event.preventDefault();
        });


        $('.permanently-delete-user-btn').on('click', function(event){
            var userId   = $(this).data('user-id');
            var form     = $(this).parent().parent().find('form.user-permanently-delete');
            console.log

            Swal.fire({
                title: 'Permanently delete the user',
                text: "Are you sure you want to permanently delete this user ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3fcc98',
                confirmButtonText: 'Delete'
            }).then((result) => {

                if (result.isConfirmed) {
                    
                    $.ajax({
                        url: "{{route('admin.users.check-can-delete')}}",
                        type: "post",
                        async:true,
                        dataType:'json',
                        data:{
                            _token : '{{ csrf_token() }}',
                            userId : userId
                        },
                        success: function (response) {
                            console.log(response);
                            if(response.status === 'success'){

                                if(response.canDelete === true){
                                    // course content is empty - submit form
                                    form.submit();
                                
                                }else{
                                    
                                    // course content is empty
                                    Swal.fire({
                                        title: 'Cannot permanently delete this user',
                                        text: "User already have related child table recods (coupons, course selections)",
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
                            toastr["error"]("User already have related child table recods (coupons, course selections)!");
                        }
                    });

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
				"targets": [1,2,3,4,5,6,7],
				"searchable": false
			}],			
		});

		$('#user-list-stud').DataTable({
			pageLength: 10,
			ordering: false,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [],
			"columnDefs": [{
				"targets": [1,2,3,4,5,6],                
				"searchable": false
			}],			
		});

		$('#user-list-marketer').DataTable({
			pageLength: 10,
			ordering: false,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [],
			"columnDefs": [{
				"targets": [1,2,3,4,5,6],
				"searchable": false
			}],			
		});


		$('#user-list-editors').DataTable({
			pageLength: 10,
			ordering: false,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [],
			"columnDefs": [{
				"targets": [1,2,3,4,5,6],
				"searchable": false
			}],			
		});


    });
</script>
@stop
