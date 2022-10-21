@extends('layouts.master')
@section('title','Add Course content')

@section('css-files')
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop


@section('content')
    <div class="main-container container">
        <div class="max-w-full  md:p-2 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">

                <div style="flex:1">
                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Course content</h2>
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

                                                        <nav class="cd-secondary-nav md:m-0 -mx-4 nav-small mb-5">
                                                            <ul uk-switcher="connect: #t-profile-settings ;animation: uk-animation-fade ; toggle: > * ">
                                                                <li><a href="#" class="lg:px-2">Sections topics</a></li>
                                                                <li><a href="#" class="lg:px-2">Content in sections</a></li>
                                                            </ul>
                                                        </nav>

                                                        <div class="uk-switcher mt-5" id="t-profile-settings">

                                                            <div>
                                                                <h1 class="lg:text-2xl text-xl font-semibold mt-1 mb-2">Sections topics</h1>

                                                                <div class="mb-10">
                                                                    <select class="" id="select-course" name="states">
                                                                        <option></option>
                                                                        @include('includes.country-list')
                                                                    </select>
                                                                </div>

                                                                <div class="accordion-sec-item-wrapper">
                                                                    <div class="accordion-sec-item">

                                                                        <div class="flex justify-between">
                                                                            <label class="mb-0 text-base">Section 1 Title</label>
                                                                            <a href="#" class="delete-section text-lg text-blue-500 ">
                                                                                <ion-icon name="delete-item" class="font-semibold icon-feather-x-circle"></ion-icon>
                                                                            </a>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <input class="shadow-none with-border bg-gray-100 h-12 mt-1 px-3 rounded-md w-full" type="text" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group text-right add-new-wrapper">
                                                                            <a class="text-sm text-blue-500 btn-add-new-section py-2" href="#">
                                                                                <ion-icon class="text-lg font-semibold icon-feather-plus-circle leading-4"></ion-icon> Add New</a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="flex justify-end mt-5">
                                                                    <div class="">
                                                                        <button type="submit" class="w-64 btn bg-blue-600 font-semibold p-2.5  rounded-md text-center text-white">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="">
                                                                <h1 class="lg:text-2xl text-xl font-semibold mt-1 mb-2">Content in sections</h1>

                                                                <div class="mb-10">
                                                                    <div class="mb-5">
                                                                        <select class="" id="select-course2" name="states">
                                                                            <option></option>
                                                                            @include('includes.country-list')
                                                                        </select>
                                                                    </div>
                                                                    <div>
                                                                        <select class="" id="select-section" name="section">
                                                                            <option></option>
                                                                            @include('includes.country-list')
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="accordion-sec-link-item-wrapper">
                                                                    <div class="accordion-link-item">

                                                                        <div class="flex justify-between">
                                                                            <label class="mb-0 text-base">Link 1 Title</label>
                                                                            <a href="#" class="delete-link text-lg text-blue-500 ">
                                                                                <ion-icon class="font-semibold icon-feather-x-circle"></ion-icon>
                                                                            </a>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <input class="shadow-none with-border bg-gray-100 h-12 mt-1 px-3 rounded-md w-full" type="text" />
                                                                        </div>


                                                                        <div class="flex justify-end mt-1 pt-1">
                                                                            <div class="checkbox">
                                                                                <input type="checkbox" id="chekcbox1">
                                                                                <label for="chekcbox1" class="font-semibold text-sm">
                                                                                    <span class="border border-blue-600 rounded-none checkbox-icon"></span>Free</label>
                                                                            </div>
                                                                            <div class="checkbox ml-5">
                                                                                <input type="checkbox" id="chekcbox2">
                                                                                <label for="chekcbox2" class="font-semibold text-sm">
                                                                                    <span class="border border-blue-600 rounded-none checkbox-icon"></span>Donload link</label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group text-right add-new-wrapper">
                                                                            <a class="text-sm text-blue-500 btn-add-new-link py-2" href="#">
                                                                                <ion-icon class="text-lg font-semibold icon-feather-plus-circle leading-4"></ion-icon> Add New</a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="flex justify-end mt-5">
                                                                    <div class="">
                                                                        <button type="submit" class="w-64 btn bg-blue-600 font-semibold p-2.5  rounded-md text-center text-white">Submit</button>
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

                            </div>
                        </div>
                    </section>

                </div>

            </div>
        </div>
    </div>
@stop

@section('script-files')
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stop


@section('javascript')
<script>
    $('#select-course2').select2({
        placeholder: "Select a course",
        allowClear: true,
        width: '100%'
    });

	$('#select-course').select2({
		placeholder: "Select a course",
		allowClear: true
	});

	$('#select-section').select2({
		placeholder: "Select a section in course",
		allowClear: true,
		width: '100%'
	});
</script>
@stop



