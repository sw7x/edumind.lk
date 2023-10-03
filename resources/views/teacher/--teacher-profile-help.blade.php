@extends('layouts.master')
@section('title','Teacher profile help')


@section('content')
    <div class="main-container container">
        <div class="max-w-full  md:p-2 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">

                    <div style="flex:1">
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Empty Page</h2>
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
                                                <div class="row">
                                                    <div class="col-lg-12">

                                                        <div class="tube-card p-3 lg:p-6">
                                                            <h2 class="font-semibold mb-3 text-base">Learn The Basic Of VUE JS .</h2>
                                                            <hr class="mb-5">
                                                            <h4 class="font-semibold mb-2 text-base"> Description </h4>
                                                            <div class="space-y-2">

                                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                                                    tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam,
                                                                quis nostrud exerci tation ullamcorper</p>
                                                                <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod
                                                                    mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                                    elit, sed diam nonummy nibh euismod quis nostrud exerci tation ullamcorper tincidunt ut
                                                                    laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud
                                                                exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                                                                <p>mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing
                                                                    elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat
                                                                    volutpat. Ut wisi enim ad minim veniam,suscipit lobortis nisl ut aliquip ex ea commodo
                                                                consequat</p>
                                                                <b> Assum consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt</b>
                                                                <p>Diam nonummy nibh euismod erat volutpat. Ut wisi enim ad minim veniam, quis nostrud
                                                                exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat</p>
                                                                <p>laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam</p>
                                                                <h4>Book Information</h4>
                                                                <p class="mb-0"><strong>Page Count</strong>: 118</p>
                                                                <p class="mt-0"><strong>Word Count</strong>: 15872</p>
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
        </div>
    </div>
@stop
