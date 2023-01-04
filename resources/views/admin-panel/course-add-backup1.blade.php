@extends('admin-panel.layouts.master')
@section('title','Add course')


@section('css-files')
<!-- select2 -->
<link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<link rel="stylesheet" href="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.css')}}">
<!-- <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">-->

<link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

<link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond-plugin-image-preview.min.css')}}">
<link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond.min.css')}}">
@stop



@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="tabs-container">

                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link" data-toggle="tab" href="#tab-add-course">
                            <span class="custom-label label label-warning mr-2">step1</span>Add course details</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-add-topics">
                            <span class="custom-label label label-warning mr-2">step2</span>Add couse topics</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-add-course-content">
                            <span class="custom-label label label-warning mr-2">step3</span>Add course content</a></li>
                </ul>

                <div class="tab-content mb-3">

                    <!-- add-course tab -->
                    <div role="tabpanel" id="tab-add-course" class="tab-pane ">
                        <div class="panel-body">



                            <h3>Add new course</h3>

                            <form class="" id="" action="" method="POST">

                                <div class="form-group  row">
                                    <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                    <div class="col-sm-8"><input type="text" name="course-name" class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Subject <span class="text-red-500 text-sm font-bold">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control m-b" id="subject" name="subject">
                                            <option>option 1</option>
                                            <option>option 2</option>
                                            <option>option 3</option>
                                            <option>option 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Teacher <span class="text-red-500 text-sm font-bold">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control m-b" id="teacher" name="teacher">
                                            <option>option 1</option>
                                            <option>option 2</option>
                                            <option>option 3</option>
                                            <option>option 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>



                                <div class="form-group row"><label class="col-sm-4 col-form-label">Heading text</label>
                                    <div class="col-sm-8">
                                        <div class="border">
                                                        <textarea class="form-control" required="required" name="course-heading"
                                                                  cols="30" rows="7" placeholder="" autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>


                                <div class="form-group row"><label class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-8">
                                        <div class="border-edu">
                                            <textarea rows="3" class="form-control" required="required" name="course-description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group row"><label class="col-sm-4 col-form-label">Course image</label>
                                    <div class="col-sm-8">
                                        <input type="file" class="course-img" name="course-img">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group  row">
                                    <label class="col-sm-4 col-form-label">Duration<br> <small>X Hours : Y minutes</small></label>
                                    <div class="col-sm-8"><input type="text" name="video-duration" class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group  row">
                                    <label class="col-sm-4 col-form-label">Videos <small>(count)</small></label>
                                    <div class="col-sm-8"><input type="text" name="video-count" class="form-control"></div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group  row">
                                    <label class="col-sm-4 col-form-label">Price</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon">Rs</span>
                                            </div>
                                            <input type="text" name="course-price" class="form-control"><br>
                                        </div>

                                        <!--
                                        <div class="input-group-append">
                                            <span class="input-group-addon">.00</span>
                                        </div> -->
                                        <span class="form-text m-b-none">Leave blank if course is free.</span>

                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>






                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Submit status</label>

                                    <div class="col-sm-8">
                                        <div class="i-checks">
                                            <label> <input type="radio" value="draft" name="course_stat"> <i></i> Draft </label>
                                        </div>
                                        <div class="i-checks">
                                            <label> <input type="radio" checked="" value="published" name="course_stat"> <i></i> Published </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>



                                <div class="form-group row">
                                    <div class="col-sm-4 offset-sm-4">
                                        <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                        <button class="btn btn-danger btn-sm" type="reset">Cancel</button>
                                    </div>
                                </div>

                            </form>


                        </div>
                    </div>
                    <!--  -->


                    <div role="tabpanel" id="tab-add-topics" class="tab-pane">
                        <div class="panel-body">


                            <h3>Add couse topics</h3>


                            <div class="_px-3 row mt-4 mb-4">
                                <div class="col-sm-11">
                                    <label class="col-form-label">Select course</label>
                                    <select class="form-control" id="status">
                                        <option value="all">All</option>
                                        <option value="active">Active</option>
                                        <option value="pending">Pending</option>
                                        <option value="deleted">Deleted</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-11">
                                    <label class="col-form-label">Add topics</label>
                                    <input type="text" class="input add-topics form-control" placeholder="Add topics">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-11 align-middle">
                                    <input type="button" id="add-topics-btn" class="float-right btn btn-primary btn-sm" value="Add">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-11">
                                    <div class="msg-div"></div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="course-topic-list-area col-sm-11">
                                    <ul id="course-topic-list"></ul>
                                </div>
                            </div>




                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <div class="course-topics-json-result"></div>
                                </div>
                                <div class="col-sm-3">
                                    <input type="button" class="float-right btn btn-primary btn-sm" id="json-btn" value="json">
                                </div>
                            </div>


                        </div>
                    </div>



                    <div role="tabpanel" id="tab-add-course-content" class="tab-pane">
                        <div class="panel-body">


                            <h3>Add couse content</h3>



                            <div class="_px-3 row mb-3">
                                <div class="col-sm-11">
                                    <label class="col-form-label">Select course</label>
                                    <select class="form-control" id="status">
                                        <option value="all">All</option>
                                        <option value="active">Active</option>
                                        <option value="pending">Pending</option>
                                        <option value="deleted">Deleted</option>
                                    </select>
                                </div>
                            </div>




                            <div class="_px-3 row mb-3">
                                <div class="col-sm-11">
                                    <label class="col-form-label">Select topic</label>
                                    <select class="form-control" id="status">
                                        <option value="all">All</option>
                                        <option value="active">Active</option>
                                        <option value="pending">Pending</option>
                                        <option value="deleted">Deleted</option>
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-11">

                                    <label class="col-form-label">Content</label>
                                    <form class="pcourse-content-form add px-1 py-1">
                                        <div class="form-group  row">
                                            <div class="col-sm-12 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">Text</span>
                                                    </div>
                                                    <input type="text" name="content-text" class="form-control"><br>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">Url</span>
                                                    </div>
                                                    <input type="text" name="content-url" class="form-control"><br>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon"><b>Duration/Size</b></span>
                                                    </div>
                                                    <input id="link_param" name="link_param" type="text" class="form-control"><br>
                                                </div>
                                            </div>


                                            <div class="offset-sm-4 col-sm-2">
                                                <div class="float-right i-checks">
                                                    <label class="mb-0"> <input type="checkbox" value="" name="is_free"> <i></i> <b>--Free</b> </label>
                                                </div>
                                            </div>


                                            <div class="col-sm-3 -ml-1">
                                                <div class="float-right i-checks">
                                                    <label class="mb-0"> <input type="checkbox" value="" name="is_download"> <i></i> <b>Download link</b> </label>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-11 align-middle">
                                    <input type="button" id="add-course-content" class="float-right btn btn-primary btn-sm" value="Add">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-11">
                                    <div class="msg-div"></div>
                                </div>
                            </div>



                            <div class="row mb-3">
                                <div class="course-content-list-area col-sm-11">
                                    <ul id="course-content-list"></ul>
                                </div>
                            </div>



                            <div class="row mb-3">
                                <div class="col-sm-8">
                                    <div class="course-content-json-result"></div>
                                </div>
                                <div class="col-sm-3">
                                    <input type="button" class="float-right btn btn-primary btn-sm" id="json-btn" value="json">
                                </div>
                            </div>



                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@stop




