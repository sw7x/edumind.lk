@extends('layouts.master')
@section('title','FAQ')




@section('content')
        <div class="lg:-mt-20 bg-gradient-to-tr to-purple-500 from-blue-600 lg:pb-12 lg:pt-36">
            <div class="container m-auto px-4">
                <div class="flex flex-col justify-center items-center lg:p-7 p-4 text-white">
                    {{--
                    <img src="http://local.edumind.com/storage/subjects/design_6148ba5c19679.jpg" class="absolute object-cover" alt="">
                    --}}
                    <div class="lg:text-4xl text-2xl font-semibold mb-6"> How can we help? </div>

                    <div class="bg-white mb-5 relative rounded-md lg:w-1/2 w-full shadow-lg" id="search" khidden="">
                     <ion-icon name="search-outline" class="absolute h-full hydrated left-3 text-lg md text-gray-600" role="img" aria-label="search outline"></ion-icon>
                     <input placeholder="Search" class="focus:outline-none h-12 pl-10 rounded-lg w-full">
                    </div>

                    <p class="text-sm text-center">
                        Popular help topics:
                        <a class="text-gray-200 hover:underline hover:text-white" href="#">pricing,</a>
                        <a class="text-gray-200 hover:underline hover:text-white" href="#">upgrade,</a>
                        <a class="text-gray-200 hover:underline hover:text-white" href="#">ebook,</a>
                        <a class="text-gray-200 hover:underline hover:text-white" href="#">membership</a>
                    </p>

                </div>
            </div>
        </div>



        <div class="main-container container py-12">
            <div class="lg:w-8/12 mx-auto">

                <h1 class="text-2xl font-semibold mb-4"> Basics</h1>
                <ul class="uk-accordion space-y-2" uk-accordion="">
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#">  Lorem ipsum dolor sit amet, consectetur adipiscing elit? </a>
                    <div class="uk-accordion-content mt-3">
                       <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                    </div>
                  </li>
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#"> Nullam massa sem, mollis luctus at, tincidut? </a>
                    <div class="uk-accordion-content mt-3">
                        <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                    </div>
                  </li>
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#"> Aliquam pretium diam et ullamcorper malesuada? </a>
                    <div class="uk-accordion-content mt-3">
                        <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                    </div>
                  </li>
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#">  Etiam suscipit at nisi eget auctor? </a>
                    <div class="uk-accordion-content mt-3">
                        <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                     </div>
                  </li>
                </ul>

                <h1 class="text-2xl font-semibold mb-2 mt-8"> Privecy</h1>
                <ul class="uk-accordion space-y-2" uk-accordion="">
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#">  Lorem ipsum dolor sit amet, consectetur adipiscing elit? </a>
                    <div class="uk-accordion-content mt-3">
                       <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                    </div>
                  </li>
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#"> Nullam massa sem, mollis luctus at, tincidut? </a>
                    <div class="uk-accordion-content mt-3">
                        <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                    </div>
                  </li>
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#"> Aliquam pretium diam et ullamcorper malesuada? </a>
                    <div class="uk-accordion-content mt-3">
                        <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                    </div>
                  </li>
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#">  Etiam suscipit at nisi eget auctor? </a>
                    <div class="uk-accordion-content mt-3">
                        <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                     </div>
                  </li>
                </ul>

                <h1 class="text-2xl font-semibold mb-2 mt-8"> Account</h1>
                <ul class="uk-accordion space-y-2" uk-accordion="">
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#">  Lorem ipsum dolor sit amet, consectetur adipiscing elit? </a>
                    <div class="uk-accordion-content mt-3">
                       <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                    </div>
                  </li>
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#"> Nullam massa sem, mollis luctus at, tincidut? </a>
                    <div class="uk-accordion-content mt-3">
                        <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                    </div>
                  </li>
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#"> Aliquam pretium diam et ullamcorper malesuada? </a>
                    <div class="uk-accordion-content mt-3">
                        <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                    </div>
                  </li>
                  <li class="bg-white px-6 py-4 rounded shadow hover:shadow-md">
                    <a class="uk-accordion-title text-base" href="#">  Etiam suscipit at nisi eget auctor? </a>
                    <div class="uk-accordion-content mt-3">
                        <p> Vivamus imperdiet venenatis est. Phasellus vitae mauris imperdiet, condimentum eros vel, ullamcorper turpis. Maecenas sed libero quis orci egestas vehicula fermentum id diam. In sodales quam quis mi mollis eleifend id sit amet velit. Sed ultricies condimentum magna, vel commodo dolor luctus in. Aliquam et orci nibh. Nunc purus metus, aliquam vitae venenatis sit amet, porta non est. Proin vehicula nisi eu molestie varius. Pellentesque semper ex diam, at tristique ipsum varius sed. Pellentesque non metus ullamcorper, iaculis nibh quis, facilisis lorem. Sed malesuada eu lacus sit amet feugiat. Aenean iaculis dui sed quam consectetur elementum. </p>
                     </div>
                  </li>
                </ul>

              </div>
        </div>

@stop
