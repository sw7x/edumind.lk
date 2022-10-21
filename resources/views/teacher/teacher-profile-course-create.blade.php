@extends('layouts.master')
@section('title','Add Course')

@section('css-files')
<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.steps.css')}}">
<link rel="stylesheet" href="{{asset('summernote-0.8.18/summernote-lite.css')}}">
<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css'>

@stop



@section('content')
    <div class="main-container container">
        <div class="max-w-full  md:p-2 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">

                <div style="flex:1">
                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Add course</h2>
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
                                                        <!-- <h4 class="font-semibold mb-2 text-base"> Description </h4>    -->

                                                        <form class="" id="course-create-form" method="post">
                                                            <div id="wizard" class="-m-2">

                                                                <h2>First Step</h2>
                                                                <section class="wisywig-editor">
                                                                    <textarea class="" name="course_desc " id="summernote"></textarea>
                                                                </section>

                                                                <h2>Second Step</h2>
                                                                <section>
                                                                    <p>11111 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ut nulla nunc. Maecenas arcu sem, hendrerit a tempor quis,
                                                                        sagittis accumsan tellus. In hac habitasse platea dictumst. Donec a semper dui. Nunc eget quam libero. Nam at felis metus.
                                                                        Nam tellus dolor, tristique ac tempus nec, iaculis quis nisi.</p>
                                                                        <br>
                                                                        <ul>
                                                                            <li>Coffee</li>
                                                                            <li>Tea</li>
                                                                            <li>Milk</li>
                                                                        </ul>  <br>

                                                                        <h2>An Ordered HTML List</h2>

                                                                        <ol>
                                                                            <li>Coffee</li>
                                                                            <li>Tea</li>
                                                                            <li>Milk</li>
                                                                        </ol>
                                                                </section>


                                                                <h2>Third Step</h2>
                                                                <section>
                                                                    <div>
                                                                        <div>
                                                                            <input name="fname" type="text" required placeholder="Your Name"  id="first-name" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                        </div>
                                                                    </div>

                                                                    <div>
                                                                      <input name="uname" type="text" placeholder="Username" id="username" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                    </div>

                                                                    <div>
                                                                      <input name="email" type="email"  placeholder="Info@example.com"  class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                    </div>
                                                                </section>

                                                                <h2>Fourth Step</h2>
                                                                <section>
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

                                                                    <div class="grid lg:grid-cols-2 gap-3">
                                                                        <div>
                                                                            <button type="submit" class="btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Update</button>
                                                                        </div>
                                                                        <div>
                                                                            <button type="reset" class="btn bg-red-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Reset</button>
                                                                        </div>
                                                                    </div>
                                                                </section>

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
                    </section>

                </div>

            </div>
        </div>
    </div>
@stop



@section('script-files')
    <script src="{{asset('js/jquery.steps.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('summernote-0.8.18/summernote-lite.js')}}"></script>
@stop




@section('javascript')
<script>
	$(function(){

		$("#wizard").steps({
			headerTag: "h2",
			bodyTag: "section",
			transitionEffect: "slideLeft",
			//stepsOrientation: "vertical",
			stepsOrientation: "horizontal",
			onFinished: function (event, currentIndex) {

				let email = $("input[name=email]").val();
				var textareaValue = $('#summernote').summernote('code');

				//alert(email);
				console.log(textareaValue);

				$("#course-create-form").submit();
			}
		});

		$('textarea#summernote').summernote({
			placeholder: 'Hello bootstrap 4',
			tabsize: 2,
			height: 250,
			width: '100%',
			toolbar: [

				['style', ['style']],
				//['font', ['bold', 'italic', 'underline', 'clear']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['table', ['table']],
				['insert', [
					'link',
					//'picture',
					//'video',
					'hr'
				]
				],
				['view', [
					//'fullscreen',
					'codeview',
					'help']
				]
			],
		});

	});
</script>
@stop
