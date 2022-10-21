@extends('layouts.master')
@section('title','Reset password')

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
                      method="post" action="">

                    <h1 class="lg:text-2xl text-xl font-semibold mb-6">Reset password</h1>
                    <div class="text-base"><span class="font-bold text-red-500 text-lg">*</span> - Required Information </div>

                    @if(count($errors)>0)
                        <div>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li class="font-semibold text-xs text-red-600">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="password-container">
                        <input required type="password" placeholder="Password (6 to 12 alpha numeric characters) *" name="password"
                               class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full password_field" maxlength="12" minlength="6">
                        <button type="button" id="btnToggle" class="pw-toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                    </div>

                    <div class="password-container">
                        <input required type="password" placeholder="Confirm password (6 to 12 alpha numeric characters) *" name="password_confirmation"
                               class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full password_field" maxlength="12" minlength="6">
                        <button type="button" id="btnToggle" class="pw-toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                    </div>


                    {{csrf_field ()}}

                    <div class="grid lg:grid-cols-2 gap-3">
                        <div>
                            <button type="submit" class="btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Submit</button>
                        </div>
                        <div>
                            <button type="reset" class="btn bg-red-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Clear</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
@stop
