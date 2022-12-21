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

    <link rel='stylesheet' href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/filepond/dist/filepond.min.css'>

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
            @else
                                         
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-container">

                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-teachers">Add teachers</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-students">Add students</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-marketers">Add marketers</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-editor">Add Editor</a></li>
                            </ul>

                            <div class="tab-content mb-3">

                                <div role="tabpanel" id="tab-teachers" class="tab-pane active">
                                    <div class="panel-body">                                    
                                        @foreach ($errors->all() as $error)
                                            {{-- $error --}}
                                        @endforeach                                    

                                        @if(Session::has('teacher_submit_message'))
                                            <div class="flash-msg {{ Session::get('teacher_submit_cls', 'flash-info')}}">
                                                <a href="#" class="close">×</a>
                                                <div class="text-lg"><strong>{{ Session::get('teacher_submit_msgTitle') ?? 'Info!'}}</strong></div>
                                                <p class="text-sm mb-0">{{ Session::get('teacher_submit_message') ?? 'Info!' }}</p>
                                                <div class="text-xs">{!! Session::get('teacher_submit_message2') ?? '' !!}</div>
                                            </div>
                                        @endif

                                        <form class="" id="" action="{{route('admin.user.store-teacher')}}" method="post">
                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="teacher-name" class="form-control" required value="{{ old('teacher-name') }}">
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
                                                    <input type="text" name="teacher-uname" class="form-control" value="{{ old('teacher-uname') }}">
                                                    <small>Leave blank if you want to auto generate username</small><br>
                                                    <small>Only aplha numeric charaters allowed (no spaces, no special characters)</small>
                                                    @if (Session::get('is_teacher_usernameFill')=='y' && $errors->has('teacher-uname'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('teacher-uname') as $error)
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
                                                    <input type="qemail" name="teacher-email" class="form-control" required value="{{ old('teacher-email') }}">
                                                    @if ($errors->has('teacher-email'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('teacher-email') as $error)
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
                                                    <input type="tel" name="teacher-phone" class="form-control" required value="{{ old('teacher-phone') }}">
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
                                                    <input type="password" class="password_field form-control" placeholder="Password (6 to 12 alpha numeric characters) *"
                                                           name="teacher-password" maxlength="12" minlength="6" required value="{{ old('teacher-password') }}"/>
                                                    <button type="button" id="btnToggle" class="pw-toggle" style="right: 20px;">
                                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                                    </button>
                                                    @if ($errors->has('teacher-password'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('teacher-password') as $error)
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
                                                    <select class="form-control m-b" required id="teacher-gender" name="teacher-gender" value="{{ old('teacher-gender') }}">
                                                        <option></option>
                                                        <option {{ old("teacher-gender") == 'male' ? "selected":"" }} value="male">Male</option>
                                                        <option {{ old("teacher-gender") == 'female' ? "selected":"" }} value="female">Female</option>
                                                        <option {{ old("teacher-gender") == 'other' ? "selected":"" }} value="other">Other</option>
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


                                <div role="tabpanel" id="tab-students" class="tab-pane">
                                    <div class="panel-body">
                                        @foreach ($errors->all() as $error)
                                            {{-- $error --}}
                                        @endforeach

                                        @if(Session::has('student_submit_message'))
                                            <div class="flash-msg {{ Session::get('student_submit_cls', 'flash-info')}}">
                                                <a href="#" class="close">×</a>
                                                <div class="text-lg"><strong>{{ Session::get('student_submit_msgTitle') ?? 'Info!'}}</strong></div>
                                                <p class="text-sm mb-0">{{ Session::get('student_submit_message') ?? 'Info!' }}</p>
                                                <div class="text-xs">{!! Session::get('student_submit_message2') ?? '' !!}</div>
                                            </div>
                                        @endif

                                        <form class="" id="" action="{{route('admin.user.store-student')}}" method="post">
                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="stud-name" class="form-control" required value="{{ old('stud-name')}}">
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
                                                    <input type="text" name="stud-uname" class="form-control" value="{{ old('stud-uname')}}">
                                                    <small>Leave blank if you want to auto generate username</small><br>
                                                    <small>Only aplha numeric charaters allowed (no spaces, no special characters)</small>
                                                    @if (Session::get('is_student_usernameFill')=='y' && $errors->has('stud-uname'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('stud-uname') as $error)
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
                                                    <input type="email" name="stud-email" class="form-control" required value="{{ old('stud-email')}}">
                                                    @if ($errors->has('stud-email'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('stud-email') as $error)
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
                                                    <input type="tel" name="stud-phone" class="form-control" required value="{{ old('stud-phone')}}">
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
                                                    <input type="password" class="password_field form-control" placeholder="Password (6 to 12 alpha numeric characters) *"
                                                           name="stud-password" maxlength="12" minlength="6" required value="{{ old('stud-password')}}"/>
                                                    <button type="button" id="btnToggle" class="pw-toggle" style="right: 20px;">
                                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                                    </button>
                                                    @if ($errors->has('stud-password'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('stud-password') as $error)
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
                                                    <select class="form-control m-b" id="stud-gender" name="stud-gender" >
                                                        <option></option>
                                                        <option {{ old("stud-gender") == 'male' ? "selected":"" }} value="male">Male</option>
                                                        <option {{ old("stud-gender") == 'female' ? "selected":"" }} value="female">Female</option>
                                                        <option {{ old("stud-gender") == 'other' ? "selected":"" }} value="other">Other</option>
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


                                <div role="tabpanel" id="tab-marketers" class="tab-pane">
                                    <div class="panel-body">
                                        @foreach ($errors->all() as $error)
                                            {{-- $error --}}
                                        @endforeach

                                        @if(Session::has('marketer_submit_message'))
                                            <div class="flash-msg {{ Session::get('marketer_submit_cls', 'flash-info')}}">
                                                <a href="#" class="close">×</a>
                                                <div class="text-lg"><strong>{{ Session::get('marketer_submit_msgTitle') ?? 'Info!'}}</strong></div>
                                                <p class="text-sm mb-0">{{ Session::get('marketer_submit_message') ?? 'Info!' }}</p>
                                                <div class="text-xs">{!! Session::get('marketer_submit_message2') ?? '' !!}</div>
                                            </div>
                                        @endif

                                        <form class="" id="" action="{{route('admin.user.store-marketer')}}" method="post">
                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="marketer-name" class="form-control"  required value="{{ old('marketer-name')}}">
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
                                                    <input type="text" name="marketer-uname" class="form-control" value="{{ old('marketer-uname')}}">
                                                    <small>Leave blank if you want to auto generate username</small><br>
                                                    <small>Only aplha numeric charaters allowed (no spaces, no special characters)</small>
                                                    @if (Session::get('is_marketer_usernameFill')=='y' && $errors->has('marketer-uname'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('marketer-uname') as $error)
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
                                                    <input type="email" name="marketer-email" class="form-control" required value="{{ old('marketer-email')}}">
                                                    @if ($errors->has('marketer-email'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('marketer-email') as $error)
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
                                                    <input type="tel" name="marketer-phone" class="form-control" required value="{{ old('marketer-phone')}}">
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
                                                    <input type="password" class="password_field form-control" placeholder="Password (6 to 12 alpha numeric characters) *"
                                                           name="marketer-password" maxlength="12" minlength="6" required value="{{ old('marketer-password')}}"/>
                                                    <button type="button" id="btnToggle" class="pw-toggle" style="right: 20px;">
                                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                                    </button>
                                                    @if ($errors->has('marketer-password'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('marketer-password') as $error)
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
                                                    <select class="form-control m-b" id="marketer-gender" name="marketer-gender"  required>
                                                        <option></option>
                                                        <option {{ old("marketer-gender") == 'male' ? "selected":"" }} value="male">Male</option>
                                                        <option {{ old("marketer-gender") == 'female' ? "selected":"" }} value="female">Female</option>
                                                        <option {{ old("marketer-gender") == 'other' ? "selected":"" }} value="other">Other</option>
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


                                <div role="tabpanel" id="tab-editor" class="tab-pane">
                                    <div class="panel-body">
                                        @if(Session::has('editor_submit_message'))
                                            <div class="flash-msg {{ Session::get('editor_submit_cls', 'flash-info')}}">
                                                <a href="#" class="close">×</a>
                                                <div class="text-lg"><strong>{{ Session::get('editor_submit_msgTitle') ?? 'Info!'}}</strong></div>
                                                <p class="text-sm mb-0">{{ Session::get('editor_submit_message') ?? 'Info!' }}</p>
                                                <div class="text-xs">{!! Session::get('editor_submit_message2') ?? '' !!}</div>
                                            </div>
                                        @endif

                                        <form class="" id="" action="{{route('admin.user.store-editor')}}" method="post">
                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="editor-name" class="form-control" required value="{{ old('editor-name')}}">
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
                                                    <input type="text" name="editor-uname" class="form-control" value="{{ old('editor-uname')}}">
                                                    <small>Leave blank if you want to auto generate username</small><br>
                                                    <small>Only aplha numeric charaters allowed (no spaces, no special characters)</small>
                                                    @if (Session::get('is_editor_usernameFill')=='y' && $errors->has('editor-uname'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('editor-uname') as $error)
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
                                                    <input type="email" name="editor-email" class="form-control" required value="{{ old('editor-email')}}">
                                                    @if ($errors->has('editor-email'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('editor-email') as $error)
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
                                                    <input type="tel" name="editor-phone" class="form-control" required value="{{ old('editor-phone')}}">
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
                                                    <input type="password" class="password_field form-control" placeholder="Password (6 to 12 alpha numeric characters) *"
                                                           name="editor-password" maxlength="12" minlength="6" required value="{{ old('editor-password')}}"/>
                                                    <button type="button" id="btnToggle" class="pw-toggle" style="right: 20px;">
                                                        <i id="eyeIcon" class="fa fa-eye"></i>
                                                    </button>
                                                    @if ($errors->has('editor-password'))
                                                        <ul class="mt-1">
                                                            @foreach ($errors->get('editor-password') as $error)
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
                                                    <select class="form-control m-b" id="editor-gender" name="editor-gender" required>
                                                        <option></option>
                                                        <option {{ old("editor-gender") == 'male' ? "selected":"" }} value="male">Male</option>
                                                        <option {{ old("editor-gender") == 'female' ? "selected":"" }} value="female">Female</option>
                                                        <option {{ old("editor-gender") == 'other' ? "selected":"" }} value="other">Other</option>
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
@stop


@section('javascript')
<script>

	/*(function () {
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

	})();*/


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
