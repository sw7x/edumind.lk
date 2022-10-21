@extends('layouts.master')
@section('title','Login')

@section('page-css')
<style>
    input , .bootstrap-select.btn-group button{
        background-color: #f3f4f6  !important;
        height: 40px  !important;
        box-shadow: none  !important;
    }
</style>
@stop

@section('content')
        <div class="main-container container">
            <div class="__lg:p-12 max-w-xl lg:my-0 my-12 mx-auto __p-6 space-y-">
                <form class="lg:p-10 p-6 space-y-3 relative bg-white shadow-xl rounded-md"
                      method="post" action="{{route('auth.login-submit')}}">

                    <h1 class="lg:text-2xl text-xl font-semibold mb-6"> Login </h1>


                    @if (count($errors) > 0)
                        <div class="flash-msg flash-danger rounded-none" style="margin-bottom:0px;">
                            <a href="#" class="close">×</a>
                            <div class="text-lg"><strong>Form submit error!</strong></div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm ml-3">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            

                    @if(Session::has('message'))
                        <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                            <a href="#" class="close">×</a>
                            <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                            <p>{{ Session::get('message') ?? 'Info!' }}</p>
                            <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                        </div>
                    @endif
                    <div class="text-base"><span class="font-bold text-red-500 text-lg">*</span> - Required Information </div>

                    <div>
                        <!-- <label class="mb-0" for="username"> Username </label> -->
                        <input type="text" name="email" placeholder="Username or Email *" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" required>
                    </div>
                    <!-- <div>
                        <label class="mb-0" for="email"> Email Address </label>
                        <input type="email" id="email" placeholder="Info@example.com" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                    </div> -->

                    <div class="password-container">
                        <input required type="password" placeholder="Password (6 to 12 alpha numeric characters) *" name="password"
                               class="password_field bg-gray-100 h-12 mt-5 px-3 rounded-md w-full" maxlength="12" minlength="6">
                        <button type="button" id="btnToggle" class="pw-toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                    </div>

                    <div class="checkbox">
                        <input type="checkbox" id="remeber_me" checked name="remeber_me">
                        <label for="remeber_me"><span class="checkbox-icon"></span>Remember Me</label>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-3">
                        <div>
                            <button type="submit" class="btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Submit</button>
                        </div>
                        <div>
                            <button type="reset" class="btn bg-red-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Clear</button>
                        </div>
                    </div>

                    <div class="uk-heading-line uk-text-center py-5"><span> Or, connect with </span></div>

                    <!-- todo - oauth login -->
                    <!-- <a href="/login/facebook" class="hidden relative lg:flex items-center justify-start w-full py-3 mt-2 overflow-hidden text-lg font-medium text-white bg-indigo-600 rounded-lg cursor-pointer">
                        <span class="absolute left-0 flex items-center justify-center w-16 h-full mr-3 fill-current">
                            <svg viewBox="0 0 24 24" class="left-0 w-8 h-8 ml-1 text-white fill-current" xmlns="http://www.w3.org/2000/svg"><path d="M23.998 12c0-6.628-5.372-12-11.999-12C5.372 0 0 5.372 0 12c0 5.988 4.388 10.952 10.124 11.852v-8.384H7.078v-3.469h3.046V9.356c0-3.008 1.792-4.669 4.532-4.669 1.313 0 2.686.234 2.686.234v2.953H15.83c-1.49 0-1.955.925-1.955 1.874V12h3.328l-.532 3.469h-2.796v8.384c5.736-.9 10.124-5.864 10.124-11.853z"></path></svg>
                        </span>
                        <span class="inline-block pl-5 text-base text-center w-full">Signup with Facebook</span>
                    </a> -->


                    <div class="flex items-center space-x-2 justify-center">
                        <a href="#">
                            <ion-icon name="logo-facebook" class="p-2 rounded-full text-4xl bg-gray-100 text-blue-600"></ion-icon>
                        </a>
                        <a href="#">
                            <ion-icon name="logo-twitter" class="p-2 rounded-full text-4xl bg-gray-100 text-indigo-500"></ion-icon>
                        </a>
                        <a href="#">
                            <ion-icon name="logo-github" class="p-2 rounded-full text-4xl bg-gray-100"></ion-icon>
                        </a>
                    </div>
                    {{csrf_field ()}}
                    <div class="font-semibold text-center text-sm">So you can’t get in to your account? Did you <a class="text-blue-600" href="{{route('auth.reset-password')}}">forget your password</a></div>

                </form>
            </div>
        </div>
@stop
