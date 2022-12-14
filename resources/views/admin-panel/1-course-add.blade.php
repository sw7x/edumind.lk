@extends('admin-panel.layouts.master')
@section('title','Add course')


@section('css-files')
<!-- select2 -->
<link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<link rel="stylesheet" href="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.css')}}">
<!-- <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">-->

<link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
{{--<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/green.css">--}}


<link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond-plugin-image-preview.min.css')}}">
<link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond.min.css')}}">

<!-- jQuery Steps -->
<link rel='stylesheet' href="{{asset('admin/css/plugins/steps/jquery.steps.css')}}">


<!-- sweetalert2 CSS file-->
<link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">

<!-- toastr CSS file-->
<link rel="stylesheet" href="{{asset('admin/css/plugins/toastr/toastr.min.css')}}">

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
                            <h2>A11111dd course details</h2>
                            <div class="row">
                                <div class="col-lg-12">


                                    <div class="form-group  row">
                                        <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="course-name" class="form-control">
                                            <div class="error-msg"></div> 
                                        </div>
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
                                                <textarea class="form-control" name="course-heading"
                                                          cols="30" rows="7" placeholder="" autocomplete="off"></textarea>                                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group row"><label class="col-sm-4 col-form-label">Description</label>
                                        <div class="col-sm-8">
                                            <div class="border-edu">
                                                <textarea rows="3" class="form-control" name="course-description"></textarea>
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
                            <h2>Add topics</h2>

                            <div class="row">
                                <div class="col-lg-12" id="tab-add-topics">

                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <input type="text" class="input add-topics form-control" placeholder="Enter here topic name:">
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


                        <h1>links</h1>
                        <fieldset>
                            
                            <div class="row">
                                <div class="col-lg-12" id="tab-add-course-content">


                                    <div class="_px-3 row mb-5">
                                        <div class="col-sm-12 select-topics-wrapper">
                                            <h2>1.Select a Topic</h2>
                                            <select class="form-control" id="course-topics">
                                                 <option></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <h2>2.Add links</h2>
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

                        <!-- <h1>Finish</h1>
                        <fieldset>
                            <h2>Terms and Conditions</h2>
                            <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                        </fieldset> -->



                        <input name="topicsJson" id="topicsJson" type="hidden" value='{"0":"aa","1":"bb","2":"cc","3":"dd","4":"xyz"}'>
                        <input name="contentJson" id="contentJson" type="hidden" value='{
                           "aa":[
                              {
                                 "inputText":"aa1",
                                 "inputUrl":"aa12",
                                 "linkParam":"aa13",
                                 "isFree":false,
                                 "isDownload":false
                              },
                              {
                                 "inputText":"bb1",
                                 "inputUrl":"bb12",
                                 "linkParam":"bb13",
                                 "isFree":true,
                                 "isDownload":false
                              },
                              {
                                 "inputText":"cc3",
                                 "inputUrl":"cc32",
                                 "linkParam":"cc33",
                                 "isFree":false,
                                 "isDownload":true
                              },
                              {
                                 "inputText":"dd4",
                                 "inputUrl":"dd41",
                                 "linkParam":"dd42",
                                 "isFree":true,
                                 "isDownload":true
                              },
                              {
                                 "inputText":"ee5",
                                 "inputUrl":"ee51",
                                 "linkParam":"ee52",
                                 "isFree":true,
                                 "isDownload":true
                              }
                           ],
                           "bb":[
                              {
                                 "inputText":"zz",
                                 "inputUrl":"zzq",
                                 "linkParam":"zzq",
                                 "isFree":false,
                                 "isDownload":false
                              },
                              {
                                 "inputText":"xx",
                                 "inputUrl":"xx1",
                                 "linkParam":"xx2",
                                 "isFree":false,
                                 "isDownload":true
                              },
                              {
                                 "inputText":"cc",
                                 "inputUrl":"cc2",
                                 "linkParam":"cc3",
                                 "isFree":true,
                                 "isDownload":false
                              },
                              {
                                 "inputText":"vv",
                                 "inputUrl":"vvf",
                                 "linkParam":"vvr",
                                 "isFree":true,
                                 "isDownload":true
                              }
                           ],
                           "cc":[
                              {
                                 "inputText":"gg",
                                 "inputUrl":"gg1",
                                 "linkParam":"gg2",
                                 "isFree":true,
                                 "isDownload":false
                              },
                              {
                                 "inputText":"hh1",
                                 "inputUrl":"hh2",
                                 "linkParam":"hh3",
                                 "isFree":true,
                                 "isDownload":true
                              },
                              {
                                 "inputText":"jj1",
                                 "inputUrl":"jj2",
                                 "linkParam":"jj3",
                                 "isFree":false,
                                 "isDownload":true
                              },
                              {
                                 "inputText":"kk1",
                                 "inputUrl":"kk2",
                                 "linkParam":"kk3",
                                 "isFree":true,
                                 "isDownload":true
                              },
                              {
                                 "inputText":"ll1",
                                 "inputUrl":"ll2",
                                 "linkParam":"ll3",
                                 "isFree":true,
                                 "isDownload":false
                              }
                           ],
                           "dd":[
                              {
                                 "inputText":"susa1",
                                 "inputUrl":"su",
                                 "linkParam":"sae",
                                 "isFree":true,
                                 "isDownload":true
                              }
                           ]
                        }'>
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

    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-encode.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-size.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-exif-orientation.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-preview.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-type.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond.min.js')}}"></script>


    <!-- jQuery Steps -->
    <script src="{{asset('admin/js/plugins/steps/jquery.steps.min.js')}}"></script>

    <!-- jQuery validate -->
    <script src="{{asset('admin/js/plugins/validate/jquery.validate.min.js')}}"></script>

    <!-- iCheck
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>-->

    <script src="//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>


    <!-- sweetalert2 js file-->
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- toastr js file-->
    <script src="{{asset('admin/js/plugins/toastr/toastr.min.js')}}"></script>
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

        var courseTopicFunctionality;
        var courseContentFunctionality;


		$(document).ready(function(){

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "2200",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };




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
						//allowClear: false,
						width: '100%',
                        placeholder: "Please select a topic",
                        allowClear: true
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

					//activate topicsModule,courseContentModule
                    courseTopicFunctionality   = topicsModule(window,jQuery);
                    courseContentFunctionality = courseContentModule(window,jQuery);
				
                },
				onStepChanging: function (event, currentIndex, newIndex)
				{
                    //console.log(currentIndex);
					//console.log(newIndex);


                    // step2  ==>  step3
                    // step2  ==>  step1
                    if(currentIndex === 1){
                        if(!courseTopicFunctionality.isTopicEditFinished()){
                            toastr['error'](`Finish topic editing before change step!`);
                            return;
                        }
                    }

                    // step3  ==>  step2
                    // step3  ==>  step4
                    if(currentIndex === 2){
                        if(!courseContentFunctionality.isContentEditFinished()){
                            toastr['error'](`Finish links editing before change step!`);
                            return;
                        }
                    }

					return true;
				},
				onStepChanged: function (event, currentIndex, priorIndex)
				{
					if(currentIndex ==2){
                        courseContentFunctionality.renderTopicsDropdown();
                        courseContentFunctionality.resetTopicsDropdown();
                        courseContentFunctionality.clearJsonPrev();
                    }
                },
                onFinishing: function (event, currentIndex){
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex){
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }

			}).validate({
                rules:{                    
                    "course-name": {required: true},
                },
                messages:{
                    "course-name": {required:"Course name is required"},    
                },
                submitHandler: function(form){

                },
                errorPlacement: function (error, element)
                {
                    //element.before(error);
                    //element.after(error);
                    error.appendTo(element.parent().find('.error-msg'));
                    element.parent().find('.error-msg').css('color','red');
                    element.parent().find('.error-msg').css('fontSize','12px');
                    error.css('margin','0px');
                },
            });

		});





        var topicsModule = (function(window,$){           

            let form;          
            let thisTab;
            let addBtn;      
            let topicListArea;
            let topicList;    
            let inp_ele;  
            let jsonBtn;       
            let jsonResultDiv;            
            let delTopicBtn;//
            let $topicsField;//

            
            const _init = () => {
                _cacheDom();
                _bindEvents();

                if($('input[name=topicsJson]').length){
                    _render();
                }
                
                _sorting();
            };

            
            const _cacheDom = () => {
                form          = $("#course-form");
                thisTab       = $("#tab-add-topics");
                addBtn        = thisTab.find("#add-topics-btn");
                inp_ele       = thisTab.find("input.add-topics");
                
                topicListArea = thisTab.find(".course-topic-list-area");
                topicList     = topicListArea.find("ul#course-topic-list");                                                           

                jsonBtn       = thisTab.find("#json-btn");
                jsonResultDiv = thisTab.find('.course-topics-json-result');
                delTopicBtn   = thisTab.find(".delete-btn");
                $topicsField  = $("input[name=topicsJson]");
            };

            const _bindEvents = () => {
                inp_ele.on("keyup",_addEnter);
                addBtn.on("click", _addTopic);
                jsonBtn.on("click", _showJson);
                
                $(document).on("click","#tab-add-topics .delete-btn",_deleteTopic);
                $(document).on("click","#tab-add-topics .edit-btn",_editTopic);
                $(document).on("click","#tab-add-topics .ok-btn",_editTopicSubmit);
                $(document).on("click","#tab-add-topics .undo-btn",_editCancel);

                topicList.on("keyup",'input.edit:not(.close)',_editEnter);                
            };

            const _sorting = () => {
                topicList.sortable({
                    start: function( event, ui ) {
                        $(ui.item).addClass("highlight");
                    },
                    stop:function( event, ui ) {
                        $(ui.item).removeClass("highlight");

                        //update input field after sorting
                        var topicsJson = generateTopicsJson();
                        _updateTopicsFieldVal(topicsJson);
                    }
                });
                topicList.disableSelection();
            };


            const _render = () => {

                var objTopics = getTopics();
                var _topicList = '';

                Object.keys(objTopics).forEach((key, index) => {
                    //console.log(`${key}: ${objTopics[key]}`);

                    var inp_ele_txt = objTopics[key];
                    var close_i     = '<a href="" class="delete-btn fa fa-trash" title="Delete"></a>';
                    var edit_i      = '<a href="" class="edit-btn fa fa-pencil" title="Edit"></a>';
                    var edit_inp    = '<input type="text" class="edit close">';
                    var undo_i      = '<a href="" class="undo-btn fa fa-undo" title="Cancel changes"></a>';
                    var ok_i        = '<a href="" class="ok-btn fa edit fa-check" title="Update changes"></a>';
                    
                    _topicList   +=  "<li>"+
                                        "<p>" + inp_ele_txt + "</p>" +
                                        close_i + edit_i + undo_i + ok_i + edit_inp +
                                    "</li>";
                });
                topicList.html('');
                topicList.append(_topicList);
                inp_ele.val("");
            };

            const _updateTopicsFieldVal = (topicsJson) => {
                topicsJson = JSON.stringify(topicsJson);                    
                if(form.find($("input[name=topicsJson]")).length === 0){

                    $("<input>").attr({
                        name: "topicsJson",
                        id: "topicsJson",
                        type: "hidden",
                        value: topicsJson
                    }).appendTo(form);

                }else{
                    form.find($("input[name=topicsJson]")).val(topicsJson);
                }
            };

            // input element click enter
            const _addEnter = (event) => {
                if (event.keyCode === 13) {
                    // Cancel the default action, if needed
                    event.preventDefault();
                    // Trigger the button element with a click
                    addBtn.click();
                }
            };
            
            const _addTopic = (event) => {

                if (inp_ele.val() == "") {
                    toastr['error']("Topic cannot be empty!");
                    return false;
                }

                if(checkItemExist(inp_ele.val(),null) == true){
                    toastr['error']("Topic already exists!");
                    return false;
                }

                if(!isTopicEditFinished()){
                    toastr['error']("Finish editing before add new one!");
                    return false;
                }

                var txt = inp_ele.val();
                var objTopics   = getTopics();
                var mvar = {};
                var _index = -1;
                Object.keys(objTopics).forEach((key, index) => {
                    //console.log(`${key}: ${objTopics[key]}`);
                    mvar[index] = objTopics[key];
                    _index = index;
                });
                _index++;
                mvar[_index] = txt;

                _updateTopicsFieldVal(mvar);
                _render();
            };

            const checkItemExist = (inputTxt,excludeElement) => {
                var mvar = [];                
                topicList.find("li p").not(excludeElement).each(function(i,el) {
                    mvar.push($(this).html())
                });                
                return mvar.includes(inputTxt);
            };

            const isTopicEditFinished = () => {
                return (topicsInEditState() === 0);
            };

            const topicsInEditState = () => {
                var vc = [];
                topicList.find("li input.edit:not(.close)").each(function(i,el){
                    vc.push(el);
                });
                return vc.length;
            };

            // watch html document and generate topics json
            const generateTopicsJson = () => {
                var mvar = {};
                topicList.find("li p").each(function(i,el) {
                    mvar[i] = $(this).html();
                });
                return mvar;
            };

            const _showJson = (event) => {
                if(isTopicEditFinished()){
                    jsonResultDiv.html('<pre>' + JSON.stringify(getTopics()) + '</pre>');
                }else{
                    toastr['error']('Finish editing before view json!');
                }
            };

            // 
            const getTopics = () => {
                var topicsFieldValue = form.find($("input[name=topicsJson]")).val() || {};
                var objTopics;
                try {
                    objTopics = JSON.parse(topicsFieldValue);
                }
                catch(e) {
                    objTopics = {};
                }
                return objTopics;
            };

            const _deleteTopic = async (event) => {

                event.preventDefault();
                event.stopPropagation();

                if(topicsInEditState() > 0){
                    toastr['error']('Finish Edit before delete.');
                    return false;
                }
               
                var objTopics       = getTopics();
                var delTopicTxt     = $(event.target).parent().find('p').html();
                var topicContents   = courseContentFunctionality.getContentByTopic(delTopicTxt);
                var arr;
                var stopDelete;

                arr = ($.isEmptyObject(topicContents))?[]:topicContents[delTopicTxt];

                // if topic has links(content) then user need to confirm deletion 
                if(arr.length > 0){
                    await Swal.fire({
                        title: 'Delete topic' ,
                        text:`There is already ${arr.length} links are associated with this topic`,
                        icon: 'warning',
                        allowOutsideClick: false,
                        //showCancelButton: true,
                        showConfirmButton: true,
                        confirmButtonText: 'Delete',
                        confirmButtonColor: '#e24545',
                        showDenyButton: true,
                        denyButtonText: `Don't delete`,
                        denyButtonColor: '#7d7d7d',
                        heightAuto: false,
                        didClose: () => {
                            return false;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            stopDelete = false;
                        }else if (result.isDenied) {
                            stopDelete = true;
                        }
                    });
                }else{
                    stopDelete = false;
                }

                if(!stopDelete){
                    var mvar = {};
                    var _index = 0;

                    Object.keys(objTopics).forEach((key, index) => {
                        //console.log(`${key}: ${objTopics[key]}`);
                        if(objTopics[key] != delTopicTxt){
                            mvar[_index] = objTopics[key];
                            _index++;
                        }
                    });

                    //console.log(mvar);
                    _updateTopicsFieldVal(mvar)
                    _render();

                    // delete links (content) of the topic
                    courseContentFunctionality.deleteContentByTopic(delTopicTxt);
                }
            };

            const _editEnter = (event) => {
                if (event.keyCode === 13) {
                    // Cancel the default action, if needed
                    event.preventDefault();
                    var parent_li_item  = $(event.target).parent();                        

                    // Trigger the button element with a click
                    parent_li_item.children('.ok-btn').click();
                }
            };

            const _editTopic = (event) => {
                event.preventDefault();
                if(topicsInEditState() > 0){
                    toastr['error']('Can\'t edit more than one topic at the same time.');
                    return false;
                }
                
                var parent_li_item  = $(event.target).parent();
                parent_li_item.addClass('edit');
                parent_li_item.children('p').hide();

                parent_li_item.children('input.edit')
                    .removeClass("close")
                    .val(parent_li_item.children('p').text())
                    .focus();

                $(event.target).fadeOut(500, function(){ $(this).hide();});

                parent_li_item.children('.ok-btn').fadeIn(500, function(){ $(this).show();});
                parent_li_item.children('.undo-btn').fadeIn(500, function(){ $(this).show();});
            };

            const _editTopicSubmit = (event) => {

                var parent_li_item;
                parent_li_item  = $(event.target).parent();

                var newText = parent_li_item.children('input.edit').val();
                var oldText = parent_li_item.children('p').html();

                if (newText != ""){
                    if(checkItemExist(newText,parent_li_item.children('p'))==true){
                        parent_li_item.children('input.edit').focus();
                        toastr['error'](`Can't update ${newText} already exsist`);
                    }else{
                        //change topic view from edit to normal 
                        parent_li_item.children('p').text(parent_li_item.children('input.edit').val());
                        parent_li_item.children('p').show();
                        parent_li_item.children('input.edit').addClass("close");
                        parent_li_item.children('.ok-btn').fadeOut(500, function(){ $(this).hide();});
                        parent_li_item.children('.undo-btn').fadeIn(500, function(){ $(this).hide();});
                        parent_li_item.children('.edit-btn').show();
                        parent_li_item.removeClass('edit');

                        var topicsJson = generateTopicsJson();
                        _updateTopicsFieldVal(topicsJson);                            

                        //update content json key(= topic)
                        courseContentFunctionality.renameContentJsonKey(oldText,newText);
                    }
                }else{
                    toastr['error'](`Topic cannot be empty!`);
                }
                event.preventDefault();
            };

            const _editCancel = (event) => {
                var parent_li_item;                    

                parent_li_item  = $(event.target).parent();
                parent_li_item.removeClass('edit');

                parent_li_item.children('p').show();
                parent_li_item.children('input.edit').addClass("close");

                parent_li_item.children('.edit-btn').fadeIn(500, function(){ $(this).show();});
                parent_li_item.children('.ok-btn').fadeIn(500, function(){ $(this).hide();});
                parent_li_item.children('.undo-btn').fadeIn(500, function(){ $(this).hide();});

                event.preventDefault();
            };           

            _init();

            return {
                generateTopicsJson,
                isTopicEditFinished,
                topicsInEditState,
                getTopics,
                checkItemExist
            }
        });



        



        // course links module
        const courseContentModule = (function (window, $) {

            let form;
            let thisTab;
            let addBtn;
            let contentListArea;
            let contentList;
            let jsonBtn;
            let jsonResultDiv;
            let inputText;
            let inputUrl;
            let linkParam;
            let isFree;
            let isDownload;
            let $topicsField;
            let $topicDropDown;            

            const _init = () => {
                _cacheDom();
                _bindEvents();

                if($('input[name=contentJson]').length){
                    _render();
                }

                _sorting();
            };


            const _cacheDom = () => {
                form                = $("#course-form");
                thisTab             = $("#tab-add-course-content");
                addBtn              = thisTab.find("#add-course-content");
                contentListArea     = thisTab.find(".course-content-list-area");
                contentList         = thisTab.find(".course-content-list-area ul#course-content-list");
                jsonBtn             = thisTab.find("#json-btn");
                jsonResultDiv       = thisTab.find('.course-content-json-result');
                inputText           = thisTab.find('input[name="content-text"]');
                inputUrl            = thisTab.find('input[name="content-url"]');
                linkParam           = thisTab.find('input[name="link_param"]');
                isFree              = thisTab.find('input[name="is_free"]');
                isDownload          = thisTab.find('input[name="is_download"]');                
                $topicDropDown      = $('#course-topics');                

                $topicsField        = form.find("input[name=topicsJson]");
                $el_topicsField     = $("input[name=topicsJson]");
                $contentField       = thisTab.find("input[name=contentJson]");
            };


            const _bindEvents = () => {
                addBtn.on("click", _addContent);
                jsonBtn.on("click",_showJson);
                $topicDropDown.on("change",_changeTopic);
                $(contentList).on("click","li a.delete-btn",_deleteContentItem);
                $(contentList).on("click","li a.edit-btn",_editContentItem);
                $(contentList).on("click","li a.ok-btn",_editContentItemSubmit);
                $(contentList).on("click","li a.undo-btn",_editContentItemCancel);
            };


            const _sorting = () => {
                contentList.sortable({
                    start: function( event, ui ) {
                        $(ui.item).addClass("highlight");
                    },
                    stop:function( event, ui ) {
                        $(ui.item).removeClass("highlight");

                        //cant sort if topic is not selected
                        if (!$topicDropDown.val()) {
                            toastr['error'](`Please select a topic before sort!`);
                            $(this).sortable("cancel");
                        }else{
                            _rearrangeContnetjsonfield();
                        }
                    },
                });
                contentList.disableSelection();
            };

            //update contentJson input field value according to html doc
            const _rearrangeContnetjsonfield = (excludeElement) => {
                var currentTopic = $topicDropDown.val();
                var contentJson = _getContents();
                var arr = [];

                contentList.find('li').not(excludeElement).each(function(index, li_item) {
                    var is_Free         = ($(li_item).find('.cc-price').html() == 'Paid')?false:true;
                    var is_Download     = ($(li_item).find('.cc-type').html() == 'Video')?false:true;
                    var infoObj = {
                        inputText   : $(li_item).find('.cc-link').html(),
                        inputUrl    : $(li_item).find('.cc-link').attr('href'),
                        linkParam   : $(li_item).find('.cc-param').html(),
                        isFree      : is_Free,
                        isDownload  : is_Download,
                    };
                    arr.push(infoObj);
                });
                contentJson[currentTopic] = arr;
                _updateContentFieldVal(contentJson);
            };


            const _render = (topic = null) => {
                var contentListHtml ='';
                var currentTopic = (topic)?topic:$topicDropDown.val();

                if(currentTopic == ''){
                    toastr['error'](`Please select a topic!`);
                }else{

                    var content      = getContentByTopic(currentTopic);

                    var close_i     = '<a href="" class="delete-btn fa fa-trash" title="Delete"></a>';
                    var edit_i      = '<a href="" class="edit-btn fa fa-pencil" title="Edit"></a>';
                    var undo_i      = '<a href="" class="undo-btn fa fa-undo" title="Cancel changes"></a>';
                    var ok_i        = '<a href="" class="ok-btn fa edit fa-check" title="Update changes"></a>';

                    var formHtml =  `<div class="course-content-div __mt-2 close w-11/12">
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
                    var freeVal;
                    var c_type;

                    if (typeof content[currentTopic] != 'undefined'){

                        content[currentTopic].forEach((element, index) => {
                            freeVal   = (element.isFree == true)?'Free':'Paid';
                            c_type    = (element.isDownload == true)?'Download':'Video';
                            contentListHtml +=  "<li>" +
                                                    '<div class="txt-div" style="font-size:14px;font-weight: bold;">' +
                                                        '<a class="cc-link" href="' + element.inputUrl + '">' + element.inputText + '</a> ??? ' +
                                                        '&nbsp;&nbsp; [Duration/Size - <span class="cc-param">' + element.linkParam + '</span>]' +
                                                        '&nbsp;&nbsp; [<span class="cc-price">' + freeVal + '</span>]' +
                                                        '&nbsp;&nbsp; [Type - <span class="cc-type">' + c_type + '</span>]' +
                                                    '</div>' +
                                                    close_i + edit_i + undo_i +ok_i +  formHtml +
                                                "</li>";
                        });
                    }
                }

                contentList.html('');
                contentList.append(contentListHtml);

                contentList.find('li').each(function( index, element ){
                    $(element).find('.i-checks').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });
                });

            };

            //when change topic, render links
            const _changeTopic = (event) => {
                var topic = $(event.target).val();
                _render(topic);
            };

            //get input values
            const _getInputObj = () => {                
                return {
                    inputText   : thisTab.find('input[name="content-text"]').val(),
                    inputUrl    : thisTab.find('input[name="content-url"]').val(),
                    linkParam   : thisTab.find('input[name="link_param"]').val(),
                    isFree      : thisTab.find('input[name="is_free"]').is(":checked"),
                    isDownload  : thisTab.find('input[name="is_download"]').is(":checked"),
                }
            };


            const _addContent = () => {

                if (inputText.val() == ""){
                    toastr['error'](`Content text cannot be empty!`);
                    return false;
                }

                if(inputUrl.val() == "") {
                    toastr['error'](`Content url cannott be empty!`);
                    return false;
                }

                //get selected topic value
                var currentTopic = $topicDropDown.val();
                if(currentTopic == "") {
                    toastr['error'](`Please select a topic before add content!`);
                    return false;
                }

                if(_contentItemCounInEditState() > 0){
                    toastr['error']('Finish Editing before Add new links!');
                    return false;
                }

                var contentJson = _getContents();
                var content = getContentByTopic(currentTopic);
                var inputobj = _getInputObj();
                var tempObj = [];

                if(!$.isEmptyObject(content)){
                    content[currentTopic].forEach(element => {
                        tempObj.push(element);
                    });
                }
                tempObj.push(inputobj);
                contentJson[currentTopic] = tempObj;

                _updateContentFieldVal(contentJson);
                _resetInputForm();
                _render();
            };


            const _resetInputForm = () => {
                inputText.val('');
                inputUrl.val('');
                linkParam.val('');
                isFree.iCheck('uncheck');
                isDownload.iCheck('uncheck');
            };


            const _updateContentFieldVal = (contentJson) => {
                contentJsonStr = JSON.stringify(contentJson);
                if(form.find($("input[name=contentJson]")).length === 0){
                    $("<input>").attr({
                        name: "contentJson",
                        id: "contentJson",
                        type: "hidden",
                        value: contentJsonStr
                    }).appendTo("#course-form");
                }else{
                    form.find($("input[name=contentJson]")).val(contentJsonStr);
                }
            };

            //excludeElement - string, jquery selector,null
            const check_content_exist = (inputTxt,excludeElement) => {
                var mvar = [];
                contentList.find('li').not(excludeElement).each(function(i,el) {
                    mvar.push($(this).find('.txt-div .cc-link').html());
                });
                return mvar.includes(inputTxt);
            };

            const _contentItemCounInEditState = () => {
                var vc = [];
                contentList.find("li.edit").each(function(i,el){
                    vc.push(el);
                });
                return vc.length;
            };

            const isContentEditFinished = () => {
                return (_contentItemCounInEditState() === 0);
            };


            const _getContents = () => {
                var contentFieldValue = form.find("input[name=contentJson]").val() || {};
                var objContent;
                try {
                    objContent = JSON.parse(contentFieldValue);
                }
                catch(e) {
                    objContent = {};
                }
                return objContent;
            };

            //render topics dropdown in content tab
            const renderTopicsDropdown = () => {

                var objTopics = courseTopicFunctionality.getTopics();
                $topicDropDown.html('');
                var topicItems  = '<option></option>';
                var uid; // add uuid if future needs

                Object.keys(objTopics).forEach((key, index) => {
                    //console.log(`${key}: ${objTopics[key]}`);
                    uid = Math.random().toString(16).slice(2);
                    topicItems += '<option data-uid="' + uid + '" data-key="' + key + '" value="' + objTopics[key] +'">'+ objTopics[key] +'</option>'
                });
                $topicDropDown.append(topicItems);
            };


            const resetTopicsDropdown = () => {
                $topicDropDown.select2("val", "");
            };


            const clearJsonPrev = () => {
                jsonResultDiv.html('');
            };

            //get all links and their info, according to provided topic
            const getContentByTopic = (topic) => {
                contentObj = _getContents();
                var mvar = {};

                Object.keys(contentObj).forEach((key, index) => {
                    //console.log(`${key}: ${contentObj[key]}`);
                    if(key == topic){
                        mvar[key] = contentObj[key];
                    }
                });
                return mvar;
            };

            const _showJson = (event) => {
                if(isContentEditFinished()){
                    jsonResultDiv.html('<pre>' + JSON.stringify(_getContents(),undefined,2) + '</pre>');
                }else{
                    toastr['error']('Finish editing before view json!');
                }
            };


            const _deleteContentItem = (event) => {
                event.preventDefault();                

                if(!isContentEditFinished()){
                    toastr['error']('Finish editing before delete!');
                    return false;
                }

                var currentTopic = $topicDropDown.val();
                if(currentTopic == ''){
                    toastr['error'](`Please select a topic before delete!`);
                    return false;
                }

                let randString = Math.random().toString(16).substr(2, 12);
                let cls = 'remove_' + randString;
                $(event.target).parent().addClass(cls);
                var contentJson = _getContents();

                var arr = [];
                
                //get all links except the item that going to delete 
                contentList.find('li:not(".' + cls + '")').each(function(index, li_item) {
                    var is_Free   = ($(li_item).find('.cc-price').html() == 'Paid')?false:true;
                    var is_Download    = ($(li_item).find('.cc-type').html() == 'Video')?false:true;

                    var infoObj = {
                            inputText   : $(li_item).find('.cc-link').html(),
                            inputUrl    : $(li_item).find('.cc-link').attr('href'),
                            linkParam   : $(li_item).find('.cc-param').html(),
                            isFree      : is_Free,
                            isDownload  : is_Download,
                        };
                    arr.push(infoObj);
                });

                contentJson[currentTopic] = arr;
               _updateContentFieldVal(contentJson);
               _render();
            };

            //delete all the links of a topic
            const deleteContentByTopic = (topic = null) => {
                if(!topic){
                    toastr['error'](`Select a topic first`);
                    return false;
                }

                var contentJson = _getContents();

                if(contentJson.hasOwnProperty(topic) === true){
                    delete contentJson[topic];
                }else{
                    return false;
                }
                _updateContentFieldVal(contentJson);
                return true;
            };


            const _editContentItem = (event) => {

                if(_contentItemCounInEditState() > 0){
                    toastr['error']('Can\'t edit more than one link at the same time.');
                    return false;
                }

                var parent_li_item  = $(event.target).parent();
                parent_li_item.addClass('edit');
                parent_li_item.children('.txt-div').hide();

                var _inputText   = parent_li_item.children('.txt-div').children('.cc-link').html();
                var _inputUrl    = parent_li_item.children('.txt-div').children('.cc-link').attr('href');
                var _linkParam   = parent_li_item.children('.txt-div').children('.cc-param').html();
                var _isFree      = (parent_li_item.children('.txt-div').children('.cc-price').html()=='Free')?'check':'uncheck';
                var _isDownload  = (parent_li_item.children('.txt-div').children('.cc-type').html()=='Video')?'uncheck':'check';

                parent_li_item.find('input[name="content-text"]').val(_inputText);
                parent_li_item.find('input[name="content-url"]').val(_inputUrl)
                parent_li_item.find('input[name="link_param"]').val(_linkParam);
                parent_li_item.find('input[name="is_free"]').iCheck(_isFree);
                parent_li_item.find('input[name="is_download"]').iCheck(_isDownload);

                parent_li_item.children('.course-content-div').removeClass("close");
                parent_li_item.find('input[name="content-text"]').focus();

                $(event.target).fadeOut(300, function(){ $(this).hide();});

                parent_li_item.children('.ok-btn').show();
                parent_li_item.children('.undo-btn').show();
                $topicDropDown.prop('disabled', true);
                event.preventDefault();
            };

            //after topic rename in topics tab(tab2) update the contentJson field
            const renameContentJsonKey = (oldVal,newVal) => {
                var contentJson = _getContents();
                var mvar = {};
                Object.keys(contentJson).forEach((key, index) => {
                    //console.log(`${key}: ${contentJson[key]}`);
                    if(key == oldVal){
                        mvar[newVal] = contentJson[key]
                    }else{
                        mvar[key] = contentJson[key];
                    }
                });

                if(!$.isEmptyObject(mvar)){
                    _updateContentFieldVal(mvar);
                    return true
                }
                return false;
            };


            const _editContentItemSubmit = (event) => {
                //var thisTab = $("#tab-add-course-content");
                var parent_li_item  = $(event.target).parent();

                var _inputText   = parent_li_item.find('input[name="content-text"]').val();
                var _inputUrl    = parent_li_item.find('input[name="content-url"]').val();
                var _linkParam   = parent_li_item.find('input[name="link_param"]').val();
                var _isFree      = (parent_li_item.find('input[name="is_free"]').is(":checked")==true)?'Free':'Paid';
                var _isDownload  = (parent_li_item.find('input[name="is_download"]').is(":checked")==true)?'Download':'Video';


                if (_inputText == ""){
                    thisTab.find(".msg-div").text("content text cant be empty!");
                    return false;
                }

                if(_inputUrl == ""){
                    thisTab.find(".msg-div").text("content url cant be empty!");
                    return false;
                }

                parent_li_item.find('.cc-link').html(_inputText);
                parent_li_item.find('.cc-link').attr("href", _inputUrl);
                parent_li_item.find('.cc-param').html(_linkParam);
                parent_li_item.find('.cc-price').html(_isFree);
                parent_li_item.find('.cc-type').html(_isDownload);


                parent_li_item.children('.txt-div').show();
                parent_li_item.find('.course-content-div').addClass("close");

                $(event.target).fadeOut(300, function(){ $(this).hide();});
                parent_li_item.children('.undo-btn').fadeIn(500, function(){ $(this).hide();});
                parent_li_item.children('.ok-btn').fadeIn(500, function(){ $(this).hide();});

                parent_li_item.children('.edit-btn').fadeIn(500, function(){ $(this).show();});

                parent_li_item.removeClass('edit');
                thisTab.find(".msg-div").text("");

                _rearrangeContnetjsonfield();
                $topicDropDown.prop('disabled', false);
                event.preventDefault();
            };

            //undo the changes
            const _editContentItemCancel = (event) => {

                var parent_li_item  = $(event.target).parent();
                parent_li_item.removeClass('edit');

                parent_li_item.children('.txt-div').show();
                parent_li_item.children('.course-content-div').addClass("close");

                parent_li_item.children('.edit-btn').fadeIn(500, function(){ $(this).show();});
                parent_li_item.children('.ok-btn').fadeIn(500, function(){ $(this).hide();});
                parent_li_item.children('.undo-btn').fadeIn(500, function(){ $(this).hide();});
                $topicDropDown.prop('disabled', false);
                event.preventDefault();
            };

            _init();

            return {
                renderTopicsDropdown,
                resetTopicsDropdown,
                clearJsonPrev,
                isContentEditFinished,
                check_content_exist,
                deleteContentByTopic,
                renameContentJsonKey,
                getContentByTopic                                
                //_resetInputForm,             
                //_getContents
            };

        });

    </script>
@stop
