@extends('layouts.master')
@section('title','Subjects')




@section('content')
        <div class="main-container container lg:px-24 mx-auto">
            {{-- topics == subjects           --}}




            <div class="text-2xl font-semibold mb-4 text-black">Browse topics</div>

            <div class="grid lg:grid-cols-4 md:grid-cols-3 grid-cols-2 gap-4 mt-3">
                @forelse($subjects as $item)
                    <a href="{{URL('/')}}/subject/{{$item->slug}}" class="rounded-md overflow-hidden relative w-full lg:h-56 h-40">
                        <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                        </div>

                        @if($item->image)
                            <img src="{{URL('/')}}/storage/{{$item->image}}" class="absolute w-full h-full object-cover" alt="">
                        @else
                            <img src="{{asset('images/default-images/subject.png')}}" class="absolute w-full h-full object-cover" alt="">
                        @endif

                        <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg">{{$item->name}}</div>
                    </a>
                @empty
                    <p class="text-xl font-semibold mb-4 text-black">No topics</p>
                @endforelse










            </div>

        </div>
@stop
