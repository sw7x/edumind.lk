@extends('layouts.master')
@section('title','Student profile')




@section('content')
    <div class="main-container container">
        <div class="max-w-full  md:p-2 mx-auto">

            @if(Session::has('message'))
                <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                    <p>{{ Session::get('message') ?? 'Info!' }}</p>
                    <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                </div>
            @endif

            @php
                //var_dump($userData);
            @endphp

            @if(isset($userData))
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">
                <div  style="flex:1">
                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Profile Page (student)</h2>
                    <hr class="mb-5">
                    <!-- <h4 class="font-semibold mb-2 text-base"> Description </h4>    -->

                    <section class="tabs-section">
                        <div class="_container">
                            <div class="row">

                               <div class="col-md-3 col-lg-3 nav-section">
                                   @include('includes.student-profile-menu')
                               </div>

                               <div class="col-md-9 col-lg-9 content-section">
                                  <div class="tab-content">
                                     <div class="tab-pane active show" id="tab-1">
                                        <div class="row">
                                            <div class="col-lg-12">

                                                <div id="announcement" class="tube-card p-3 lg:p-6">
                                                    {{--<h2 class="font-semibold mb-3 text-xl lg:text-3xl">Learn The Basic Of VUE JS .</h2>
                                                    <hr class="mb-5">--}}
                                                    <div class="flex items-center gap-x-4 mb-5">
                                                        <img src="{{asset('images/default-images/student.png')}}" alt="" class="rounded-full shadow w-20 h-20">

                                                        <div>
                                                            <h4 class="-mb-1 text-base">{{$userData->full_name}}</h4>
                                                            <span class="text-sm">
                                                                @if($userData->created_at)
                                                                    <span class="text-gray-500">Registed : {{$userData->created_at->diffForHumans()}}</span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <p class="text-blue-900 text-sm mb-7 mt-2">{{$userData->profile_text}}</p>

                                                    <div class="text-blue-900 text-sm mb-7 mt-2">

                                                        <table class="text-blue-900 text-sm smitty-table table table-striped left-align-cells">
                                                            <tbody>
                                                            <tr>
                                                                <td class="text-left">Email</td>
                                                                <td class="text-left">{{$userData->email}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Phone</td>
                                                                <td>{{$userData->phone}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Profile ID</td>
                                                                <td>{{$userData->username}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender</td>
                                                                <td>{{$userData->gender}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Birth year</td>
                                                                <td>{{$userData->dob_year }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Account status</td>
                                                                <td>{{$status = ($userData->status==1)?'Enable':'Disable'}}</td>
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
                <div></div>
            @endif
        </div>
    </div>
@stop
