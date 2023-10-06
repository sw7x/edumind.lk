@extends('layouts.master')
@section('title','Default page')



@section('content')

    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">

                    <div>
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Learn The Basic Of VUE JS .</h2>
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

                        <div class="flash-msg flash-success">
                            <a href="#" class="close">×</a>
                            <strong>Success!</strong> This alert box could indicate a successful or positive action.
                        </div>
                        <div class="flash-msg flash-info">
                            <a href="#" class="close">×</a>
                            <strong>Info!</strong> This alert box could indicate a neutral informative change or action.
                        </div>
                        <div class="flash-msg flash-warning">
                            <a href="#" class="close">×</a>
                            <strong>Warning!</strong> This alert box could indicate a warning that might need attention.
                        </div>
                        <div class="flash-msg flash-danger">
                            <a href="#" class="close">×</a>
                            <strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop
