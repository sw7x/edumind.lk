@extends('layouts.master')
@section('title','Student profile')




@section('content')
    <div class="main-container container">
        <div class="max-w-full  md:p-2 mx-auto">

            @if(Session::has('message'))
                <x-flash-message  
                    :class="Session::get('cls', 'flash-info')"  
                    :title="Session::get('msgTitle') ?? 'Info!'" 
                    :message="Session::get('message') ?? ''"  
                    :message2="Session::get('message2') ?? ''"  
                    :canClose="true" />
            @endif

            @php
                //var_dump($userData);
            @endphp

            @if(isset($userData))
                <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">
                    <div  style="flex:1">
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Profile Page (student)</h2>
                        <hr class="mb-5">


                        <section class="tabs-section">
                            <div class="tab-content">
                                <div class="tab-pane active show" id="tab-1">
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div id="announcement" class="tube-card p-3 lg:p-6">
                                            {{--<h2 class="font-semibold mb-3 text-xl lg:text-3xl">Learn The Basic Of VUE JS .</h2>
                                            <hr class="mb-5">--}}
                                            <div class="flex items-center gap-x-4 mb-5 pb-5">
                                                <div class="w-1/4">                                                
                                                    <div class="">
                                                        <img src="{{$userData['profilePic']}}" alt="" class="mx-auto rounded-full shadow w-40 __h-20">
                                                    </div>
                                                    <div class="text-center">
                                                        <h4 class="mt-2 text-xl">{{$userData['username']}}</h4>
                                                        <span class="text-base">
                                                            @if(isset($userData['createdAtAgo']))
                                                                <span class="text-gray-500">Registed : {{$userData['createdAtAgo']}}</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="px-8 w-3/4">
                                                    <p class="text-blue-900 text-base __mb-7 __mt-7">{{$userData['profileText']}}</p>
                                                </div>
                                            </div>

                                            

                                            <div class="text-blue-900 text-sm mb-7 mt-2">
                                                <table class="text-blue-900 text-sm smitty-table table table-striped left-align-cells">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-left">full name</td>
                                                            <td class="text-left">{{$userData['fullName']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">Email</td>
                                                            <td class="text-left">{{$userData['email']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone</td>
                                                            <td>{{$userData['phone']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Username</td>
                                                            <td>{{$userData['username']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Gender</td>
                                                            <td>{{$userData['gender']}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Birth year</td>
                                                            <td>{{$userData['dobYear'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Account status</td>
                                                            <td>{{$status = ($userData['status'] == 1) ? 'Enable' : 'Disable'}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                </div>
            @else
                <x-flash-message  
                    class="flash-danger"  
                    title="Error!" 
                    message="User Profile does not exist!"  
                    message2=""  
                    :canClose="false" />
            @endif
        </div>
    </div>
@stop
