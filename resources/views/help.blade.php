@extends('layouts.master')
@section('title','Student profile help')


@section('content')
    <div class="main-container container">
        <div class="max-w-full  md:p-2 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">

                <div style="flex:1">
                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Help Page</h2>
                    <hr class="mb-5">
                    <!-- <h4 class="font-semibold mb-2 text-base"> Description </h4>    -->

                    <section class="tabs-section">
                        <div class="_container">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="tube-card p-3 lg:p-6">
                                    
                                        <x-flash-message
                                            class="flash-success" 
                                            title=""
                                            message="" 
                                            :canClose="false">
                                            <x-slot name="insideContent">
                                                <a href="{{route('about-us')}}" class="_hover:underline hover:text-blue-500">
                                                    <div class="text-lg"><strong>EDUMIND අපි</strong></div>
                                                    <p class="text-base">ඔබත් යමක් පැහැදිලිව විස්තර කර දීමට හැකියාව ඇති, තමන් සතු දැනුමෙන් අන් අයට ප්රයෝජනයක් ගෙන දීමට කැමැත්තක්...</p>
                                                </a>
                                            </x-slot>        
                                        </x-flash-message>

                                        <x-flash-message
                                            class="flash-success" 
                                            title=""
                                            message="" 
                                            :canClose="false">
                                            <x-slot name="insideContent">
                                                <a href="{{route('terms-and-services')}}" class="_hover:underline hover:text-blue-500">
                                                    <div class="text-lg"><strong>EDUMIND වෙතින් ඔබට ලබාගත හැකි ආදායම</strong></div>
                                                    <p class="text-base">Edumind වෙතින් ඔබට ලබාගත හැකි ආදායම් පිළිබඳව අදහසක් ලබාගැනීම පිණිස මෙම කොටස හොඳින් අධ්යයන කරන මෙන්...</p>
                                                </a>
                                            </x-slot>        
                                        </x-flash-message>

                                        <x-flash-message
                                            class="flash-success" 
                                            title=""
                                            message="" 
                                            :canClose="false">
                                            <x-slot name="insideContent">
                                                <a href="{{route('why-choose-us')}}" class="_hover:underline hover:text-blue-500">
                                                    <div class="text-lg"><strong>EDUMIND වෙතින් ඔබට ලැබෙන ප්රතිලාභ</strong></div>
                                                    <p class="text-base">ඔබ සාම්ප්රදායික tution ගුරුවරයෙක් නම් ඔබේ ශිෂ්යයන් හා සම්බන්ධ වීමේ හැකියාව සිමිත විය හැකිය. ඊට ප්රධාන හේතුව වන්නේ..</p>
                                                </a>
                                            </x-slot>        
                                        </x-flash-message>

                                        <x-flash-message
                                            class="flash-success" 
                                            title=""
                                            message="" 
                                            :canClose="false">
                                            <x-slot name="insideContent">
                                                <a href="{{route('instructions')}}" class="_hover:underline hover:text-blue-500">
                                                    <div class="text-lg"><strong>EDUMIND වෙත පාඨමාලාවක් සම්පාදනය කිරීම</strong></div>
                                                    <p class="text-base">ඔබට online courses නිර්මාණය කිරීමට කිසිඳු මූලික දැනුමක් නොමැති වුවත් Edumind සමග සම්බන්ධ වීමට හැකියාව ඇති බව...</p>
                                                </a>
                                            </x-slot>        
                                        </x-flash-message>

                                    </div>
                                </div>                                

                            </div>
                        </div>
                    </section>

                </div>

            </div>
        </div>
    </div>
@stop
