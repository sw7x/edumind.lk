@extends('admin-panel.layouts.master')
@section('title','Edit user')

@section('css-files')

    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- bootstrap datapicker -->
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.css')}}">
    <!-- <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">-->

    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

    <link rel='stylesheet' href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/filepond/dist/filepond.min.css'>

    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

@stop

@section('page-css')
<style>
    .nav-tabs .nav-link.disabled {
        display:none;
    }
</style>
@stop



@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            @if(Session::has('user_edit_message'))
                <div class="flash-msg {{ Session::get('user_edit_cls', 'flash-info')}}">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ Session::get('user_edit_msgTitle') ?? 'Info!'}}</strong></div>
                    <p>{{ Session::get('user_edit_message') ?? 'Info!' }}</p>
                    <div class="text-base">{!! Session::get('user_edit_message2') ?? '' !!}</div>
                </div>
            @else           
                <div class="ibox">
                    <div class="ibox-content">

                        <div class="tabs-container">
                            {{--userData--}}
                            {{--$userType--}}
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link {{ ($userType == 'teacher') ? 'active' : 'disabled' }}" data-toggle="tab"  href="#tab-teachers">Edit teacher</a></li>
                                <li><a class="nav-link {{ ($userType == 'student') ? 'active' : 'disabled' }}" data-toggle="tab"  href="#tab-students">Edit student</a></li>
                                <li><a class="nav-link {{ ($userType == 'marketer') ? 'active' : 'disabled' }}" data-toggle="tab" href="#tab-marketers">Edit marketer</a></li>
                                <li><a class="nav-link {{ ($userType == 'editor') ? 'active' : 'disabled' }}" data-toggle="tab"   href="#tab-editor">Edit editor</a></li>
                            </ul>

                            <div class="tab-content mb-3">

                                @if($userType == 'teacher')
                                <div role="tabpanel" id="tab-teachers" class="tab-pane {{ ($userType == 'teacher') ? 'active' : '' }}">
                                    <div class="panel-body">

                                        <form class="" id="" action="{{route('admin.user.update-teacher',['id' => $userData->id])}}" method="post">
                                            {{ method_field('PATCH') }}
                                            <input type="hidden" name="id" value="{{$userData->id}}">

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="teacher-name" class="form-control" required value="{{ $userData->full_name}}">
                                                    @if ($errors->has('teacher-name'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('teacher-name') as $error)
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
                                                    <input type="text" name="teacher-uname" class="form-control" disabled value="{{ $userData->username}}">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="qemail" name="teacher-email" class="form-control" required disabled value="{{ $userData->email}}">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="tel" name="teacher-phone" class="form-control" required value="{{ $userData->phone}}">
                                                    @if ($errors->has('teacher-phone'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('teacher-phone') as $error)
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
                                                    <span class="mr-2">Reset Off</span>
                                                    <input type="checkbox" class="js-switch rest-password"  />
                                                    <span class="ml-2">Reset On</span><br/><br/>
                                                    <span class="text-black">After reset password is chang to below</span><br/>
                                                    <span class="font-semibold text-base">Pa$$w0rd!</span>
                                                    <input type="hidden" name="teacher_reset_pw_stat" class="reset_pw_stat" value="off" />
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

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Education qualifications</label>
                                                <div class="col-sm-8">
                                                    <div class="border border-edu">
                                                        <textarea rows="3" class="form-control" name="teacher_edu_details">{{-- $userData->edu_qualifications --}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>


                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Profile image</label>
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

                                            <input type="hidden" value="{{URL('/')}}/storage/{{$userData->profile_pic}}"
                                                   name="teacher_img"/>
                                            <input type="hidden" value="{{$userData->profile_pic}}"
                                                   name="teacher_img_url"/>
                                            <input type="hidden" value="1"
                                                   name="teacher_img_add_count"/>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control m-b" required id="teacher-gender" name="teacher-gender" value="{{ $userData->gender }}">
                                                        <option></option>
                                                        <option {{ $userData->gender == 'male' ? "selected":"" }} value="male">Male</option>
                                                        <option {{ $userData->gender == 'female' ? "selected":"" }} value="female">Female</option>
                                                        <option {{ $userData->gender == 'other' ? "selected":"" }} value="other">Other</option>
                                                    </select>
                                                    @if ($errors->has('teacher-gender'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('teacher-gender') as $error)
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
                                                        <label> <input {{  $userData->status == "enable" ? "checked" : ($userData->status =="disable" ? "" : "checked") }}
                                                                       type="radio" checked value="enable" name="teacher_stat"> <i></i> Enable </label>
                                                    </div>
                                                    <div class="i-checks">
                                                        <label> <input {{  $userData->status == "disable" ? "checked" : "" }}
                                                                       type="radio" value="disable" name="teacher_stat"> <i></i> Disable </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            {{csrf_field ()}}
                                            <div class="form-group row">
                                                <div class="col-sm-4 offset-sm-4">
                                                    <button class="btn btn-primary btn-sm" type="submit">Update user</button>
                                                    <a href="{{route('admin.user.index')}}#tab-teachers" class="btn btn-danger btn-sm">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif

                                @if($userType == 'student')
                                <div role="tabpanel" id="tab-students" class="tab-pane {{ ($userType == 'student') ? 'active' : '' }}">
                                    <div class="panel-body">
                                        @foreach ($errors->all() as $error)
                                            {{-- $error --}}
                                        @endforeach

                                        <form class="" id="" action="{{route('admin.user.update-student',['id' => $userData->id])}}" method="post">
                                            {{ method_field('PATCH') }}
                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="stud-name" class="form-control" required value="{{$userData->full_name}}">
                                                    @if ($errors->has('stud-name'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('stud-name') as $error)
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
                                                    <input type="text" name="stud-uname" disabled class="form-control" value="{{ $userData->username}}">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="email" name="stud-email" disabled class="form-control" required value="{{ $userData->email}}">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="tel" name="stud-phone" class="form-control" required value="{{ $userData->phone}}">
                                                    @if ($errors->has('stud-phone'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('stud-phone') as $error)
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
                                                    <span class="mr-2">Reset Off</span>
                                                    <input type="checkbox" class="js-switch rest-password"  />
                                                    <span class="ml-2">Reset On</span><br/><br/>
                                                    <span class="text-black">After reset password is chang to below</span><br/>
                                                    <span class="font-semibold text-base">Pa$$w0rd!</span>
                                                    <input type="hidden" name="stud_reset_pw_stat" class="reset_pw_stat" value="off" />
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

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Student details</label>
                                                <div class="col-sm-8">
                                                    <div class="border border-edu">
                                                        <textarea rows="3" class="form-control" name="stud_details">{{-- $userData->profile_text --}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control m-b" id="stud-gender" name="stud-gender">
                                                        <option></option>
                                                        <option {{ $userData->gender == 'male' ? "selected":"" }} value="male">Male</option>
                                                        <option {{ $userData->gender == 'female' ? "selected":"" }} value="female">Female</option>
                                                        <option {{ $userData->gender == 'other' ? "selected":"" }} value="other">Other</option>
                                                    </select>
                                                    @if ($errors->has('stud-gender'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('stud-gender') as $error)
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
                                                        <label> <input {{  $userData->status == "enable" ? "checked" : ($userData->status =="disable" ? "" : "checked") }}
                                                                       type="radio" value="enable" name="student_stat">
                                                            <i></i> Enable </label>
                                                    </div>
                                                    <div class="i-checks">
                                                        <label> <input {{  $userData->status == "disable" ? "checked" : "" }}
                                                                       type="radio" value="disable" name="student_stat">
                                                            <i></i> Disable </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            {{csrf_field ()}}
                                            <div class="form-group row">
                                                <div class="col-sm-4 offset-sm-4">
                                                    <button class="btn btn-primary btn-sm" type="submit">Update user</button>
                                                    <a href="{{route('admin.user.index')}}#tab-students" class="btn btn-danger btn-sm">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif

                                @if($userType == 'marketer')
                                <div role="tabpanel" id="tab-marketers" class="tab-pane {{ ($userType == 'marketer') ? 'active' : '' }}">
                                    <div class="panel-body">
                                        @foreach ($errors->all() as $error)
                                            {{-- $error --}}
                                        @endforeach

                                        <form class="" id="" action="{{route('admin.user.update-marketer',['id' => $userData->id])}}" method="post">
                                            {{ method_field('PATCH') }}
                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="marketer-name" class="form-control"  required value="{{ $userData->full_name}}">
                                                    @if ($errors->has('marketer-name'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('marketer-name') as $error)
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
                                                    <input type="text" name="marketer-uname" class="form-control" disabled value="{{$userData->username}}">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="email" name="marketer-email" class="form-control" disabled required value="{{$userData->email}}">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="tel" name="marketer-phone" class="form-control" required value="{{$userData->phone }}">
                                                    @if ($errors->has('marketer-phone'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('marketer-phone') as $error)
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
                                                    <span class="mr-2">Reset Off</span>
                                                    <input type="checkbox" class="js-switch rest-password"  />
                                                    <span class="ml-2">Reset On</span><br/><br/>
                                                    <span class="text-black">After reset password is chang to below</span><br/>
                                                    <span class="font-semibold text-base">Pa$$w0rd!</span>
                                                    <input type="hidden" name="marketer_reset_pw_stat" class="reset_pw_stat" value="off" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control m-b" id="marketer-gender" name="marketer-gender"  required>
                                                        <option></option>
                                                        <option {{ $userData->gender == 'male' ? "selected":"" }} value="male">Male</option>
                                                        <option {{ $userData->gender == 'female' ? "selected":"" }} value="female">Female</option>
                                                        <option {{ $userData->gender == 'other' ? "selected":"" }} value="other">Other</option>
                                                    </select>
                                                    @if ($errors->has('marketer-gender'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('marketer-gender') as $error)
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
                                                        <label> <input {{  $userData->status == "enable" ? "checked" : ($userData->status =="disable" ? "" : "checked") }}
                                                                       type="radio" checked value="enable" name="marketer_stat"> <i></i> Enable </label>
                                                    </div>
                                                    <div class="i-checks">
                                                        <label> <input {{  $userData->status == "disable" ? "checked" : "" }}
                                                                       type="radio" value="disable" name="marketer_stat"> <i></i> Disable </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            {{csrf_field ()}}
                                            <div class="form-group row">
                                                <div class="col-sm-4 offset-sm-4">
                                                    <button class="btn btn-primary btn-sm" type="submit">Update user</button>
                                                    <a href="{{route('admin.user.index')}}#tab-marketers" class="btn btn-danger btn-sm">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif

                                @if($userType == 'editor')
                                <div role="tabpanel" id="tab-editor" class="tab-pane {{ ($userType == 'editor') ? 'active' : '' }}">
                                    <div class="panel-body">
                                         @foreach ($errors->all() as $error)
                                            {{-- $error --}}
                                        @endforeach
                                        
                                        <form class="" id="" action="{{route('admin.user.update-editor',['id' => $userData->id])}}" method="post">
                                            {{ method_field('PATCH') }}
                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="editor-name" class="form-control" required value="{{$userData->full_name}}">
                                                    @if ($errors->has('editor-name'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('editor-name') as $error)
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
                                                    <input type="text" name="editor-uname" disabled class="form-control" value="{{$userData->username}}">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="email" name="editor-email" class="form-control" disabled required value="{{$userData->email}}">
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="tel" name="editor-phone" class="form-control" required value="{{$userData->phone}}">
                                                    @if ($errors->has('editor-phone'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('editor-phone') as $error)
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
                                                    <span class="mr-2">Reset Off</span>
                                                    <input type="checkbox" class="js-switch rest-password"  />
                                                    <span class="ml-2">Reset On</span><br/><br/>
                                                    <span class="text-black">After reset password is chang to below</span><br/>
                                                    <span class="font-semibold text-base">Pa$$w0rd!</span>
                                                    <input type="hidden" name="editor_reset_pw_stat" class="reset_pw_stat" value="off" />
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <select class="form-control m-b" id="editor-gender" name="editor-gender" required>
                                                        <option></option>
                                                        <option {{ $userData->gender == 'male' ? "selected":"" }} value="male">Male</option>
                                                        <option {{ $userData->gender == 'female' ? "selected":"" }} value="female">Female</option>
                                                        <option {{ $userData->gender == 'other' ? "selected":"" }} value="other">Other</option>
                                                    </select>
                                                    @if ($errors->has('editor-gender'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('editor-gender') as $error)
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
                                                        <label> <input {{  $userData->status == "enable" ? "checked" : ($userData->status =="disable" ? "" : "checked") }}
                                                                       type="radio" checked value="enable" name="editor_stat"> <i></i> Enable </label>
                                                    </div>
                                                    <div class="i-checks">
                                                        <label> <input {{  $userData->status == "disable" ? "checked" : "" }}
                                                                       type="radio" value="disable" name="editor_stat"> <i></i> Disable </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            {{csrf_field ()}}
                                            <div class="form-group row">
                                                <div class="col-sm-4 offset-sm-4">
                                                    <button class="btn btn-primary btn-sm" type="submit">Update user</button>
                                                    <a href="{{route('admin.user.index')}}#tab-editors" class="btn btn-danger btn-sm">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif

                            </div>

                        </div>

                    </div>
                </div>
            @endif




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


    <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src='https://unpkg.com/filepond/dist/filepond.min.js'></script>

    <!-- Switchery -->
    <script src="{{asset('admin/js/plugins/switchery/switchery.js')}}"></script>

@stop


@section('javascript')
<script>

    var dobYear = {!! $userData->dob_year ?? '""'!!};
    var userType = '{!! $userType ?? '' !!}';

	(function () {
		/* We want to preview images, so we need to register the Image Preview plugin  */
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

		let teacherImg = $('[name="teacher_img"]').val();

		//this varible is use to track if there is have image or not
		let teacherImgUrl = $('[name="teacher_img_url"]').val();

		if(teacherImgUrl){
			pond.addFile(teacherImg);
		}


        /*
         $('[name="teacher_img_add_count"]') is use to track
         user submit form without changing previously uploaded image  => then no need invoke image upload
         or
         user submit form by changing previously uploaded image => then need invoke image upload
         */
		$('.filepond-img').on('FilePond:addfile', function(e) {
			let $countElem = $('[name="teacher_img_add_count"]');
			let count = $countElem.val();
			count--;
			$countElem.val(count);
			if(count<0){
				$('[name="teacher_img_url"]').val('');
			}
		});

		$('.filepond-img').on('FilePond:removefile', function(e) {});


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

		//$('[name="teacher-edu-details"]').summernote();
        var elems = document.querySelectorAll('.rest-password');
		new Switchery(elems[0], { size: 'default' });



		$(".rest-password").on('change', function() {
			var chaangepwField = $(this).parent().find('input[type=hidden].reset_pw_stat');

			if ($(this).is(':checked')) {
				chaangepwField.val("on");
			}
			else {
				chaangepwField.val("off");
			}
		});





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

        @if(isset($userData->edu_qualifications))
		    //$('[name="teacher_edu_details"]').summernote('code', '{{$userData->edu_qualifications}}');
            $('[name="teacher_edu_details"]').summernote('code', `{!!$userData->edu_qualifications!!}`);
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

		@if(isset($userData->profile_text))
		    //$('[name="stud_details"]').summernote('html', '{{$userData->profile_text}}');
            $('[name="stud_details"]').summernote('code', `{!!$userData->profile_text!!}`);
            //$('textarea[name="content"]').html($('[name="stud_details"]').code());
        @endif








		$('[name="stud_birth_year"]').datepicker({
			autoclose: true,
			format: " yyyy", // Notice the Extra space at the beginning
			viewMode: "years",
			minViewMode: "years",
			endDate: '+0d',
			startDate: '-99y',
		});
        @if(isset($userData->dob_year) && $userType == 'student')
		$("[name='stud_birth_year']").datepicker("update", '{{$userData->dob_year}}');
        @endif


		$('[name="teacher_birth_year"]').datepicker({
			autoclose: true,
			format: " yyyy", // Notice the Extra space at the beginning
			viewMode: "years",
			minViewMode: "years",
			endDate: '+0d',
            startDate: '-99y',
		});

        @if(isset($userData->dob_year) && $userType == 'teacher')
		    $("[name='teacher_birth_year']").datepicker("update", '{{$userData->dob_year}}');
        @endif





		$("#stud-gender").select2({
			placeholder: "Select student gender",
			allowClear: true,
			width: '100%'
		});
		$("#marketer-gender").select2({
			placeholder: "Select marketer gender",
			allowClear: true,
			width: '100%'
		});
		$("#teacher-gender").select2({
			placeholder: "Select teacher gender",
			allowClear: true,
			width: '100%'
		});
		$("#editor-gender").select2({
			placeholder: "Select editor gender",
			allowClear: true,
			width: '100%'
		});



	});
</script>
@stop
