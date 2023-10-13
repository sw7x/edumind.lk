@extends('layouts.master')
@section('title','401 Unauthorized')

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

                    <h1 class="lg:text-2xl text-xl font-semibold mb-6">401 Unauthorized</h1>
                    <?php   //dump($errMsg);    ?>
                    @if ($errors->loginForm->getMessages())                    
                        <x-flash-message 
                            style="margin-bottom:0px;"
                            class="flash-danger rounded-none"  
                            title="Form submit error!" 
                            message=""  
                            message2=""  
                            :canClose="true" >
                            <x-slot name="insideContent">
                                <ul class="list-disc">
                                    @foreach ($errors->loginForm->getMessages() as  $field => $errorMsgArr)
                                        @foreach ($errorMsgArr as $errorMsg)
                                            <li class="text-sm ml-3">{{ $errorMsg }}</li>
                                        @endforeach
                                    @endforeach
                                </ul>    
                            </x-slot>    
                        </x-flash-message>
                    @endif

                    <x-flash-message 
                        class="flash-danger mb-5"  
                        title="Authentication is required" 
                        :message="$errMsg ?? 'To access this resource, you must log in. Please sign in.'"  
                        message2=""  
                        :canClose="false" />
                    
                    @if(!Sentinel::check())
                        <div class="mt-5">
                            <div class="text-base"><span class="font-bold text-red-500 text-lg">*</span> - Required Information </div>

                            <div>
                                <input type="text" name="email" placeholder="Username or Email *" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" required>
                            </div>
                            
                            <div class="password-container">
                                <input required type="password" placeholder="Password (6 to 12 alpha numeric characters) *" name="password"
                                       class="password_field bg-gray-100 h-12 mt-5 px-3 rounded-md w-full" maxlength="12" minlength="6">
                                <button type="button" id="btnToggle" class="pw-toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                            </div>

                            <div class="checkbox mt-5">
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

                            <div class="uk-heading-line uk-text-center py-5"><span>Or, explore more</span></div>
                            {{csrf_field ()}}
                        </div>
                    @else
                        <br>
                    @endif




                    <div class="flex items-center space-x-2 justify-center">
                        <div class="mr-5">
                            <a href="{{url()->previous()}}" title="" class="btn bg-blue-500 hover:bg-blue-700 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Go Back</a>
                        </div>
                        <div class="mr-5">
                            <a href="{{route('home')}}" title="" class="btn bg-green-500 hover:bg-green-600 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Go to Home</a>
                        </div>
                    </div>
                    
                    
                    @if(!Sentinel::check())
                        <br>
                        <div class="font-semibold text-center text-sm">So you can’t get in to your account? Did you <a class="text-blue-600" href="{{route('auth.reset-password')}}">forget your password</a></div>
                    @endif 

                </form>
            </div>
        </div>
@stop














