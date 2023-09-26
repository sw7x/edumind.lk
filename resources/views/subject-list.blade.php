@extends('layouts.master')
@section('title','Subjects')




@section('content')
        <div class="main-container container lg:px-24 mx-auto">
            <div class="text-2xl font-semibold mb-4 text-black">Browse subjects</div>

            @if(isset($message))
                <div class="flash-msg {{$cls ?? 'flash-info'}}">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{$msgTitle ?? 'Info!'}}</strong></div>
                    <p>{{ $message ?? 'Info!' }}</p>
                    <div class="text-base">{!! $message2 ?? '' !!}</div>
                </div>            
            @else
                @isset($subjects)
                <div class="grid lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-4 mt-3">
                    @forelse($subjects as $item)
                        <a href="{{URL('/')}}/subject/{{$item['slug']}}" class="rounded-md overflow-hidden relative w-full lg:h-56 h-40">
                            <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                            </div>
                            <img src="{{$item['image']}}" class="absolute w-full h-full object-cover" alt="">                       
                            <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg">{{$item['name']}}</div>
                        </a>
                    @empty
                        <p class="text-xl font-semibold mb-4 text-black">No subjects</p>
                    @endforelse
                </div>
                @endisset
            @endif
            
            
            

        </div>
@stop
