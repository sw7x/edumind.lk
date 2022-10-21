@extends('layouts.master')
@section('title','Form submit')




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="__lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">

                    <div>
                        @if(Session::has('message'))
                            <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                                <a href="#" class="close">×</a>
                                <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                                <p>{{ Session::get('message') ?? 'Info!' }}</p>
                                <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                            </div>
                        @else
                            <h2 class="font-semibold mb-3 text-xl lg:text-3xl">{{$title ?? 'Form submit'}}</h2>
                            <hr class="mb-5">

                            <div class="flash-msg {{$cls ?? 'flash-info'}}">
                                <div class="text-lg"><strong>{{$msgTitle ?? 'Info!'}}</strong></div>
                                <p>{{$message ?? 'This alert box could indicate a neutral informative change or action.'}}</p>
                            </div>                            
                        @endif
                            <p>Go back to <a href="{{route('home')}}" class="text-blue-500" >Home</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    

    


@stop

