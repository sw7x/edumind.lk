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
                <form class="lg:p-10 p-6 space-y-3 relative bg-white shadow-xl rounded-md change-password"
                      method="post" action="{{route('auth.change-password')}}">

                    <h1 class="lg:text-2xl text-xl font-semibold mb-6"> Change Password </h1>
                    @if (count($errors) > 0)
                        <x-flash-message 
                            style="margin-bottom:0px;"
                            class="flash-danger rounded-none"  
                            title="Form submit error!" 
                            message=""  
                            message2=""  
                            :canClose="true" >
                            <x-slot name="insideContent">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm ml-3">{{ $error }}</li>
                                    @endforeach
                                </ul>    
                            </x-slot>    
                        </x-flash-message>
                    @endif

                    @if(Session::has('message'))
                        <x-flash-message  
                            :class="Session::get('cls', 'flash-info').' rounded-none'"  
                            :title="Session::get('msgTitle') ?? 'Info!'" 
                            :message="Session::get('message') ?? ''"  
                            :message2="Session::get('message2') ?? ''"  
                            :canClose="true" />
                    @endif


                    <div class="text-base"><span class="font-bold text-red-500 text-lg">*</span> - Required Information </div>

                    <label for="first-name">Type Password <span class="text-red-500 text-lg">*</span></label>
                    <div class="password-container">                        
                        <input type="password" placeholder="Password (6 to 12 alpha numeric characters) *" name="password_old"
                               class="password_field bg-gray-100 h-12 mt-0 px-3 rounded-md w-full">
                        <button type="button" id="btnToggle" class="pw-toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                    </div>

                    <br/>

                    <label for="first-name">Type New Password <span class="text-red-500 text-lg">*</span></label>
                    <div class="password-container">                        
                        <input type="password" placeholder="Password (6 to 12 alpha numeric characters) *" name="password_new"
                               class="password_field bg-gray-100 h-12 mt-0 px-3 rounded-md w-full">
                        <button type="button" id="btnToggle" class="pw-toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                    </div>

                    
                    <div class="grid lg:grid-cols-2 gap-3">
                        <div>
                            <button type="submit" class="btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Submit</button>
                        </div>
                        <div>
                            <button type="reset" class="btn bg-red-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Clear</button>
                        </div>
                    </div>

                    {{csrf_field ()}}
                    
                </form>
            </div>
        </div>
@stop


