@extends('layouts.master')
@section('title','Subjects')




@section('content')
    <div class="main-container container lg:px-24 mx-auto">
        <div class="text-2xl font-semibold mb-4 text-black">Browse subjects</div>

        @if(isset($subjects) && is_array($subjects))
            @if(!empty($subjects))
                <div class="grid lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-4 mt-3">
                    @foreach($subjects as $item)
                        <a href="{{route('subjects.show', $item['slug'])}}" class="rounded-md overflow-hidden relative w-full lg:h-56 h-40">
                            <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                            </div>
                            <img src="{{$item['image']}}" class="absolute w-full h-full object-cover" alt="">                       
                            <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg">{{$item['name']}}</div>
                        </a>
                    @endforeach
                </div>
            @else
                <x-flash-message 
                    class="flash-danger"  
                    title="No subjects!" 
                    message=""  
                    message2=""  
                    :canClose="false" />
            @endif    
        @else
            <div class="my-5">
                <x-flash-message 
                    class="flash-danger"  
                    title="Data not available!" 
                    message="Subject data list is not available or not in correct format"  
                    message2=""  
                    :canClose="false" />
            </div>
        @endif         
            
    </div>
@stop
