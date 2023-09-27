@extends('layouts.master')
@section('title','Form submit')




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="__lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">

                    <div>
                        @if(Session::has('message'))
                            <x-flash-message  
                                :class="Session::get('cls', 'flash-info')"  
                                :title="Session::get('msgTitle') ?? 'Info!'" 
                                :message="Session::get('message') ?? ''"  
                                :message2="Session::get('message2') ?? ''"  
                                :canClose="true" />
                        @else
                            <h2 class="font-semibold mb-3 text-xl lg:text-3xl">{{$title ?? 'Form submit'}}</h2>
                            <hr class="mb-5">

                            <x-flash-message  
                                :class="$cls ?? 'flash-info'"  
                                :title="$msgTitle ?? 'Info!'" 
                                :message="$message ?? 'This alert box could indicate a neutral informative change or action.'"  
                                message2=""  
                                :canClose="false" />
                            
                        @endif
                            <p>Go back to <a href="{{route('home')}}" class="text-blue-500" >Home</a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    

    


@stop