@section('script-files')
    <!-- iCheck -->
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>


    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>


    <!-- SUMMERNOTE -->
    <!-- <script src="../assets/summernote-0.8.18/summernote-lite.js"></script> -->
    <script src="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.js')}}"></script>

    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-encode.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-size.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-exif-orientation.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-preview.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-type.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond.min.js')}}"></script>
@stop

@section('javascript')
    <script>

		(function () {
			/* We want to preview images, so we need to register the Image Preview plugin  */
			FilePond.registerPlugin(

				// encodes the file as base64 data
				FilePondPluginFileEncode,

				// validates the size of the file
				FilePondPluginFileValidateSize,

				// corrects mobile image orientation
				FilePondPluginImageExifOrientation,

				// previews dropped images
				FilePondPluginImagePreview,

				FilePondPluginFileValidateType
			);

			// Select the file input and use create() to turn it into a pond
			const pond = FilePond.create(document.querySelector('.course-img'));


		})();


		jQuery(document).ready(function ($) {
			let selectedTab = window.location.hash;
			selectedTab = (selectedTab=='')?'#tab-add-course':selectedTab;
			$('.nav-link[href="' + selectedTab + '"]' ).trigger('click');

			//Prevent default hash behavior on page load
			window.scrollTo(0,0);
		});


		$(document).ready(function(){


			$("#subject").select2({
				placeholder: "Select student gender",
				allowClear: true,
				width: '100%'
			});
			$("#teacher").select2({
				placeholder: "Select marketer gender",
				allowClear: true,
				width: '100%'
			});










			$('[name="course-description"]').summernote({
				//placeholder: 'Hello bootstrap 4',
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


        //for course topics
		$(document).ready(function() {

			// generate json
			$("#tab-add-topics #json-btn").on("click", function(){
				//alert();
				var vc = [];
				$(".course-topic-list-area ul#course-topic-list li input.edit:not(.close)").each(function(i,el){
					//console.log(el);
					vc.push(el);
				});
				console.log(vc);

				if(vc.length == 0){
					var mvar = {};
					$(".course-topic-list-area ul#course-topic-list li p").each(function(i,el) {
						mvar[i] = $(this).html();
						//mvar.push($(this).html())
					});
					console.log(mvar);
					console.log(JSON.stringify(mvar));

					$('.course-topics-json-result').html(JSON.stringify(mvar));
				}else{
					//$('.course-json-result').html(JSON.stringify(mvar));
					alert('finish edit before submit');
				}
			});



			//when enter key press add to list
			$("#tab-add-topics input.add-topics").on("keyup", function(event){
				//console.log(event.keyCode);
				if (event.keyCode === 13) {
					// Cancel the default action, if needed
					event.preventDefault();
					// Trigger the button element with a click
					$("#add-topics-btn").click();
				}
			});


			//add to list
			$("#add-topics-btn").on("click", function() {

				var inp_ele = $("input.add-topics").val(),

					close_i     = '<a href="" class="delete-btn"><i class="fa fa-times"></i></a>',
					edit_i      = '<a href="" class="edit-btn"><i class="fa fa-pencil"></i></a>',
					edit_inp    = '<input type="text" class="edit close">';
				ok_i        = '<a href="" class="ok-btn"><i class="fa edit fa-check"></i></a>';
				//ok_i = '<input type="button" value="ok" class="ok ok-btn">';

				if (inp_ele != "") {

					if(checkItemExsist(inp_ele,null) == true){
						$("#tab-add-topics .msg-div").text("Can't be duplicate!");
					}else{
						$(".course-topic-list-area ul#course-topic-list").append("<li>" +
							"<p>" + inp_ele + "</p>" +
							close_i + edit_i + ok_i +  edit_inp +
							"</li>");

						$("#tab-add-topics .msg-div").text("");
					}

				} else {
					$("#tab-add-topics .msg-div").text("Can't be empty!");
				}
				$("input.add-topics").val("");
			});


			//delete
			$(document).on("click","#tab-add-topics .delete-btn",function(event) {
				//$(this).parent().remove();
				$(this).parent().fadeOut(500, function(){ $(this).remove();});
				$("#tab-add-topics .msg-div").text("");
				event.preventDefault();
				//$(".course-topic-list-area ul li").remove()
			});


			//edit
			$(document).on("click","#tab-add-topics .edit-btn",function(event) {

				var parent_li_item  = $(this).parent();
				parent_li_item.addClass('edit');

				parent_li_item.children('p').hide();


				parent_li_item.children('input.edit')
					.removeClass("close")
					.val(parent_li_item.children('p').text())
					.focus();

				//$(this).hide();
				$(this).fadeOut(500, function(){ $(this).hide();});

				//parent_li_item.children('.ok-btn').show();
				parent_li_item.children('.ok-btn').fadeIn(500, function(){ $(this).show();});
				event.preventDefault();
			});



			//when enter key press submit edit
			$(document).on("keyup","#tab-add-topics input.edit:not(.close)",function(event){
				var parent_li_item  = $(this).parent();

				console.log(event.keyCode);

				if (event.keyCode === 13) {
					// Cancel the default action, if needed
					event.preventDefault();
					// Trigger the button element with a click
					parent_li_item.children('.ok-btn').click();
				}

			});



			// edit submit
			$(document).on("click","#tab-add-topics .ok-btn",function(event) {

				var parent_li_item  = $(this).parent();
				var text = parent_li_item.children('input.edit').val();

				if (text != ""){

					if(checkItemExsist(text,parent_li_item.children('p'))==true){
						parent_li_item.children('input.edit').focus();
						$("#tab-add-topics .msg-div").text("Can't update already exsist");
					}else{
						parent_li_item.children('p').text(parent_li_item.children('input.edit').val());
						parent_li_item.children('p').show();
						parent_li_item.children('input.edit').addClass("close");

						//$(this).hide();
						$(this).fadeOut(500, function(){ $(this).hide();});

						parent_li_item.children('.edit-btn').show();

						parent_li_item.removeClass('edit');
						$("#tab-add-topics .msg-div").text("");
					}
				}else{
					$("#tab-add-topics .msg-div").text("Can't be empty!");
				}
				event.preventDefault();
			});


			$( ".course-topic-list-area ul#course-topic-list" ).sortable({
				start: function( event, ui ) {
					$(ui.item).addClass("highlight");
				},
				stop:function( event, ui ) {
					$(ui.item).removeClass("highlight");
				}
			});
			$( "course-topic-list-area ul#course-topic-list" ).disableSelection();

			function checkItemExsist(inputText,excludeElement){
				console.log(inputText);
				var mvar = [];

				$("#tab-add-topics .course-topic-list-area ul#course-topic-list li p").not(excludeElement).each(function(i,el) {
					mvar.push($(this).html())
				});
				console.log(mvar.includes(inputText));
				return mvar.includes(inputText);
			}
		});




        // for course content
		$(document).ready(function() {

			// generate json from couse content
			$("#tab-add-course-content #json-btn").on("click", function(){
				var vc = [];
				$(".course-content-list-area ul#course-content-list li.edit").each(function(i,el){
					//console.log(el);
					vc.push(el);
				});

				if(vc.length == 0){
					mvar = {};
					$(".course-content-list-area ul#course-content-list li:not(.edit) .txt-div").each(function(i,el){

						var infoObj = {
							text  : $(el).find('.cc-link').html(),
							url   : $(el).find('.cc-link').attr('href'),
							param : $(el).find('.cc-param').html(),
							price : $(el).find('.cc-price').html(),
							type  : $(el).find('.cc-type').html(),
						};
						//console.log(el);
						//mvar.push(infoObj);
						mvar[i] = infoObj;
					});

					console.log(mvar);
					console.log(JSON.stringify(mvar));

					$('.course-content-json-result').html(JSON.stringify(mvar));
				}else{
					//$('.course-content-json-result').html(JSON.stringify(mvar));
					alert('finish edit before submit');
				}
			});





			//add to course content to list
			$("#add-course-content").on("click", function() {

				var inp_ele = $("input.add-c-content").val(),

					close_i     = '<a href="" class="delete-btn"><i class="fa fa-times"></i></a>',
					edit_i      = '<a href="" class="edit-btn"><i class="fa fa-pencil"></i></a>',
					//edit_inp    = '<input type="text" class="edit close">';
					ok_i        = '<a href="" class="ok-btn"><i class="fa edit fa-check"></i></a>';


				form =          `<div class="course-content-div __mt-2 close w-11/12">
                                <form class="course-content-form p-0">

                                    <div class="form-group  row">
                                        <div class="col-sm-12 mb-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">Text</span>
                                                </div>
                                                <input type="text" name="content-text" class="form-control"><br>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon">Url</span>
                                                </div>
                                                <input type="text" name="content-url" class="form-control"><br>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon"><b>Duration/Size</b></span>
                                                </div>
                                                <input id="link_param" name="link_param" type="text" class="form-control"><br>
                                            </div>
                                        </div>


                                        <div class="offset-sm-4 col-sm-2">
                                            <div class="float-right i-checks">
                                                <label class="mb-0"> <input type="checkbox" value="" name="is_free"> <i></i> <b>Free</b> </label>
                                            </div>
                                        </div>


                                        <div class="col-sm-3 -ml-1">
                                            <div class="float-right i-checks">
                                                <label class="mb-0"> <input type="checkbox" value="" name="is_download"> <i></i> <b>Download link</b> </label>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>`;

				//ok_i = '<input type="button" value="ok" class="ok ok-btn">';

				var inputText   = $('#tab-add-course-content  input[name="content-text"]').val();
				var inputUrl    = $('#tab-add-course-content  input[name="content-url"]').val();
				var linkParam   = $('#tab-add-course-content  input[name="link_param"]').val();
				var isFree      = $('#tab-add-course-content  input[name="is_free"]').is(":checked");
				var isDownload  = $('#tab-add-course-content  input[name="is_download"]').is(":checked");




				if (inputText == ""){
					$("#tab-add-course-content .msg-div").text("content text cant be empty!");
				}else if(inputUrl == "") {
					$("#tab-add-course-content .msg-div").text("content url cant be empty!");
				}else{


					var freeVal   = (isFree==true)?'Free':'Paid';
					var c_type    = (isDownload==true)?'Download':'Video';

					$(".course-content-list-area ul#course-content-list").append(
						"<li>" +
						'<div class="txt-div" style="font-size:14px;font-weight: bold;">' +
						'<a class="cc-link" href="' + inputUrl + '">' + inputText + '</a> ➜ ' +
						'&nbsp;&nbsp; [Duration/Size - <span class="cc-param">' + linkParam + '</span>]' +
						'&nbsp;&nbsp; [<span class="cc-price">' + freeVal + '</span>]' +
						'&nbsp;&nbsp; [Type - <span class="cc-type">' + c_type + '</span>]' +
						'</div>' +
						close_i + edit_i + ok_i +  form +

						"</li>");


					$('.course-content-list-area ul#course-content-list li:last-of-type .i-checks').iCheck({
						checkboxClass: 'icheckbox_square-green',
						radioClass: 'iradio_square-green',
					});

					$("#tab-add-course-content .msg-div").text("");



					/* todo
                    if(check_content_exsist(inp_ele,null) == true){
                        $("#tab-add-course-content .msg-div").text("Can't be duplicate!");
                    }else{
                        $(".course-content-list-area ul#course-content-list").append("<li>" +
                            "<p>" + inp_ele + "</p>" +
                            close_i + edit_i + ok_i +  form +
                            "</li>");

                        $("#tab-add-course-content .msg-div").text("");
                    }
                    */
				}

				$('#tab-add-course-content form.add.course-content-form input[name="content-text"]').val('');
				$('#tab-add-course-content form.add.course-content-form input[name="content-url"]').val('');
				$('#tab-add-course-content form.add.course-content-form input[name="link_param"]').val('');
				//$('#tab-add-course-content form.add.course-content-form input[name="is_free"]').prop('checked', false);
				//$('#tab-add-course-content form.add.course-content-form input[name="is_download"]').prop('checked', false);

				//$('#tab-add-course-content form.add.course-content-form input[name="is_free"]').iCheck('uncheck');
				//$('#tab-add-course-content form.add.course-content-form input[name="is_download"]').iCheck('uncheck');

			});


			//delete course content
			$(document).on("click","#tab-add-course-content .delete-btn",function(event) {
				//$(this).parent().remove();
				$(this).parent().fadeOut(500, function(){ $(this).remove();});
				$("#tab-add-course-content .msg-div").text("");
				event.preventDefault();
			});


			//edit course content
			$(document).on("click","#tab-add-course-content .edit-btn",function(event) {

				var parent_li_item  = $(this).parent();

				parent_li_item.addClass('edit');

				parent_li_item.children('.txt-div').hide();
				//parent_li_item.children('.txt-div').fadeOut(500, function(){ $(this).hide();});

				var inputText   = parent_li_item.children('.txt-div').children('.cc-link').html();
				var inputUrl    = parent_li_item.children('.txt-div').children('.cc-link').attr('href');
				var linkParam   = parent_li_item.children('.txt-div').children('.cc-param').html();
				var isFree      = (parent_li_item.children('.txt-div').children('.cc-price').html()=='Free')?'check':'uncheck';
				var isDownload  = (parent_li_item.children('.txt-div').children('.cc-type').html()=='Video')?'uncheck':'check';

				parent_li_item.find('input[name="content-text"]').val(inputText);
				parent_li_item.find('input[name="content-url"]').val(inputUrl)
				parent_li_item.find('input[name="link_param"]').val(linkParam);
				parent_li_item.find('input[name="is_free"]').iCheck(isFree);
				parent_li_item.find('input[name="is_download"]').iCheck(isDownload);


				parent_li_item.children('.course-content-div').removeClass("close");
				parent_li_item.find('input[name="content-text"]').focus();

				//$(this).hide();
				$(this).fadeOut(300, function(){ $(this).hide();});

				parent_li_item.children('.ok-btn').show();
				event.preventDefault();
			});




			// edit submit
			$(document).on("click","#tab-add-course-content .ok-btn",function(event) {

				var parent_li_item  = $(this).parent();

				var inputText   = parent_li_item.find('input[name="content-text"]').val();
				var inputUrl    = parent_li_item.find('input[name="content-url"]').val();
				var linkParam   = parent_li_item.find('input[name="link_param"]').val();
				var isFree      = (parent_li_item.find('input[name="is_free"]').is(":checked")==true)?'Free':'Paid';
				var isDownload  = (parent_li_item.find('input[name="is_download"]').is(":checked")==true)?'Download':'Video';


				if (inputText == ""){

					$("#tab-add-course-content .msg-div").text("content text cant be empty!");

				}else if(inputUrl == "") {

					$("#tab-add-course-content .msg-div").text("content url cant be empty!");

				}else{

					parent_li_item.find('.cc-link').html(inputText);
					parent_li_item.find('.cc-link').attr("href", inputUrl);
					parent_li_item.find('.cc-param').html(linkParam);
					parent_li_item.find('.cc-price').html(isFree);
					parent_li_item.find('.cc-type').html(isDownload);



					parent_li_item.children('.txt-div').show();

					parent_li_item.find('.course-content-div').addClass("close");

					//$(this).hide();
					$(this).fadeOut(300, function(){ $(this).hide();});

					//parent_li_item.children('.edit-btn').show();
					parent_li_item.children('.edit-btn').fadeIn(500, function(){ $(this).show();});



					parent_li_item.removeClass('edit');
					$("#tab-add-course-content .msg-div").text("");

					/*  todo
                    if(check_content_exsist(text,parent_li_item.children('p'))==true){
                        parent_li_item.children('input.edit').focus();
                        $("#tab-add-course-content .msg-div").text("Can't update already exsist");
                    }else{
                        parent_li_item.children('p').text(parent_li_item.children('input.edit').val());
                        parent_li_item.children('p').show();
                        parent_li_item.children('input.edit').addClass("close");
                        $(this).hide();
                        parent_li_item.children('.edit-btn').show();
                        parent_li_item.removeClass('edit');
                        $("#tab-add-course-content .msg-div").text("");
                    }
                    */

				}

				event.preventDefault();
			});



			$( ".course-content-list-area ul#course-content-list" ).sortable({
				start: function( event, ui ) {
					$(ui.item).addClass("highlight");
				},
				stop:function( event, ui ) {
					$(ui.item).removeClass("highlight");
				}
			});
			$( ".course-content-list-area ul#course-content-list" ).disableSelection();





			//todo
			function check_content_exsist(inputText,excludeElement){

				console.log(inputText);
				var mvar = [];

				$(".course-content-list-area ul#course-content-list li p").not(excludeElement).each(function(i,el) {
					mvar.push($(this).html())
				});

				console.log(mvar.includes(inputText));
				return mvar.includes(inputText);
			}

		});





    </script>
@stop
