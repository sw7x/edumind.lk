@php
    use App\Permissions\Abilities\UserManageAbilities;
@endphp

@extends('admin-panel.layouts.master')
@section('title','Add user')

@section('css-files')

    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- bootstrap datapicker -->
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.css')}}">
    <!-- <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">-->

    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond-plugin-image-preview.min.css')}}">
    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond.min.css')}}">

@stop


@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
                                                     
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container">
                        @canany([
                            UserManageAbilities::CREATE_TEACHERS,
                            UserManageAbilities::CREATE_STUDENTS,
                            UserManageAbilities::CREATE_MARKETERS,
                            UserManageAbilities::CREATE_EDITORS
                        ])
                            <ul class="nav nav-tabs" role="tablist">                            
                                @can(UserManageAbilities::CREATE_TEACHERS)
                                    <li><a class="nav-link active" data-toggle="tab" href="#tab-teachers">Add teachers</a></li>
                                @endcan
                                
                                @can(UserManageAbilities::CREATE_STUDENTS)
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-students">Add students</a></li>
                                @endcan
                                
                                @can(UserManageAbilities::CREATE_MARKETERS)
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-marketers">Add marketers</a></li>
                                @endcan
                                
                                @can(UserManageAbilities::CREATE_EDITORS)
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-editor">Add Editor</a></li>
                                @endcan
                            </ul>

                            <div class="tab-content mb-3">
                                @can(UserManageAbilities::CREATE_TEACHERS)
                                    <div role="tabpanel" id="tab-teachers" class="tab-pane active">
                                        <div class="panel-body">                                    
                                            @foreach ($errors->all() as $error)
                                                {{-- $error --}}
                                            @endforeach                                    

                                            @if(Session::has('teacher_add_message'))
                                                <x-flash-message  
                                                    :class="Session::get('teacher_add_cls', 'flash-info')"  
                                                    :title="Session::get('teacher_add_msgTitle') ?? 'Info!'" 
                                                    :message="Session::get('teacher_add_message') ?? 'Info!'"  
                                                    :message2="Session::get('teacher_add_message2') ?? ''"  
                                                    :canClose="true" />
                                            @endif

                                            <form class="" id="" action="{{route('admin.users.store-teacher')}}" method="post">
                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="teacher_name" class="form-control" required value="{{ old('teacher_name') }}">
                                                        @if ($errors->has('teacher_name'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('teacher_name') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Username</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="teacher_uname" class="form-control" value="{{ old('teacher_uname') }}">
                                                        <small>Leave blank if you want to auto generate username</small><br>
                                                        <small>Only aplha numeric charaters allowed (no spaces, no special characters)</small>
                                                        @if (Session::get('is_teacher_usernameFill')=='y' && $errors->has('teacher_uname'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('teacher_uname') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="qemail" name="teacher_email" class="form-control" required value="{{ old('teacher_email') }}">
                                                        @if ($errors->has('teacher_email'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('teacher_email') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="tel" name="teacher_phone" class="form-control" required value="{{ old('teacher_phone') }}">
                                                        @if ($errors->has('teacher_phone'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('teacher_phone') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Password <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8 password-container">
                                                        <input type="password" class="password_field form-control" placeholder="Password (6 to 12 alpha numeric characters) *"
                                                               name="teacher_password" maxlength="12" minlength="6" required value="{{ old('teacher_password') }}"/>
                                                        <button type="button" id="btnToggle" class="pw-toggle" style="right: 20px;">
                                                            <i id="eyeIcon" class="fa fa-eye"></i>
                                                        </button>
                                                        @if ($errors->has('teacher_password'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('teacher_password') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Year of birth</label>
                                                    <div class="col-sm-8 input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="teacher_birth_year">
                                                        <div class="w-full">
                                                            @if ($errors->has('teacher_birth_year'))
                                                                <ul class="mt-1">
                                                                    @foreach ($errors->get('teacher_birth_year') as $error)
                                                                        <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row"><label class="col-sm-4 col-form-label">Education qualifications</label>
                                                    <div class="col-sm-8">
                                                        <div class="border border-edu">
                                                            <textarea rows="3" class="form-control" name="teacher_edu_details">{{ old('teacher_edu_details') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row"><label class="col-sm-4 col-form-label">Profile image</label>
                                                    <div class="col-sm-8">
                                                        <input type="file"
                                                               class="filepond-img teacher_profile_img"
                                                               name="teacher_profile_img"
                                                               accept="image/webp, image/png, image/jpeg, image/gif"
                                                               data-max-file-size="1MB"/>
                                                        <p>Image size : 500x500</p>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control m-b" required id="teacher_gender" name="teacher_gender" value="{{ old('teacher_gender') }}">
                                                            <option></option>
                                                            <option {{ old("teacher_gender") == 'male' ? "selected":"" }} value="male">Male</option>
                                                            <option {{ old("teacher_gender") == 'female' ? "selected":"" }} value="female">Female</option>
                                                            <option {{ old("teacher_gender") == 'other' ? "selected":"" }} value="other">Other</option>
                                                        </select>
                                                        @if ($errors->has('teacher_gender'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('teacher_gender') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Submit status</label>
                                                    <div class="col-sm-8">
                                                        <div class="i-checks">
                                                            <label> <input {{  old('teacher_stat') == "enable" ? "checked" : (old('teacher_stat') =="disable" ? "" : "checked") }}
                                                                           type="radio" checked value="enable" name="teacher_stat"> <i></i> Enable </label>
                                                        </div>
                                                        <div class="i-checks">
                                                            <label> <input {{  old('teacher_stat') == "disable" ? "checked" : "" }}
                                                                           type="radio" value="disable" name="teacher_stat"> <i></i> Disable </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                {{csrf_field ()}}
                                                <div class="form-group row">
                                                    <div class="col-sm-4 offset-sm-4">
                                                        <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                                        <button class="btn btn-danger btn-sm" type="reset">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endcan

                                @can(UserManageAbilities::CREATE_STUDENTS)
                                    <div role="tabpanel" id="tab-students" class="tab-pane">
                                        <div class="panel-body">
                                            @foreach ($errors->all() as $error)
                                                {{-- $error --}}
                                            @endforeach

                                            @if(Session::has('student_add_message'))
                                                <x-flash-message  
                                                    :class="Session::get('student_add_cls', 'flash-info')"  
                                                    :title="Session::get('student_add_msgTitle') ?? 'Info!'" 
                                                    :message="Session::get('student_add_message') ?? 'Info!'"  
                                                    :message2="Session::get('student_add_message2') ?? ''"  
                                                    :canClose="true" />
                                            @endif

                                            <form class="" id="" action="{{route('admin.users.store-student')}}" method="post">
                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="stud_name" class="form-control" required value="{{ old('stud_name')}}">
                                                        @if ($errors->has('stud_name'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('stud_name') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>


                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Username</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="stud_uname" class="form-control" value="{{ old('stud_uname')}}">
                                                        <small>Leave blank if you want to auto generate username</small><br>
                                                        <small>Only aplha numeric charaters allowed (no spaces, no special characters)</small>
                                                        @if (Session::get('is_student_usernameFill')=='y' && $errors->has('stud_uname'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('stud_uname') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="email" name="stud_email" class="form-control" required value="{{ old('stud_email')}}">
                                                        @if ($errors->has('stud_email'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('stud_email') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="tel" name="stud_phone" class="form-control" required value="{{ old('stud_phone')}}">
                                                        @if ($errors->has('stud_phone'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('stud_phone') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Password <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8 password-container">
                                                        <input type="password" class="password_field form-control" placeholder="Password (6 to 12 alpha numeric characters) *"
                                                               name="stud_password" maxlength="12" minlength="6" required value="{{ old('stud_password')}}"/>
                                                        <button type="button" id="btnToggle" class="pw-toggle" style="right: 20px;">
                                                            <i id="eyeIcon" class="fa fa-eye"></i>
                                                        </button>
                                                        @if ($errors->has('stud_password'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('stud_password') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Year of birth</label>
                                                    <div class="col-sm-8 input-group date">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="stud_birth_year">
                                                        <div class="w-full">
                                                            @if ($errors->has('stud_birth_year'))
                                                                <ul class="mt-1">
                                                                    @foreach ($errors->get('stud_birth_year') as $error)
                                                                        <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row"><label class="col-sm-4 col-form-label">Student details</label>
                                                    <div class="col-sm-8">
                                                        <div class="border border-edu">
                                                            <textarea rows="3" class="form-control" name="stud_details"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control m-b" id="stud_gender" name="stud_gender" >
                                                            <option></option>
                                                            <option {{ old("stud_gender") == 'male' ? "selected":"" }} value="male">Male</option>
                                                            <option {{ old("stud_gender") == 'female' ? "selected":"" }} value="female">Female</option>
                                                            <option {{ old("stud_gender") == 'other' ? "selected":"" }} value="other">Other</option>
                                                        </select>
                                                        @if ($errors->has('stud_gender'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('stud_gender') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Submit status</label>
                                                    <div class="col-sm-8">
                                                        <div class="i-checks">
                                                            <label> <input {{  old('student_stat') == "enable" ? "checked" : (old('student_stat') =="disable" ? "" : "checked") }}
                                                                           type="radio" value="enable" name="student_stat">
                                                                <i></i> Enable </label>
                                                        </div>
                                                        <div class="i-checks">
                                                            <label> <input {{  old('student_stat') == "disable" ? "checked" : "" }}
                                                                           type="radio" value="disable" name="student_stat">
                                                                <i></i> Disable </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                {{csrf_field ()}}
                                                <div class="form-group row">
                                                    <div class="col-sm-4 offset-sm-4">
                                                        <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                                        <button class="btn btn-danger btn-sm" type="reset">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endcan

                                @can(UserManageAbilities::CREATE_MARKETERS)
                                    <div role="tabpanel" id="tab-marketers" class="tab-pane">
                                        <div class="panel-body">
                                            @foreach ($errors->all() as $error)
                                                {{-- $error --}}
                                            @endforeach

                                            @if(Session::has('marketer_add_message'))
                                                <x-flash-message  
                                                    :class="Session::get('marketer_add_cls', 'flash-info')"  
                                                    :title="Session::get('marketer_add_msgTitle') ?? 'Info!'" 
                                                    :message="Session::get('marketer_add_message') ?? 'Info!'"  
                                                    :message2="Session::get('marketer_add_message2') ?? ''"  
                                                    :canClose="true" />
                                            @endif

                                            <form class="" id="" action="{{route('admin.users.store-marketer')}}" method="post">
                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="marketer_name" class="form-control"  required value="{{ old('marketer_name')}}">
                                                        @if ($errors->has('marketer_name'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('marketer_name') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Username</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="marketer_uname" class="form-control" value="{{ old('marketer_uname')}}">
                                                        <small>Leave blank if you want to auto generate username</small><br>
                                                        <small>Only aplha numeric charaters allowed (no spaces, no special characters)</small>
                                                        @if (Session::get('is_marketer_usernameFill')=='y' && $errors->has('marketer_uname'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('marketer_uname') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="email" name="marketer_email" class="form-control" required value="{{ old('marketer_email')}}">
                                                        @if ($errors->has('marketer_email'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('marketer_email') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="tel" name="marketer_phone" class="form-control" required value="{{ old('marketer_phone')}}">
                                                        @if ($errors->has('marketer_phone'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('marketer_phone') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Password <span class="text-red-500 text-sm font-bold">*</span></label>

                                                    <div class="col-sm-8 password-container">
                                                        <input type="password" class="password_field form-control" placeholder="Password (6 to 12 alpha numeric characters) *"
                                                               name="marketer_password" maxlength="12" minlength="6" required value="{{ old('marketer_password')}}"/>
                                                        <button type="button" id="btnToggle" class="pw-toggle" style="right: 20px;">
                                                            <i id="eyeIcon" class="fa fa-eye"></i>
                                                        </button>
                                                        @if ($errors->has('marketer_password'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('marketer_password') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control m-b" id="marketer_gender" name="marketer_gender"  required>
                                                            <option></option>
                                                            <option {{ old("marketer_gender") == 'male' ? "selected":"" }} value="male">Male</option>
                                                            <option {{ old("marketer_gender") == 'female' ? "selected":"" }} value="female">Female</option>
                                                            <option {{ old("marketer_gender") == 'other' ? "selected":"" }} value="other">Other</option>
                                                        </select>
                                                        @if ($errors->has('marketer_gender'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('marketer_gender') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Submit status</label>
                                                    <div class="col-sm-8">
                                                        <div class="i-checks">
                                                            <label> <input {{  old('marketer_stat') == "enable" ? "checked" : (old('marketer_stat') =="disable" ? "" : "checked") }}
                                                                           type="radio" checked value="enable" name="marketer_stat"> <i></i> Enable </label>
                                                        </div>
                                                        <div class="i-checks">
                                                            <label> <input {{  old('marketer_stat') == "disable" ? "checked" : "" }}
                                                                           type="radio" value="disable" name="marketer_stat"> <i></i> Disable </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                {{csrf_field ()}}
                                                <div class="form-group row">
                                                    <div class="col-sm-4 offset-sm-4">
                                                        <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                                        <button class="btn btn-danger btn-sm" type="reset">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endcan

                                @can(UserManageAbilities::CREATE_EDITORS)
                                    <div role="tabpanel" id="tab-editor" class="tab-pane">
                                        <div class="panel-body">
                                            @if(Session::has('editor_add_message'))
                                                <x-flash-message  
                                                    :class="Session::get('editor_add_cls', 'flash-info')"  
                                                    :title="Session::get('editor_add_msgTitle') ?? 'Info!'" 
                                                    :message="Session::get('editor_add_message') ?? 'Info!'"  
                                                    :message2="Session::get('editor_add_message2') ?? ''"  
                                                    :canClose="true" />
                                            @endif

                                            <form class="" id="" action="{{route('admin.users.store-editor')}}" method="post">
                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="editor_name" class="form-control" required value="{{ old('editor_name')}}">
                                                        @if ($errors->has('editor_name'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('editor_name') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Username</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="editor_uname" class="form-control" value="{{ old('editor_uname')}}">
                                                        <small>Leave blank if you want to auto generate username</small><br>
                                                        <small>Only aplha numeric charaters allowed (no spaces, no special characters)</small>
                                                        @if (Session::get('is_editor_usernameFill')=='y' && $errors->has('editor_uname'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('editor_uname') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="email" name="editor_email" class="form-control" required value="{{ old('editor_email')}}">
                                                        @if ($errors->has('editor_email'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('editor_email') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <input type="tel" name="editor_phone" class="form-control" required value="{{ old('editor_phone')}}">
                                                        @if ($errors->has('editor_phone'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('editor_phone') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Password <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8 password-container">
                                                        <input type="password" class="password_field form-control" placeholder="Password (6 to 12 alpha numeric characters) *"
                                                               name="editor_password" maxlength="12" minlength="6" required value="{{ old('editor_password')}}"/>
                                                        <button type="button" id="btnToggle" class="pw-toggle" style="right: 20px;">
                                                            <i id="eyeIcon" class="fa fa-eye"></i>
                                                        </button>
                                                        @if ($errors->has('editor_password'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('editor_password') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control m-b" id="editor_gender" name="editor_gender" required>
                                                            <option></option>
                                                            <option {{ old("editor_gender") == 'male' ? "selected":"" }} value="male">Male</option>
                                                            <option {{ old("editor_gender") == 'female' ? "selected":"" }} value="female">Female</option>
                                                            <option {{ old("editor_gender") == 'other' ? "selected":"" }} value="other">Other</option>
                                                        </select>
                                                        @if ($errors->has('editor_gender'))
                                                            <ul class="mt-1">
                                                                @foreach ($errors->get('editor_gender') as $error)
                                                                    <li class="text-red-600 text-xs font-bold">{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Submit status</label>
                                                    <div class="col-sm-8">
                                                        <div class="i-checks">
                                                            <label> <input {{  old('editor_stat') == "enable" ? "checked" : (old('editor_stat') =="disable" ? "" : "checked") }}
                                                                           type="radio" checked value="enable" name="editor_stat"> <i></i> Enable </label>
                                                        </div>
                                                        <div class="i-checks">
                                                            <label> <input {{  old('editor_stat') == "disable" ? "checked" : "" }}
                                                                           type="radio" value="disable" name="editor_stat"> <i></i> Disable </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>

                                                {{csrf_field ()}}
                                                <div class="form-group row">
                                                    <div class="col-sm-4 offset-sm-4">
                                                        <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                                        <button class="btn btn-danger btn-sm" type="reset">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        @else
                            <x-flash-message 
                                class="flash-danger"  
                                title="Permission Denied!" 
                                message="you dont have permissions to crete users"  
                                message2=""  
                                :canClose="false" />
                        @endcanany

                    </div>
                </div>
            </div>
            
        </div>
    </div>
@stop




@section('script-files')
    <!-- iCheck -->
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>

    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>

    <!-- Data picker -->
    <script src="{{asset('admin/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

    <!-- SUMMERNOTE -->
    <!-- <script src="../assets/summernote-0.8.18/summernote-lite.js"></script> -->
    <script src="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.js')}}"></script>


    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-encode.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-size.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-exif-orientation.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-preview.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-type.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond.min.js')}}"></script>
@stop


@section('javascript')
<script>

	/**/
    (function () {
		// We want to preview images, so we need to register the Image Preview plugin
		FilePond.registerPlugin(

			// encodes the file as base64 data
			FilePondPluginFileEncode,

			// validates the size of the file
			FilePondPluginFileValidateSize,

			// corrects mobile image orientation
			FilePondPluginImageExifOrientation,

			// previews dropped images
			FilePondPluginImagePreview,

			FilePondPluginFileValidateType
		);
		// Select the file input and use create() to turn it into a pond
		const pond = FilePond.create(document.querySelector('.teacher_profile_img'));

	})();


	jQuery(document).ready(function ($) {
		let selectedTab = window.location.hash;
		selectedTab = (selectedTab=='')?'#tab-teachers':selectedTab;
		$('.nav-link[href="' + selectedTab + '"]' ).trigger('click');


        //Prevent default hash behavior on page load
		window.scrollTo(0,0);
	});








	$(document).ready(function(){

		//var elem = document.querySelector('.ccode-stat');
		//var init = new Switchery(elem);

		//$('[name="teacher_edu-details"]').summernote();

		$('[name="teacher_edu_details"]').summernote({
			//placeholder: 'Hello bootstrap 4',
			tabsize: 2,
			height: 250,
			width: '100%',
			toolbar: [

				['style', ['style']],
				//['font', ['bold', 'italic', 'underline', 'clear']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['table', ['table']],
				['insert', [
					'link',
					//'picture',
					//'video',
					'hr'
				]
				],
				['view', [
					//'fullscreen',
					'codeview',
					'help']
				]
			],
		});
        @if(old('teacher_edu_details'))
		    $('[name="teacher_edu_details"]').summernote('code', '{{old('teacher_edu_details')}}');
        @endif




		$('[name="stud_details"]').summernote({
			//placeholder: 'Hello bootstrap 4',
			tabsize: 2,
			height: 250,
			width: '100%',
			toolbar: [

				['style', ['style']],
				//['font', ['bold', 'italic', 'underline', 'clear']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['table', ['table']],
				['insert', [
					'link',
					//'picture',
					//'video',
					'hr'
				]
				],
				['view', [
					//'fullscreen',
					'codeview',
					'help']
				]
			],
		});
        @if(old('stud_details'))
		    $('[name="stud_details"]').summernote('code', '{{old('stud_details')}}');
        @endif






		$('[name="stud_birth_year"]').datepicker({
			autoclose: true,
			format: " yyyy", // Notice the Extra space at the beginning
			viewMode: "years",
			minViewMode: "years",
			endDate: '+0d',
			startDate: '-99y',
		});
        @if(old('stud_birth_year'))
		    $("[name='stud_birth_year']").datepicker("update", '{{old('stud_birth_year')}}');
        @endif


		$('[name="teacher_birth_year"]').datepicker({
			autoclose: true,
			format: " yyyy", // Notice the Extra space at the beginning
			viewMode: "years",
			minViewMode: "years",
			endDate: '+0d',
            startDate: '-99y',
		});
        @if(old('teacher_birth_year'))
		    $("[name='teacher_birth_year']").datepicker("update", '{{old('teacher_birth_year')}}');
        @endif






		$("#stud_gender").select2({
			placeholder: "Select student gender",
			allowClear: true,
			width: '100%'
		});
		$("#marketer_gender").select2({
			placeholder: "Select marketer gender",
			allowClear: true,
			width: '100%'
		});
		$("#teacher_gender").select2({
			placeholder: "Select teacher gender",
			allowClear: true,
			width: '100%'
		});
		$("#editor_gender").select2({
			placeholder: "Select editor gender",
			allowClear: true,
			width: '100%'
		});



	});
</script>
@stop
