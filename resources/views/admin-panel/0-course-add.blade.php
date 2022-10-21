@extends('admin-panel.layouts.master')
@section('title','Add course')


@section('css-files')
<!-- select2 -->
<link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<link rel="stylesheet" href="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.css')}}">
<!-- <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">-->

<link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
{{--<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/green.css">--}}


<link rel='stylesheet' href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'>
<link rel='stylesheet' href='https://unpkg.com/filepond/dist/filepond.min.css'>

<!-- jQuery Steps -->
<link rel='stylesheet' href='{{asset('admin/css/plugins/steps/jquery.steps.css')}}'>





@stop



@section('page-css')
<style>
    form.wizard > .content > .body{
        width: 100%;
        padding: 0px;
    }

    form.wizard > .content {
        background: #fff;
    }

    form.wizard > .content > .body ul > li.filepond--item {
        list-style: none !important;
    }

    form.wizard > .content > .body input:focus {
        border: 1px solid #1ab394;
    }

    #course-topic-list,
    #course-content-list{
        list-style: none !important;
    }


</style>

@stop







@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            <div class="ibox">
                <div class="ibox-content">


                    <form id="course-form" action="#" class="wizard-big wizard clearfix">

                        <h1>Details</h1>
                        <fieldset>
                            <h2>Add course details</h2>
                            <div class="row">
                                <div class="col-lg-12">


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
                                            <input type="file" id="course-img" name="course-img">
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
                                            <span class="form-text m-b-none">Leave blank or fill 0 if course is free.</span>

                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Submit status</label>

                                        <div class="col-sm-8">

                                            <div class="">
                                                <label> <input type="radio" class="iCheck" value="draft" name="course_stat"> <i></i>Draft </label>
                                            </div>
                                            <div class="">
                                                <label> <input type="radio" class="iCheck" checked="" value="published" name="course_stat"> <i></i>Published </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>


                                    {{--
                                    <div class="form-group row">
                                        <div class="col-sm-4 offset-sm-4">
                                            <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                            <button class="btn btn-danger btn-sm" type="reset">Cancel</button>
                                        </div>
                                    </div>
                                    --}}
                                </div>
                            </div>
                        </fieldset>


                        <h1>Topics</h1>
                        <fieldset>
                            <h2>Add couse topics</h2>
                            <div class="row">
                                <div class="col-lg-12" id="tab-add-topics">

                                    {{--
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
                                    --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <input type="text" class="input add-topics form-control" placeholder="Add topics">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-12 align-middle">
                                            <input type="button" id="add-topics-btn" class="float-right btn btn-primary btn-sm" value="Add">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <div class="msg-div text-base text-red font-semibold"></div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="course-topic-list-area col-sm-12">
                                            <ul id="course-topic-list"></ul>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-8">
                                            <div class="course-topics-json-result"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="button" class="float-right btn btn-primary btn-sm" id="json-btn" value="json">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>


                        <h1>content</h1>
                        <fieldset>
                            <h2>Add couse content</h2>
                            <div class="row">
                                <div class="col-lg-12" id="tab-add-course-content">


                                    <div class="_px-3 row mb-3">
                                        <div class="col-sm-12 select-topics-wrapper">
                                            <label class="col-form-label">Select topic</label>
                                            <select class="form-control" id="course-topics">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <label class="col-form-label">Content</label>
                                            <div class="course-content-form add px-1 py-1">
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
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-12 align-middle">
                                            <input type="button" id="add-course-content" class="float-right btn btn-primary btn-sm" value="Add">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <div class="msg-div text-base text-red font-semibold"></div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="course-content-list-area col-sm-12">
                                            <ul id="course-content-list"></ul>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-8">
                                            <div class="course-content-json-result"></div>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="button" class="float-right btn btn-primary btn-sm" id="json-btn" value="json">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>

                        <h1>Finish</h1>
                        <fieldset>
                            <h2>Terms and Conditions</h2>
                            <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                        </fieldset>

                    </form>

                </div>
            </div>

        </div>
    </div>
@stop




@section('script-files')



    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>


    <!-- SUMMERNOTE -->
    <!-- <script src="../assets/summernote-0.8.18/summernote-lite.js"></script> -->
    <script src="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.js')}}"></script>

    <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src='https://unpkg.com/filepond/dist/filepond.min.js'></script>


    <!-- jQuery Steps -->
    <script src="{{asset('admin/js/plugins/steps/jquery.steps.min.js')}}"></script>

    <!-- jQuery validate -->
    <script src="{{asset('admin/js/plugins/validate/jquery.validate.min.js')}}"></script>

    <!-- iCheck
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>-->

    <script src="//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

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
		})();





		$(document).ready(function(){

			$("#course-form").steps({
				bodyTag: "fieldset",
				transitionEffect: "fade",
				transitionEffectSpeed:500,
				//titleTemplate: '<span class="step">#index#</span> #title#',
				labels: {
					finish: "Submit",
                    //next : '>>'
				},
				onInit:function (event, currentIndex, newIndex){

					// Select the file input and use create() to turn it into a pond
					const pond = FilePond.create(document.getElementById('course-img'));

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

					$('#course-topics').select2({
						placeholder: "Select a topic",
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

					$('input').iCheck({
						checkboxClass: 'icheckbox_square-green',
						radioClass: 'iradio_square-green',
					});

					courseTopicFunctionality();
					courseContentFunctionality();
                },
				onStepChanging: function (event, currentIndex, newIndex)
				{
                    console.log(currentIndex);
					console.log(newIndex);
					var topicsField = $("input[name=topicsJson]");

					if(currentIndex === 1){

						if(isTopicEditFinished() === true){

                        	var topicsJson  = generateTopicsJson();

                            if(topicsField.length === 0){
								$("<input>").attr({
									name: "topicsJson",
									id: "topicsJson",
									type: "hidden",
									value: topicsJson
								}).appendTo("#course-form");
                            }else{
								topicsField.val(topicsJson);

								//todo -topic delete in 2nd tab thgen it's content delete in 3rd tab
								// delete content in next tab if you have no topic
								if(jQuery.isEmptyObject(JSON.parse(topicsField.val()))){
									$('#tab-add-course-content #course-content-list').html('');
									//alert('content automatically remove because you have no topics');
								}
                            }














							return true;

                        }else{
                        	alert('finish topic editing before go to next tab')
							return false;
                        }
                    }

					if(currentIndex === 2){

                    }

					return true;





				},
				onStepChanged: function (event, currentIndex, priorIndex)
				{
					console.log(currentIndex);
					console.log(priorIndex);

					if(currentIndex ==2){
						generateTopicsDropdown()
                    }


				},
			});







			$(document.body).on("change","#course-topics",function(){

				alert(this.value);

				//form topi key load content


				//load topic content
				var c_contentTab = $("#tab-add-course-content");
				//c_contentTab.find(".course-content-list-area ul#course-content-list").append();



			});





		});




		function generateTopicsDropdown(){
			var $dropDown = $('#course-topics');
			$dropDown.html('');
			var topicItems  = '';
			var $topicsField = $("input[name=topicsJson]");

			topicsFieldValue = $topicsField.val() || {};
			var objTopics = JSON.parse(topicsFieldValue);
            var uid;
			Object.keys(objTopics).forEach((key, index) => {
				console.log(`${key}: ${objTopics[key]}`);
				uid = Math.random().toString(16).slice(2);
				topicItems += '<option data-uid="' + uid + '" data-key="' + key + '" value="' + objTopics[key] +'">'+ objTopics[key] +'</option>'
			});

			$dropDown.append(topicItems);
			console.log($topicsField.val());
		}




		function isTopicEditFinished(){
			var thisTab = $("#tab-add-topics");
			var vc = [];
			thisTab.find(".course-topic-list-area ul#course-topic-list li input.edit:not(.close)").each(function(i,el){
				//console.log(el);
				vc.push(el);
			});
			console.log(vc);
			return (vc.length === 0);
		}


		function generateTopicsJson(){
			var thisTab = $("#tab-add-topics");
			var mvar = {};
			thisTab.find(".course-topic-list-area ul#course-topic-list li p").each(function(i,el) {
				mvar[i] = $(this).html();
				//mvar.push($(this).html())
			});
			console.log(mvar);
			console.log(JSON.stringify(mvar));
			return JSON.stringify(mvar,undefined,2);
		}





        //for course topics
		//$(document).ready(function() {
        function courseTopicFunctionality(){

			// generate json
			$("#tab-add-topics #json-btn").on("click", function(){
				var thisTab = $("#tab-add-topics");
				if(isTopicEditFinished()){
                    var jsonString = generateTopicsJson();
					thisTab.find('.course-topics-json-result').html('<pre>' + jsonString + '</pre>');
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
					$('#tab-add-topics').find("#add-topics-btn").click();
				}
			});



            //when enter key press submit edit
			$("#tab-add-topics ul#course-topic-list").on("keyup", 'input.edit:not(.close)' ,function(event){
                //$(document).on("keyup","ul#course-topic-list li input.edit:not(.close)",function(event){

                var parent_li_item  = $(this).parent();
                //$(this).addClass("w3w3w3")
                console.log(event.keyCode);

                if (event.keyCode === 13) {
                    // Cancel the default action, if needed
                    event.preventDefault();
                    // Trigger the button element with a click
                    parent_li_item.children('.ok-btn').click();
                }
            });


			//add to list
			$("#tab-add-topics #add-topics-btn").on("click", function() {
				var thisTab = $("#tab-add-topics");
				var inp_ele = thisTab.find("input.add-topics").val(),

					close_i     = '<a href="" class="delete-btn"><i class="fa fa-times" aria-hidden="true"></i></a>',
					edit_i      = '<a href="" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>',
					edit_inp    = '<input type="text" class="edit close">';
				    ok_i        = '<a href="" class="ok-btn"><i class="fa edit fa-check" aria-hidden="true"></i></a>';
				//ok_i = '<input type="button" value="ok" class="ok ok-btn">';

				if (inp_ele != "") {

					if(checkItemExsist(inp_ele,null) == true){
						thisTab.find(".msg-div").text("Can't be duplicate!");
					}else{
						thisTab.find(".course-topic-list-area ul#course-topic-list").append("<li>" +
							"<p>" + inp_ele + "</p>" +
							close_i + edit_i + ok_i +  edit_inp +
							"</li>");

						thisTab.find(".msg-div").text("");
					}
				} else {
					thisTab.find(".msg-div").text("Can't be empty!");
				}
				thisTab.find("input.add-topics").val("");
			});


			//delete
			$(document).on("click","#tab-add-topics .delete-btn",function(event) {
				//$(this).parent().remove();
				var thisTab = $("#tab-add-topics");
				$(this).parent().fadeOut(500, function(){ $(this).remove();});
				thisTab.find(".msg-div").text("");
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


			// edit submit
			$(document).on("click","#tab-add-topics .ok-btn",function(event) {

				var parent_li_item  = $(this).parent();
				var text = parent_li_item.children('input.edit').val();
				var thisTab = $("#tab-add-topics");
				if (text != ""){

					if(checkItemExsist(text,parent_li_item.children('p'))==true){
						parent_li_item.children('input.edit').focus();
						thisTab.find(".msg-div").text("Can't update already exsist");
					}else{
						parent_li_item.children('p').text(parent_li_item.children('input.edit').val());
						parent_li_item.children('p').show();
						parent_li_item.children('input.edit').addClass("close");

						//$(this).hide();
						$(this).fadeOut(500, function(){ $(this).hide();});

						parent_li_item.children('.edit-btn').show();

						parent_li_item.removeClass('edit');
						thisTab.find(".msg-div").text("");
					}
				}else{
					thisTab.find(".msg-div").text("Can't be empty!");
				}
				event.preventDefault();
			});



			$( "#tab-add-topics .course-topic-list-area ul#course-topic-list" ).sortable({
				start: function( event, ui ) {
					$(ui.item).addClass("highlight");
				},
				stop:function( event, ui ) {
					$(ui.item).removeClass("highlight");
				}
			});
			$( "#tab-add-topics course-topic-list-area ul#course-topic-list" ).disableSelection();

			function checkItemExsist(inputText,excludeElement){
				console.log(inputText);
				var mvar = [];
				var thisTab = $("#tab-add-topics");
				thisTab.find(".course-topic-list-area ul#course-topic-list li p").not(excludeElement).each(function(i,el) {
					mvar.push($(this).html())
				});
				console.log(mvar.includes(inputText));
				return mvar.includes(inputText);
			}
		}




        // for course content
		//$(document).ready(function() {
		function courseContentFunctionality(){

			// generate json from couse content
			$("#tab-add-course-content #json-btn").on("click", function(){

				var thisTab = $("#tab-add-course-content");

				if(isContentEditFinished()){
					var jsonString = generateContentJson();
					thisTab.find('.course-content-json-result').html('<pre>'+jsonString+'</pre>');
				}else{
					//$('.course-content-json-result').html(JSON.stringify(mvar));
					alert('finish edit before submit');
				}
			});


			function isContentEditFinished(){
				var thisTab = $("#tab-add-topics");
				var vc = [];
				thisTab.find(".course-content-list-area ul#course-content-list li.edit").each(function(i,el){
					//console.log(el);
					vc.push(el);
				});
				return (vc.length === 0);
			}



            //content json field iterate
            // get topics from drop down
            //search topic=key and load select key value content



            //todo -when edit topics


			function generateContentJson(){

				var thisTab = $("#tab-add-course-content");
				var topicKey= $("#course-topics").val();


				//get all topics

				//input field(whole content json is there) get value - if not have {}
				//iterate through keys

                //check current topic is in the key
                //if yes replace with new json

                //if keys include other than topics name then remove those



				var mvar;
				if(topicKey){
					var arr = [];
					mvar={};
					thisTab.find(".course-content-list-area ul#course-content-list li:not(.edit) .txt-div").each(function(i,el){
						var infoObj = {
							text  : $(el).find('.cc-link').html(),
							url   : $(el).find('.cc-link').attr('href'),
							param : $(el).find('.cc-param').html(),
							price : $(el).find('.cc-price').html(),
							type  : $(el).find('.cc-type').html(),
						};
						//console.log(el);
						//mvar.push(infoObj);


						arr.push(infoObj);
					});

					mvar[topicKey] = arr;
                }else{
					mvar = {};
                }


				console.log(mvar);
				console.log(JSON.stringify(mvar));

				var tt1 = JSON.stringify(mvar,undefined,2);

				return tt1;
			}


			//add to course content to list
			$("#tab-add-course-content #add-course-content").on("click", function() {

				topicsJson = $("input[name=topicsJson]").val();


				if(jQuery.isEmptyObject(JSON.parse(topicsJson))){
					alert('before add content add topics');
					return false;
				}

				var thisTab = $("#tab-add-course-content");
				var inp_ele = thisTab.find("input.add-c-content").val(),

					close_i     = '<a href="" class="delete-btn"><i class="fa fa-times" aria-hidden="true"></i></a>',
					edit_i      = '<a href="" class="edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>',
					//edit_inp    = '<input type="text" class="edit close">';
					ok_i        = '<a href="" class="ok-btn"><i class="fa edit fa-check" aria-hidden="true"></i></a>';


				form =      `<div class="course-content-div __mt-2 close w-11/12">
                                <div class="course-content-form p-0">

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
                                </div>
                            </div>`;

				//ok_i = '<input type="button" value="ok" class="ok ok-btn">';

				var inputText   = thisTab.find('input[name="content-text"]').val();
				var inputUrl    = thisTab.find('input[name="content-url"]').val();
				var linkParam   = thisTab.find('input[name="link_param"]').val();
				var isFree      = thisTab.find('input[name="is_free"]').is(":checked");
				var isDownload  = thisTab.find('input[name="is_download"]').is(":checked");




				if (inputText == ""){
					thisTab.find('.msg-div').text("content text cant be empty!");
				}else if(inputUrl == "") {
					thisTab.find('.msg-div').text("content url cant be empty!");
				}else{


					var freeVal   = (isFree==true)?'Free':'Paid';
					var c_type    = (isDownload==true)?'Download':'Video';

					thisTab.find(".course-content-list-area ul#course-content-list").append(
						"<li>" +
						    '<div class="txt-div" style="font-size:14px;font-weight: bold;">' +
						        '<a class="cc-link" href="' + inputUrl + '">' + inputText + '</a> ➜ ' +
						        '&nbsp;&nbsp; [Duration/Size - <span class="cc-param">' + linkParam + '</span>]' +
						        '&nbsp;&nbsp; [<span class="cc-price">' + freeVal + '</span>]' +
						        '&nbsp;&nbsp; [Type - <span class="cc-type">' + c_type + '</span>]' +
						    '</div>' +
						    close_i + edit_i + ok_i +  form +
						"</li>");


					thisTab.find('.course-content-list-area ul#course-content-list li:last-of-type .i-checks').iCheck({
						checkboxClass: 'icheckbox_square-green',
						radioClass: 'iradio_square-green',
					});


					thisTab.find(".msg-div").text("");

					generateContentJsonField(generateContentJson());









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

				thisTab.find('.add.course-content-form input[name="content-text"]').val('');
				thisTab.find('.add.course-content-form input[name="content-url"]').val('');
				thisTab.find('.add.course-content-form input[name="link_param"]').val('');
				//thisTab.find('.add.course-content-form input[name="is_free"]').prop('checked', false);
				//thisTab.find('.add.course-content-form input[name="is_download"]').prop('checked', false);

				thisTab.find('.add.course-content-form input[name="is_free"]').iCheck('uncheck');
				thisTab.find('.add.course-content-form input[name="is_download"]').iCheck('uncheck');

			});


			function generateContentJsonField(jsonVal){
				var contentField = $("input[name=contentJson]");
				//var



				if(contentField.length === 0){
					$("<input>").attr({
						name: "contentJson",
						id: "contentJson",
						type: "hidden",
						value: jsonVal
					}).appendTo("#course-form");
				}else{
					contentField.val(jsonVal);
				}
            }



			//delete course content
			$(document).on("click","#tab-add-course-content .delete-btn",function(event) {
				//$(this).parent().remove();
				var thisTab = $("#tab-add-course-content");
				$(this).parent().fadeOut(500, function(){ $(this).remove();});
				thisTab.find(".msg-div").text("");
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
				var thisTab = $("#tab-add-course-content");
				var parent_li_item  = $(this).parent();

				var inputText   = parent_li_item.find('input[name="content-text"]').val();
				var inputUrl    = parent_li_item.find('input[name="content-url"]').val();
				var linkParam   = parent_li_item.find('input[name="link_param"]').val();
				var isFree      = (parent_li_item.find('input[name="is_free"]').is(":checked")==true)?'Free':'Paid';
				var isDownload  = (parent_li_item.find('input[name="is_download"]').is(":checked")==true)?'Download':'Video';


				if (inputText == ""){

					thisTab.find(".msg-div").text("content text cant be empty!");

				}else if(inputUrl == "") {

					thisTab.find(".msg-div").text("content url cant be empty!");

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
					thisTab.find(".msg-div").text("");

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



			$( "#tab-add-course-content .course-content-list-area ul#course-content-list" ).sortable({
				start: function( event, ui ) {
					$(ui.item).addClass("highlight");
				},
				stop:function( event, ui ) {
					$(ui.item).removeClass("highlight");
				}
			});
			$( "#tab-add-course-content .course-content-list-area ul#course-content-list" ).disableSelection();





			//todo
			function check_content_exsist(inputText,excludeElement){

				console.log(inputText);
				var mvar = [];

				$("#tab-add-course-content .course-content-list-area ul#course-content-list li p").not(excludeElement).each(function(i,el) {
					mvar.push($(this).html())
				});

				console.log(mvar.includes(inputText));
				return mvar.includes(inputText);
			}

		}





    </script>
@stop
