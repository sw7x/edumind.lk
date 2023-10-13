@extends('layouts.master')
@section('title','Teacher profile edit')


@section('css-files')
    <link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.css')}}">
    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css'>

@stop


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
                                                                    <li><a href="#" class="lg:px-2">Profile details</a></li>
                                                                    <li><a href="#" class="lg:px-2">Change password</a></li>
                                                                </ul>
                                                            </nav>

                                                            <div class="uk-switcher mt-5" id="t-profile-settings">

                                                                <div>
                                                                    <form class="" method="post" id="teacher-info-edit" enctype='multipart/form-data' action="./dist/upload.php">
                                                                        <h1 class="lg:text-2xl text-xl font-semibold mb-6">Teacher profile edit</h1>

                                                                        <div>
                                                                            <div>
                                                                                <input type="text" placeholder="Your Name"  name="fname" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                            </div>
                                                                        </div>

                                                                        <div>
                                                                            <input type="text" name="username" readonly placeholder="Username" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                        </div>

                                                                        <div>
                                                                            <input type="email" name="email" readonly placeholder="Info@example.com" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                        </div>

                                                                        <div>
                                                                            <input type="text" name="phone" placeholder="Phone" class="shadow-none with-border bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                                                                        </div>

                                                                        <div class="grid lg:grid-cols-2 gap-3 mt-3">
                                                                            <div>
                                                                                <div>
                                                                                    <label id="lbl2" class="control-label" for="dob2">Gender</label>
                                                                                    <select class="selectpicker" name="gender">
                                                                                        <option>Male</option>
                                                                                        <option>Female</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="">
                                                                                <!-- todo date validate -->
                                                                                <label id="lbl2" class="control-label" for="dob2">Date of Birth</label>
                                                                                <div class="controls shadow-none with-border">
                                                                                    <input name="dob" type="text" id="teacher-dob2" style="width: 9em;">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- <div class="mt-3">
                                                                        <label class="form-label" for="customFile">Profile picture</label>
                                                                        <input type="file" class="form-control" id="customFile" name="p_img" />
                                                                        </div> -->

                                                                        <div class="mt-3">
                                                                            <label class="form-label" for="customFile">Profile picture</label>
                                                                            <div id="dropzone" class="dropzone"></div>
                                                                            <!-- <input type="file" class="dropzone" id="dropzone" /> -->
                                                                        </div>

                                                                        <div class="mt-3">
                                                                            <textarea id="about" name="edu_details" cols="30" rows="7" class="with-border" placeholder="Education Details" autocomplete="off"></textarea>
                                                                        </div>

                                                                        <div class="grid lg:grid-cols-2 gap-3 mt-3">
                                                                            <div>
                                                                                <button id="sbmtbtn" type="submit" class="btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Submit</button>
                                                                            </div>
                                                                            <div>
                                                                                <button type="reset" class="btn bg-red-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Clear</button>
                                                                            </div>
                                                                        </div>

                                                                    </form>
                                                                </div>

                                                                <div class="">
                                                                    <form action="" method="post" enctype="multipart/form-data">

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


@section('script-files')
    <script  src="{{asset('js/dropzone.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js'></script>

@stop

@section('javascript')
<script>

	Dropzone.autoDiscover = false;

	$(document).ready(function () {

		var zdrop = new Dropzone('#dropzone', {
			//url: 'https://httpbin.org/post',
			url: '/dist/upload.php',
			paramName: "teacher_img", // The name that will be used to transfer the file
			maxFiles: 1,
			maxFilesize: 5, // MB
			addRemoveLinks: true,
			//acceptedFiles: "image/*",
			autoProcessQueue: false,
			dictDefaultMessage: "Move profile image here to upload",
			uploadMultiple: !1,
			thumbnailWidth: null,//the "size of image" width at px
			thumbnailHeight: null,//the "size of image" height at px
			removeFilePromise: function () {
				return new Promise((resolve, reject) => {
					let rand = Math.floor(Math.random() * 3);
					console.log(rand);
					if (rand == 0) reject('didnt remove properly');
					if (rand > 0) resolve();
				});
			},
			//accept: function(file, done) {},
			// previewTemplate: document.getElementById('preview-template').innerHTML
			init: function() {
				var myDropzone = this;

				//now we will submit the form when the button is clicked
				$("#sbmtbtn").on('click',function(e) {

					e.preventDefault();
					console.log(myDropzone.files[0]);
					console.log(myDropzone.getQueuedFiles().length);


					if (myDropzone.getQueuedFiles().length) {

						// $("<input />").attr("type", "file")
						//               .attr("name", "r-00-file")
						//               .attr("value", myDropzone.files[0])
						//               .appendTo("#teacher-info-edit");

						myDropzone.processQueue(); // upload files and submit the form
						//$('#frm1').submit();

					} else {

						$("<input />").attr("type", "hidden")
							.attr("name", "something")
							.attr("value", "777")
							.appendTo("#teacher-info-edit");

						$("<input />").attr("type", "file")
							.attr("name", "profile_img")
							.attr("value", null)
							.appendTo("#teacher-info-edit")
							.css('display','none');

						myDropzone.uploadFiles([]);

						//todo ajax submit
						$('#teacher-info-edit').submit();

					}

					//myDropzone.processQueue();

				});


				// Also if you want to post any additional data, you can do it here
				this.on('sending', function (data, xhr, formData) {
					//alert();
					formData.append("q2_uname", $('[name="fname"]').val());
					formData.append("q2_pass",  $('[name="phone"]').val());
					formData.append("q2_upload", myDropzone.files[0]);
				});



				// expand thumbnail to full width
				this.on('thumbnail', function(file, dataUrl) {
					var thumbs = document.querySelectorAll('.dz-image');
					[].forEach.call(thumbs, function (thumb) {
						var img = thumb.querySelector('img');
						if (img) {
							img.setAttribute('width', '100%');
							img.setAttribute('height', '100%');
						}
					});
				});


				//
				this.on("maxfilesexceeded", function(file){
					alert("No more files please!");
					console.log(file);
					this.removeFile(file);
				});



				//to load images that are in database
				var imageURL = 'https://sanet.pics/storage-7/0621/TBPodx7oR9VtKEOALHXF2fnaUiNIhcMQ.jpg';
				var mockFile = {
					name: 'FileName',
					size: '1000',
					type: 'image/jpeg',
					accepted: true ,           // required if using 'MaxFiles' option
					status: Dropzone.SUCCESS,
				};

				this.emit("addedfile", mockFile);
				this.emit("thumbnail", mockFile,imageURL);
				this.emit("complete", mockFile);
				this.files.push(mockFile);    // add to files array


			}// init end

		});


		$('#teacher-dob').datepicker({});
		$('#teacher-dob2').datepicker({});



	});
</script>
@stop

