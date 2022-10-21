@extends('layouts.master')
@section('title','Student profile edit')


@section('content')
    <div class="main-container container">
        <div class="max-w-full  md:p-2 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">

                <div style="flex:1">
                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Edit profile</h2>
                    <hr class="mb-5">
                    <!-- <h4 class="font-semibold mb-2 text-base"> Description </h4>    -->

                    <section class="tabs-section">
                        <div class="_container">
                            <div class="row">

                                <div class="col-md-3 col-lg-3 nav-section">
                                    @include('includes.student-profile-menu')
                                </div>

                                <div class="col-md-9 col-lg-9">

                                    <div class="tab-content content-section">
                                        <div class="tab-pane active show" id="tab-1">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <div class="tube-card p-3 lg:p-6">

                                                        <nav class="cd-secondary-nav md:m-0 -mx-4 nav-small mb-5">
                                                            <ul uk-switcher="connect: #profile-settings ;animation: uk-animation-fade ; toggle: > * ">
                                                                <li><a href="#" class="lg:px-2">Profile details</a></li>
                                                                <li><a href="#" class="lg:px-2">Change password</a></li>
                                                            </ul>
                                                        </nav>


                                                        <div class="uk-switcher mt-5" id="profile-settings">

                                                            <div>
                                                                <form class="">
                                                                    <h2 class="lg:text-2xl text-xl font-semibold mb-6">Profile details</h2>

                                                                    <div>
                                                                        <div>
                                                                            <input type="text" placeholder="Your Name"  id="first-name" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                        </div>
                                                                    </div>

                                                                    <div>
                                                                        <input type="text" readonly placeholder="Username" id="username" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                    </div>

                                                                    <div>
                                                                        <input type="email"  readonly placeholder="Info@example.com" id="email" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                    </div>

                                                                    <div>
                                                                        <input type="text" placeholder="Phone" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                    </div>

                                                                    <div class="grid lg:grid-cols-2 gap-3 mt-3">
                                                                        <div>
                                                                            <div>
                                                                                <label id="lbl2" class="control-label" for="dob2">Gender</label>
                                                                                <select class="selectpicker">
                                                                                    <option>Male</option>
                                                                                    <option>Female</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="">
                                                                            <!-- todo date validate -->
                                                                            <label id="lbl2" class="control-label" for="dob2">Date of Birth</label>
                                                                            <div class="controls shadow-none with-border">
                                                                                <input type="text" id="dob2" style="width: 9em;">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="grid lg:grid-cols-2 gap-3 mt-2">
                                                                        <div>
                                                                            <button type="" class="btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Update</button>
                                                                        </div>
                                                                        <div>
                                                                            <button type="reset" class="btn bg-red-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Reset</button>
                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                            <div class="">
                                                                <form action="" method="post" enctype="multipart/form-data" _lpchecked="1">
                                                                    <h2 class="lg:text-2xl text-xl font-semibold mb-6">Change password</h2>

                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="tutor-form-group">
                                                                                <!-- <label> Current Password </label> -->
                                                                                <input type="password" name="previous_password"  placeholder="Current Password" autocomplete="off" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full shadow-none with-border">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="tutor-form-group">
                                                                                <!-- <label>New Password</label> -->
                                                                                <input type="password" name="new_password" placeholder="New Password" placeholder="New Password" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full shadow-none with-border">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="tutor-form-group">
                                                                                <!-- <label>Confirm New Password</label> -->
                                                                                <input type="password" name="confirm_new_password" placeholder="Confirm New Password" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full shadow-none with-border">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-2">
                                                                        <div class="col-md-12">
                                                                            <button type="" class="btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Reset Password</button>
                                                                        </div>
                                                                    </div>

                                                                </form>

                                                            </div>

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


@section('javascript')
<script>
	$('#stud-dob').datepicker({
		format: 'yyyy-mm-dd',
		endDate: '+0d',
		autoclose: true
	});
</script>
@stop
