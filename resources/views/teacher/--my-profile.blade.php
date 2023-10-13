@extends('layouts.master')
@section('title','Teacher profile')


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
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">My Profile Page (teacher)</h2>
                        <hr class="mb-5">
                        <!-- <h4 class="font-semibold mb-2 text-base"> Description </h4>    -->

                        <section class="tabs-section">
                            <div class="_container">
                                <div class="row">

                                    <div class="col-md-3 col-lg-3 nav-section">
                                       @include('includes.teacher-profile-menu')
                                    </div>

                                    <div class="col-md-9 col-lg-9 content-section">
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="tab-1">

                                                <div class="lg:flex lg:space-x-10 bg-white tube-card p-3 lg:p-6 tube-card">
                                                    <div class="lg:w-1/3 w-full">
                                                        <div class="md:block flex space-x-4" uk-sticky="offset: 91;bottom: true">
                                                            <div>                                                                
                                                                <img src="{{$userData['profilePic']}}" class="shadow-lg rounded-md w-32 md:w-full" alt="">
                                                            </div>
                                                            <div class="flex-1">
                                                                <ul class="my-5 text-sm space-y-2">
                                                                    @if($userData['createdAt'])
                                                                        <li> Registed : {{$userData['createdAtAgo']}}</li>
                                                                    @endif
                                                                    {{-- todo total courses --}}
                                                                    {{-- todo subjects --}}

                                                                    @if($userData['dobYear'])
                                                                        <li> Year of Birth : {{$userData['dobYear']}}</li>
                                                                    @endif

                                                                    <li> Username : {{$userData['username'] }}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="lg:w-2/3 flex-shrink-0 mt-10 lg:m-0">
                                                        <div>
                                                            <h2 class="font-semibold mb-3 text-xl lg:text-3xl">
                                                                {{$userData['fullName']}}                                                                
                                                            </h2>
                                                            <hr class="mb-5">

                                                            @if($userData['eduQualifications'])
                                                                <div class="space-y-2">
                                                                    {!! $userData['eduQualifications'] !!}
                                                                </div>
                                                                <hr class="mt-3 mb-3">
                                                            @endif

                                                            <div>
                                                                <h4 class="font-semibold mb-1 text-lg">Contact Information</h4>
                                                                <p class="mb-0 text-sm"><strong>Email</strong>: {{$userData['email']}}</p>
                                                                <p class="mt-0 text-sm"><strong>Phone</strong>: {{$userData['phone']}}</p>
                                                            </div>

                                                            <hr class="mt-3 mb-3">
                                                            <div>
                                                                <p class="mt-0 text-sm"><strong>Gender</strong>: {{$userData['gender']}}</p>
                                                                <p class="mt-0 text-sm"><strong>Account status</strong>: {{$userData['status'] == 1 ? 'Active' : 'Inactive'}}</p>
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
                    title="Error !" 
                    message="User Profile does not exist!"  
                    message2=""  
                    :canClose="false" />

            @endif


        </div>
    </div>

@stop
