@extends('admin-panel.layouts.master',['title' => 'Dashboard'])
@section('title','Dashboard')

@section('css-files')
@stop




@section('content')

    <div class="row" id="_sortable-view">
        <div class="col-lg-12">

            {{route('admin.404')}}<br />
            {{route('admin.500')}}<br />

            {{route('admin.course.add-2')}}<br />

			<h1 class="font-bold my-1">editor dashboard</h1>
            <h2 class="font-bold my-1">Total users</h2>
			[{{Sentinel::check()}}]
            <div class="row">

                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Teachers</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Students</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Marketers</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><div class="hr-line-dashed"></div>



    <div class="row" id="">
        <div class="col-lg-12">
            <h2 class="font-bold my-1">Category</h2>
            <div class="row">

                <div class="col-lg-4">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Total Subjects</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Published Subjects</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Draft Subjects</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><div class="hr-line-dashed"></div>


    <div class="row" id="">
        <div class="col-lg-12">
            <h2 class="font-bold my-1">Feedbacks</h2>
            <div class="row">

                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Teacher Feedbacks</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Student Feedbacks</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Marketer Feedbacks</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><div class="hr-line-dashed"></div>


    <div class="row" id="">
        <div class="col-lg-12">
            <h2 class="font-bold my-1">New Registrations <small>(today)</small></h2>

            <div class="row">

                <div class="col-lg-4">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Teachers</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Students</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Marketers</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><div class="hr-line-dashed"></div>





    <div class="row" id="">
        <div class="col-lg-12">
            <h2 class="font-bold my-1">Total earnings</h2>
            <div class="row">

                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Total earn amount</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Total used cupon code count</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Total cupon code discount</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><div class="hr-line-dashed"></div>


    <div class="row" id="">
        <div class="col-lg-12">
            <h2 class="font-bold my-1">Today Earnings</h2>
            <div class="row">

                <div class="col-lg-4">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Today earn amount</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Today used cupon code count</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Today total cupon code discount</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><div class="hr-line-dashed"></div>







    <div class="row" id="">
        <div class="col-lg-12">
            <h2 class="font-bold my-1">Course</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8 text-lg">Total courses</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Published courses</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-8  text-lg">Draft courses</div>
                            <div class="col-4 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row">
                            <div class="col-4 text-center">
                                <i class="fa fa-handshake-o fa-3x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <!-- <span>Course requests</span> -->
                                <h3 class="font-bold">Course requests</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-9 text-lg">Publish requests</div>
                            <div class="col-3 text-right">
                                <h3 class="font-bold ">217</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-9  text-lg">Draft requests</div>
                            <div class="col-3 text-right">
                                <h3 class="font-bold">217</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-9  text-lg">Change requests</div>
                            <div class="col-3 text-right">
                                <h3 class="font-bold">217</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-6">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-9 text-lg">Course enrollments <small>(today)</small></div>
                            <div class="col-3 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="widget style1 dark-gray-bg">
                        <div class="row vertical-align">
                            <div class="col-9  text-lg">Course completions <small>(today)</small></div>
                            <div class="col-3 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="hr-line-dashed"></div>





    <div class="row" id="">
        <div class="col-lg-12">
            <h2 class="font-bold my-1">User requests</h2>


            <div class="row">
                <div class="col-lg-6">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-9 text-lg">Teacher profile approve requests</div>
                            <div class="col-3 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-9  text-lg">Teacher profile disable requests</div>
                            <div class="col-3 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-9 text-lg">Teacher profile change requests</div>
                            <div class="col-3 text-right">
                                <h2 class="font-bold ">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="widget style1 dark-bg">
                        <div class="row vertical-align">
                            <div class="col-9  text-lg">Student profile change requests</div>
                            <div class="col-3 text-right">
                                <h2 class="font-bold">217</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="hr-line-dashed"></div>
@stop




@section('script-files')

@stop


@section('javascript')

@stop

