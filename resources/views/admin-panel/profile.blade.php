@extends('admin-panel.layouts.master')
@section('title','Profile')


@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="ibox mb-0">
                <div class="ibox-content">


                    @if(Session::has('message'))
                        <x-flash-message  
                            :class="Session::get('cls', 'flash-info')"  
                            :title="Session::get('msgTitle') ?? 'Info!'" 
                            :message="Session::get('message') ?? ''"  
                            :message2="Session::get('message2') ?? ''"  
                            :canClose="true" />
                    @endif

                    @php

                        /*
                        Name
                        Username
                        Email *
                        Phone *
                        Gender *
                        status
                        
                        createdAt
                        role
                        profilePic
                        */

                        //var_dump($userData);
                        $userData1 = array(
                            'fullName'      =>  'Brandon Butch',
                            'createdAt'     =>  '2011/4/6',
                            'createdAtAgo'  =>  '2 days ago',
                            'profileText'   =>  'looking for has note been found.',
                            'email'         =>  'student1@edumind.lk',
                            'phone'         =>  '097553545',
                            'username'      =>  'student1',
                            'gender'        =>  'male',
                            'dobYear'       =>  '1986',
                            'status'        =>  'Enable',
                            'roleName'      =>  'student'
                        );                       
                    @endphp

                    @if(isset($userData))
                        <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">
                            <div  style="flex:1">
                                
                                <section class="tabs-section">
                                    <div class="_container">
                                        <div class="row">

                                            <div class="col-md-3 col-lg-3 nav-section">                                           
                                                <div class="flex items-center gap-x-4 mb-3 px-3">
                                                    <img src="{{$userData['profilePic']}}" alt="" class="rounded-full shadow _w-20 _h-20">
                                                    {{-- 
                                                    <img src="{{asset('images/default-images/student.png')}}" alt="" class="rounded-full shadow _w-20 _h-20">
                                                    <img src="{{asset('images/default-images/editor.png')}}" alt="" class="rounded-full shadow _w-20 _h-20">
                                                    <img src="{{asset('images/default-images/admin.png')}}" alt="" class="rounded-full shadow _w-20 _h-20">
                                                    <img src="{{asset('images/default-images/marketer.png')}}" alt="" class="rounded-full shadow _w-20 _h-20">
                                                    --}}
                                                </div>
                                                <div class="text-center pb-5">
                                                    <h3 class="my-0 text-base">{{$userData['fullName']}}</h3>
                                                    <h4 class="mt-0 mb-2 text-base">{{$userData['username']}}</h4>
                                                    
                                                    <span class="text-sm">
                                                        @if(isset($userData['createdAt']))
                                                            <span class="text-gray-500">Registed : {{$userData['createdAtAgo']}}</span>
                                                        @endif
                                                    </span>
                                                </div>
                                           </div>

                                           <div class="col-md-9 col-lg-9 content-section">
                                              <div class="tab-content">
                                                 <div class="tab-pane active show" id="tab-1">
                                                    <div class="row">
                                                        <div class="col-lg-12">

                                                            <div id="announcement" class="tube-card p-3 lg:p-6">                                                            
                                                                <div class="text-sm mb-7 mt-2">
                                                                    <h3 class="font-semibold mb-4 text-xl lg:text-2xl">Account details</h3>
                                                                    <table class="text-blue-900 text-sm smitty-table table table-striped left-align-cells">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="text-left">Full name</td>
                                                                                <td class="text-left">{{$userData['fullName']}}</td>
                                                                            </tr>                                                                    
                                                                            <tr>
                                                                                <td class="text-left">User role</td>
                                                                                <td class="text-left">{{$userData['roleName']}}</td>
                                                                            </tr>           
                                                                            <tr>
                                                                                <td>Username(Profile ID)</td>
                                                                                <td>{{$userData['username']}}</td>
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
                                                                                <td>Gender</td>
                                                                                <td>{{$userData['gender']}}</td>
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
        </div>
    </div>
@stop



