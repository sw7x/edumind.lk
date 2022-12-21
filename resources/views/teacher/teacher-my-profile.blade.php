@extends('layouts.master')
@section('title','Teacher profile')


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
                                                                @if($userData->profile_pic)
                                                                    <img src="{{URL('/')}}/storage/{{$userData->profile_pic}}" class="shadow-lg rounded-md w-32 md:w-full" alt="">
                                                                @else
                                                                    <img src="{{asset('images/default-images/teacher-profile-pic.png')}}" class="shadow-lg rounded-md w-32 md:w-full" alt="">
                                                                @endif
                                                            </div>
                                                            <div class="flex-1">
                                                                <ul class="my-5 text-sm space-y-2">
                                                                    @if($userData->created_at)
                                                                        <li> Registed : {{$userData->created_at->diffForHumans()}}</li>
                                                                    @endif
                                                                    {{-- todo total courses --}}
                                                                    {{-- todo subjects --}}

                                                                    @if($userData->dob_year)
                                                                        <li> Year of Birth : {{$userData->dob_year}}</li>
                                                                    @endif

                                                                    <li> Profile ID : {{$userData->username }}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="lg:w-2/3 flex-shrink-0 mt-10 lg:m-0">
                                                        <div>
                                                            <h2 class="font-semibold mb-3 text-xl lg:text-3xl">{{$userData->full_name}}</h2>
                                                            <hr class="mb-5">

                                                            @if($userData->edu_qualifications)
                                                                <div class="space-y-2">
                                                                    {!! $userData->edu_qualifications !!}
                                                                </div>
                                                                <hr class="mt-3 mb-3">
                                                            @endif

                                                            <div>
                                                                <h4 class="font-semibold mb-0 text-base">Contact Information</h4>
                                                                <p class="mb-0"><strong>Email</strong>: {{$userData->email}}</p>
                                                                <p class="mt-0"><strong>Phone</strong>: {{$userData->phone}}</p>
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
            @endif

        </div>
    </div>

@stop
