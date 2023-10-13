@extends('layouts.master')
@section('title', 'Acknowledgement')




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="__lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">
                    
                    <div class="mb-5">
                        @if(Session::has('message'))
                            <h2 class="font-semibold mb-3 text-xl lg:text-3xl">{{Session::get('msgTitle','Acknowledgement')}}</h2>
                            <hr class="mb-5">
                            <x-flash-message  
                                :class="Session::get('cls', 'flash-info')"  
                                :title="Session::get('msgTitle') ?? 'Info!'" 
                                :message="Session::get('message') ?? ''"  
                                :message2="Session::get('message2') ?? ''"  
                                :canClose="true" />
                        @else
                            <h2 class="font-semibold mb-3 text-xl lg:text-3xl">{{$title ?? 'Acknowledgement'}}</h2>
                            <hr class="mb-5">
                            <x-flash-message  
                                :class="$cls ?? 'flash-info'"  
                                :title="$msgTitle ?? 'Info!'" 
                                :message="$message ?? 'This alert box could indicate a neutral informative change or action.'"  
                                message2=""  
                                :canClose="false" />                            
                        @endif
                    </div>    
                    <br>        
                    

                    <div class="flex mt-5 justify-center">
                        <div class="mr-5">
                            <a href="{{route('home')}}" title="" class="btn bg-green-500 hover:bg-green-600 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Go to Home</a>
                        </div>
                    </div>

                    

                </div>
            </div>
        </div>
    </div>

    

    


@stop

