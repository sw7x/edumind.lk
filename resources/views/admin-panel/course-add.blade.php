@extends('admin-panel.layouts.master',['title' => 'Add course'])
@section('title','Add course')


@section('css-files')
<!-- select2 -->
<link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<link rel="stylesheet" href="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.css')}}">
<!-- <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">-->

<link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
{{--<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/green.css">--}}


<!-- <link rel='stylesheet' href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'> -->
<link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond-plugin-image-preview.min.css')}}">
<!-- <link rel='stylesheet' href='https://unpkg.com/filepond/dist/filepond.min.css'> -->
<link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond.min.css')}}">

<!-- jQuery Steps -->
<link rel='stylesheet' href="{{asset('admin/css/plugins/steps/jquery.steps.css')}}">

<!-- sweetalert2 CSS file-->
<link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">

<!-- toastr CSS file-->
<link rel="stylesheet" href="{{asset('admin/css/plugins/toastr/toastr.min.css')}}">

<!-- rangeslider CSS file-->
<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.0/rangeslider.min.css'> -->
<link rel='stylesheet' href="{{asset('admin/plugins/rangeslider/css/rangeslider.min.css')}}">

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

    .three-state-checkbox {
        background-color: #fff;
        border: solid 1px #ccc;
        cursor: pointer;
        display: inline-block;
        height: 22px;
        margin-right: 0.25rem;
        text-align: center;
        width: 22px;
        vertical-align: middle;
    }

    .three-state-checkbox svg {
        margin-top: 0px;
        stroke: #fff;
        margin-left: 0px;
    }

    .three-state-checkbox.positive {
        /*background-color: #4aca65;
        border-color: #43b45b;*/
    }

    .three-state-checkbox.negative {
        /*background-color: #dc4e4e;
        border-color: #c74545;*/
    }

    .three-state.checkbox-container .label {
        font-weight: bold;
        vertical-align: middle;
        font-size: 12px;
        color: #000000;
    }

</style>

@stop


@section('content')
    <div class="row" id="">
        <div class="col-lg-12">          
            
            <?php //dump(old('contentArr')); ?>
            <?php //dump(old('contentInputStr','')); ?>
            <?php //dump(old('contentJson')); ?>            
            <?php //dump(old('course-name')); ?>
            <?php //dump($errors); ?>
            <?php //dump($errors->infoErrMsgArr->getMessages()); ?>
            
           

            @if(Session::has('message'))
                <x-flash-message
                    class="{{ Session::get('cls', 'flash-info')}}" 
                    :title="Session::get('msgTitle')"
                    :message="Session::get('message')">
                    tttttttt
                    <x-slot name="insideContent">
                        @if ($errors->infoErrMsgArr->getMessages())
                            <ul class="mt-3 mb-4 ml-4 list-disc text-xs text-red-600 font-bold">
                                @foreach ($errors->infoErrMsgArr->getMessages() as $field => $errorMsgArr)
                                    @foreach ($errorMsgArr as $errorMsg)
                                        <li class="">{{ $errorMsg }}</li>
                                    @endforeach
                                @endforeach
                            </ul>
                        @endif
                                            
                        <?php 
                            //dump($errors);
                            //dump($errors->courseCreate->any());
                            //dump($errors->all());
                            //dump($errors->courseCreate);
                            //dump($errors->courseCreate->getMessages());

                            ////dump($errors->courseCreate['messages']);
                            //dump($errors->courseCreate->get('course-name'));

                            //dump($errors->courseCreate->has('subject'));
                            //dump($errors->courseCreate->all());
                            
                            //dump($errors->contentErrMsgArr->getMessages());
                            //dump($errors->contentLinksErrMsgArr->getMessages());
                            //dd($errors->contentLinksErrMsgArr->getMessages());
                            //dump($errors->uuu);

                            //dd($contentLinksErrMsgArr);
                        ?>

                        <?php  //dump($errors->contentErrMsgArr->getMessages()); ?>
                        @if(($errors->contentErrMsgArr->getMessages() != null) && is_array($errors->contentErrMsgArr->getMessages()))
                            @foreach ($errors->contentErrMsgArr->getMessages() as $key => $errorMsgArr)
                                <div class="card mb-4 rounded-none border-danger text-red-600 w-11/12 font-bold bg-transparent">
                                    <div class="card-header pt-1 pb-2 text-xs border-danger bg-transparent">Section - {{base64_decode($key)}}</div>
                                    <div class="card-body py-1">                                
                                        <ul class="mt-1 ml-4 list-disc mb-2 text-xs">                                   
                                            @foreach($errorMsgArr as $errKey => $errmsg)
                                                <li class="@if(!$loop->last) pb-2 mb-1 border-b border-red-300 @endif">{{$errmsg}}</li>
                                            @endforeach
                                        </ul>                                   
                                    </div>
                                </div>
                            @endforeach
                        @endif   

                        <?php //dump(Session::get('contentLinksErrMsgArr'));?>
                        @if(Session::has('contentLinksErrMsgArr') && is_array(Session::get('contentLinksErrMsgArr')))
                            @foreach (Session::get('contentLinksErrMsgArr') as $key => $errorMsgArr)
                                <div class="card mb-4 rounded-none border-danger text-red-600 w-11/12 font-bold bg-transparent">
                                    <div class="card-header pt-1 pb-2 text-xs border-danger bg-transparent">Section - {{base64_decode($key)}}</div>
                                    <div class="card-body py-1">                                
                                        <ul class="mt-1 ml-4 list-disc mb-2 text-xs">                                    
                                            @foreach($errorMsgArr as $errKey => $errmsg)
                                                <li class="@if(!$loop->last) pb-2 mb-1 border-b border-red-300 @endif">Link {{($errKey+1)}}  ⟹  {{$errmsg}}</li>
                                            @endforeach
                                        </ul>                                   
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </x-slot>
                </x-flash-message>
            @else           
                <div class="ibox">
                    <div class="ibox-content">                    
                        <form id="course-add-form" method="post" action="{{route('admin.course.store')}}" class="wizard-big wizard clearfix" enctype="multipart/form-data">
                            {{csrf_field ()}}
                            <h1>Details</h1>
                            <fieldset>
                                <h2>Add course details</h2>
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="form-group  row">
                                            <label class="col-sm-4 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="course-name" class="form-control" value="{{old('course-name')}}">
                                                <div class="error-msg"></div>
                                                @if ($errors->infoErrMsgArr->has('course-name'))
                                                    <ul class="mt-1">
                                                        @foreach ($errors->infoErrMsgArr->get('course-name') as $error)
                                                            <ol class="text-red-600 text-xs font-bold">{{ $error }}</ol>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                            
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Subject <span class="text-red-500 text-sm font-bold">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control m-b" id="subject" name="subject">
    												<option></option>
    												@foreach ($subjects as $subject)
    													<option value="{{$subject['id']}}" @if(old('subject') == $subject['id']) selected @endif>{{$subject['name']}}</option>
    												@endforeach
                                                </select>
                                                <div class="error-msg"></div>
                                                @if ($errors->infoErrMsgArr->has('subject'))
                                                    <ul class="mt-1">
                                                        @foreach ($errors->infoErrMsgArr->get('subject') as $error)
                                                            <ol class="text-red-600 text-xs font-bold">{{ $error }}</ol>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Teacher <span class="text-red-500 text-sm font-bold">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control m-b" id="teacher" name="teacher">
    												<option></option>
    												@foreach ($teachers as $teacher)
    													<option value="{{$teacher['id']}}" @if(old('teacher') == $teacher['id']) selected @endif>{{$teacher['full_name']}}</option>
    												@endforeach
                                                </select>
                                                <div class="error-msg"></div>
                                                @if ($errors->infoErrMsgArr->has('teacher'))
                                                    <ul class="mt-1">
                                                        @foreach ($errors->infoErrMsgArr->get('teacher') as $error)
                                                            <ol class="text-red-600 text-xs font-bold">{{ $error }}</ol>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group row"><label class="col-sm-4 col-form-label">Heading text</label>
                                            <div class="col-sm-8">
                                                <div class="border">
                                                    <textarea class="form-control" name="course-heading"
                                                              cols="30" rows="7" placeholder="" autocomplete="off">{{old('course-heading')}}</textarea>
                                                    <div class="error-msg"></div>
                                                </div>
                                                @if ($errors->infoErrMsgArr->has('course-heading'))
                                                    <ul class="mt-1">
                                                        @foreach ($errors->infoErrMsgArr->get('course-heading') as $error)
                                                            <ol class="text-red-600 text-xs font-bold">{{ $error }}</ol>
                                                        @endforeach
                                                    </ul>
                                                @endif
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
                                                {{--<input type="file" id="course-img" name="course-img"/>--}}
                                                <input 
                                                    type="file" class="filepond-img" name="course-img"
                                                    data-max-file-size="1MB"
                                                    accept="image/webp, image/png, image/jpeg, image/gif"/>                                          
                                                <div class="__error-msg"></div>
                                                @if ($errors->infoErrMsgArr->has('course-img'))
                                                    <ul class="mt-1">
                                                        @foreach ($errors->infoErrMsgArr->get('course-img') as $error)
                                                            <ol class="text-red-600 text-xs font-bold">{{ $error }}</ol>
                                                        @endforeach
                                                    </ul>
                                                @endif                                            

                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group  row">
                                            <label class="col-sm-4 col-form-label">Duration<br> <small>X Hours : Y minutes</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="video-duration" class="form-control" value="{{old('video-duration')}}">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group  row">
                                            <label class="col-sm-4 col-form-label">Videos <small>(count)</small></label>
                                            <div class="col-sm-8">
                                                <input type="text" name="video-count" class="form-control" value="{{old('video-count')}}">
                                                <div class="error-msg"></div>
                                                @if ($errors->infoErrMsgArr->has('video-count'))
                                                    <ul class="mt-1">
                                                        @foreach ($errors->infoErrMsgArr->get('video-count') as $error)
                                                            <ol class="text-red-600 text-xs font-bold">{{ $error }}</ol>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        {{--
    									<div class="form-group  row">
    										<label class="col-sm-4 col-form-label">Author share <small>(percentage)</small></label>
    										<div class="col-sm-8 text-base">60%</div>
    									</div>
    									<div class="hr-line-dashed"></div>
                                        --}}

    									<div class="form-group row">
    										<label class="col-sm-4 col-form-label">Author share <small>(percentage)</small></label>
    										<div class="col-sm-8">
    											<div class="text-2xl text-center font-bold output"></div><br>
    											<input type="range" name="author_share_percentage" value="{{old('author_share_percentage',60)}}" min="0" max="100" step="1">
    										</div>
    									</div>
    									<div class="hr-line-dashed"></div>

                                        <div class="form-group  row">
                                            <label class="col-sm-4 col-form-label">Price</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon">Rs</span>
                                                    </div>
                                                    <input type="text" name="course-price" class="form-control" value="{{old('course-price')}}"><br>
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
                                                    <label> <input type="radio" class="iCheck" value="draft" name="course_stat" {{(old('course_stat')) == 'draft'? 'checked':''}}> <i></i>Draft </label>
                                                </div>
                                                <div class="">
                                                    <label> <input type="radio" class="iCheck" value="published" name="course_stat" {{(old('course_stat')) != 'draft'? 'checked':''}}> <i></i>Published </label>
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

                                        <div class="row mb-3 alert alert-warning px-0 border border-sky-500">                                        
                                            <div class="ml-2 col-sm-10">
                                                <div class="course-topics-json-result"></div>
                                            </div>
                                            <div class="-ml-2 col-sm-2">
                                                <input type="button" class="mr-2 float-right btn btn-primary btn-sm" id="json-btn" value="json">
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
                                                                    <span class="input-group-addon">Embed Url</span>
                                                                </div>
                                                                <!-- <input type="text" name="content-url" class="form-control"><br> -->                                                            
                                                                <textarea rows="5" class="form-control" placeholder="Enter Embed URL" name="content-url"></textarea><br>
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
                                                            
                                                            <div class="three-state checkbox-container" id="input_link_type">                                                            
                                                                <span class="three-state-checkbox"></span>
                                                                <span class="font-semibold">Link type : </span>
                                                                <span class="label">Other(Zoom)</span>
                                                                <input type="hidden" name="link_type" value="other">
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

                                        <div class="row mb-3 alert alert-warning px-0 border border-sky-500">
                                            <div class="ml-2 col-sm-10">
                                                <div class="course-content-json-result"></div>
                                            </div>
                                            <div class="-ml-2 col-sm-2">
                                                <input type="button" class="mr-2 float-right btn btn-primary btn-sm" id="json-btn" value="json">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <!-- 
                            <h1>Finish</h1>
                            <fieldset>
                                <h2>Terms and Conditions</h2>
                                <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                            </fieldset> 
                            -->

                            <input name="topicsJson" id="topicsJson" type="hidden" value=''>
                            <input name="contentJson" id="contentJson" type="hidden" value="">
                            
                        </form>
                    </div>
                </div>
            @endif  

        </div>
    </div>


    <svg xmlns="http://www.w3.org/2000/svg" style="display:none" aria-hidden="true">                

        <symbol id="link_icon" viewBox="0 0 256 256">
			<g transform="translate(128 128) scale(0.72 0.72)" style="">
				<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(-175.05 -175.05) scale(3.89 3.89)" >
					<path d="M 41.242 69.371 l -8.953 8.954 c -0.288 0.287 -0.627 0.331 -0.803 0.331 c -0.176 0 -0.515 -0.044 -0.803 -0.332 L 11.676 59.317 c -0.443 -0.443 -0.443 -1.163 0 -1.606 l 24.98 -24.98 c 0.288 -0.288 0.626 -0.331 0.802 -0.331 h 0 c 0.176 0 0.515 0.043 0.803 0.331 l 16.362 16.362 l 8.025 -8.025 L 46.287 24.707 c -4.869 -4.869 -12.789 -4.868 -17.657 0 L 3.65 49.686 c -4.867 4.868 -4.867 12.789 0 17.656 l 19.007 19.007 c 2.434 2.434 5.631 3.65 8.828 3.65 c 3.197 0 6.394 -1.217 8.827 -3.65 l 13.961 -13.961 C 50.063 74.716 46.357 73.631 41.242 69.371 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,123,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
					<path d="M 48.758 20.629 l 8.953 -8.954 c 0.288 -0.287 0.627 -0.331 0.803 -0.331 c 0.176 0 0.515 0.044 0.803 0.332 l 19.007 19.007 c 0.443 0.443 0.443 1.163 0 1.606 l -24.98 24.98 c -0.288 0.288 -0.626 0.331 -0.802 0.331 h 0 c -0.176 0 -0.515 -0.043 -0.803 -0.331 L 35.377 40.907 l -8.025 8.025 l 16.362 16.361 c 4.869 4.869 12.789 4.868 17.657 0 l 24.98 -24.979 c 4.867 -4.868 4.867 -12.789 0 -17.656 L 67.342 3.651 C 64.908 1.217 61.711 0 58.514 0 c -3.197 0 -6.394 1.217 -8.827 3.65 L 35.725 17.611 C 39.937 15.284 43.643 16.369 48.758 20.629 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,123,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
				</g>
			</g>
		</symbol>

        <symbol id="download_icon" viewBox="0 0 256 256">
			<g transform="translate(128 128) scale(0.72 0.72)" style="">
				<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(-175.05 -175.05) scale(3.89 3.89)" >
					<path d="M 69.726 78.71 h -46.13 C 10.585 78.71 0 68.125 0 55.115 c 0 -11.185 8.035 -20.892 18.894 -23.098 C 22.76 19.75 34.195 11.29 47.14 11.29 c 15.829 0 28.819 12.494 29.609 28.138 C 84.62 42.34 90 49.955 90 58.436 C 90 69.615 80.905 78.71 69.726 78.71 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(171,226,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
					<path d="M 57.496 42.886 l -4.878 4.878 c -0.971 0.971 -2.632 0.283 -2.632 -1.09 v 0 V 27.602 c 0 -0.851 -0.69 -1.542 -1.542 -1.542 h -6.89 c -0.851 0 -1.542 0.69 -1.542 1.542 v 19.072 c 0 1.373 -1.66 2.061 -2.632 1.09 l -4.878 -4.878 c -0.602 -0.602 -1.578 -0.602 -2.18 0 l -4.872 4.872 c -0.602 0.602 -0.602 1.578 0 2.18 l 12.496 12.496 l 5.962 5.962 c 0.602 0.602 1.578 0.602 2.18 0 l 5.962 -5.962 l 12.496 -12.496 c 0.602 -0.602 0.602 -1.578 0 -2.18 l -4.872 -4.872 C 59.074 42.284 58.098 42.284 57.496 42.886 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
				</g>
			</g>
		</symbol>
		
        <symbol id="video_icon" viewBox="0 0 256 256">            
			<g transform="translate(128 128) scale(0.72 0.72)" style="">
				<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(-175.05 -175.05) scale(3.89 3.89)" >
					<circle cx="46.283" cy="45.003" r="29.803" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(249,249,249); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
					<path d="M 45 0 C 20.147 0 0 20.147 0 45 c 0 24.853 20.147 45 45 45 s 45 -20.147 45 -45 C 90 20.147 69.853 0 45 0 z M 62.251 46.633 L 37.789 60.756 c -1.258 0.726 -2.829 -0.181 -2.829 -1.633 V 30.877 c 0 -1.452 1.572 -2.36 2.829 -1.634 l 24.461 14.123 C 63.508 44.092 63.508 45.907 62.251 46.633 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(210,34,21); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
				</g>
			</g>		
		</symbol>

    </svg>



@stop




@section('script-files')

    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>


    <!-- SUMMERNOTE -->
    <!-- <script src="../assets/summernote-0.8.18/summernote-lite.js"></script> -->
    <script src="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.js')}}"></script>

    <!-- 
    <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src='https://unpkg.com/filepond/dist/filepond.min.js'></script> 
    --> 
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
    {{--
    <script src="{{asset('admin/js/plugins/validate/additional-methods.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/validate/custom-additional-methods.js')}}"></script>
    --}}


    <!-- iCheck-->
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>-->


    <!-- sweetalert2 js file-->
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- toastr js file-->
    <script src="{{asset('admin/js/plugins/toastr/toastr.min.js')}}"></script>

	<!-- rangeslider JS file-->
	<!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/rangeslider.js/2.3.0/rangeslider.min.js'></script> -->
    <script src="{{asset('admin/plugins/rangeslider/js/rangeslider.min.js')}}"></script>
@stop

@section('javascript')
    <script>
		(function () {
			//We want to preview images, so we need to register the Image Preview plugin
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
        var inputLinkType;

        /* course content from Database */
        //var courseContentFromOld   = '{\n                           "aa111":[\n                              {\n                                 "inputText":"aa1",\n                                 "inputUrl":"aa12",\n                                 "linkParam":"aa13",\n                                 "isFree":false,\n                                 "type":"video"\n                              },\n                              {\n                                 "inputText":"bb1",\n                                 "inputUrl":"bb12",\n                                 "linkParam":"bb13",\n                                 "isFree":true,\n                                 "type":"download"\n                              },\n                              {\n                                 "inputText":"cc3",\n                                 "inputUrl":"cc32",\n                                 "linkParam":"cc33",\n                                 "isFree":false,\n                                 "type":"other"\n                              },\n                              {\n                                 "inputText":"dd4",\n                                 "inputUrl":"dd41",\n                                 "linkParam":"dd42",\n                                 "isFree":true,\n                                 "type":"video"\n                              },\n                              {\n                                 "inputText":"ee5",\n                                 "inputUrl":"ee51",\n                                 "linkParam":"ee52",\n                                 "isFree":true,\n                                 "type":"video"\n                              }\n                           ],\n                           "bb":[\n                              {\n                                 "inputText":"zz",\n                                 "inputUrl":"zzq",\n                                 "linkParam":"zzq",\n                                 "isFree":false,\n                                 "type":"video"\n                              },\n                              {\n                                 "inputText":"xx",\n                                 "inputUrl":"xx1",\n                                 "linkParam":"xx2",\n                                 "isFree":false,\n                                 "type":"download"\n                              },\n                              {\n                                 "inputText":"cc",\n                                 "inputUrl":"cc2",\n                                 "linkParam":"cc3",\n                                 "isFree":true,\n                                 "type":"other"\n                              },\n                              {\n                                 "inputText":"vv",\n                                 "inputUrl":"vvf",\n                                 "linkParam":"vvr",\n                                 "isFree":true,\n                                 "type":"download"\n                              }\n                           ],\n                           "cc":[\n                              {\n                                 "inputText":"gg",\n                                 "inputUrl":"gg1",\n                                 "linkParam":"gg2",\n                                 "isFree":true,\n                                 "type":"video"\n                              },\n                              {\n                                 "inputText":"hh1",\n                                 "inputUrl":"hh2",\n                                 "linkParam":"hh3",\n                                 "isFree":true,\n                                 "type":"other"\n                              },\n                              {\n                                 "inputText":"jj1",\n                                 "inputUrl":"jj2",\n                                 "linkParam":"jj3",\n                                 "isFree":false,\n                                 "type":"other"\n                              },\n                              {\n                                 "inputText":"kk1",\n                                 "inputUrl":"kk2",\n                                 "linkParam":"kk3",\n                                 "isFree":true,\n                                 "type":"download"\n                              },\n                              {\n                                 "inputText":"ll1",\n                                 "inputUrl":"ll2",\n                                 "linkParam":"ll3",\n                                 "isFree":true,\n                                 "type":"download"\n                              }\n                           ],\n                           "dd":[\n                              {\n                                 "inputText":"susa1",\n                                 "inputUrl":"su",\n                                 "linkParam":"sae",\n                                 "isFree":true,\n                                 "type":"download"\n                              }\n                           ],\n                           "ee":[],\n                           "ff":[\n                              {\n                                 "inputText":"ff-susa1",\n                                 "inputUrl":"f-su",\n                                 "linkParam":"f-sae",\n                                 "isFree":true,\n                                 "type":"download"\n                              }\n                           ]\n                        }';
        var courseContentFromOld     = {{ Js::from(old('contentInputStr','{}')) }};
        
        
		/* percentage range slider */
		$(document).on('input', 'input[name="author_share_percentage"]', function(e) {
            valueOutput(e.target);
        });

        function valueOutput(element) {
			let value  = $(element).val();
			$(element).parent().find('.output').html(value + '%');
		}		
		/***************************/



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

			var courseForm = $("#course-add-form");
            let pond;

            courseForm.steps({
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
                    pond = FilePond.create(document.querySelector('.filepond-img'));

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
                    @if(null != old('course-description'))
                        $('[name="course-description"]').summernote('code', `{!!old('course-description')!!}`);
                    @endif



					$('input').iCheck({
						checkboxClass: 'icheckbox_square-green',
						radioClass: 'iradio_square-green',
					});


					/***** precentage range slider *******/
					let $inputRange = $('input[name="author_share_percentage"]');
					$inputRange.rangeslider({
						polyfill: false
					});
					for (let i = $inputRange.length - 1; i >= 0; i--) {
						valueOutput($inputRange[i]);
					}
					/*************************************/

					
					//activate topicsModule,courseContentModule, 3state checkbon input
                    courseTopicFunctionality   = topicsModule(window,jQuery);
                    courseContentFunctionality = courseContentModule(window,jQuery);
                    inputLinkType = threeStateCheckboxModule(window,jQuery,$('#input_link_type'));                    

                },
				onStepChanging: function (event, currentIndex, newIndex)
				{                    
                    //var fv = $("#course-add-form").data('formValidation');
                    //var fv = courseForm.data('formValidation');

                    // The current step container
                    //$container = $("#course-add-form").find('section[data-step="' + currentIndex +'"]');
                    
                    /*console.log('=========pond========');
                    console.log(pond);
                    console.log(typeof pond);
                    console.log(typeof pond);
                    console.log(pond.getFile());
                    console.log(pond.getFile(1));
                    console.log(pond.getFile().fileExtension);
                    console.log(pond.getFile().fileSize);*/

                    
                    if(currentIndex === 0){
                        // validate course image
                        if(pond.getFile(0)){
                            try {                      
                                let fileExt     = pond.getFile(0).fileExtension;
                                let fileSize    = pond.getFile(0).fileSize;
                                let msg         = '';

                                if(!['webp', 'png', 'jpeg', 'jpg', 'gif'].includes(fileExt)){
                                    msg += 'only image type jpg/png/jpeg/gif/webp is allowed';                          
                                }

                                if(fileSize /1024 > 1000){
                                    if(!['webp', 'png', 'jpeg', 'jpg', 'gif'].includes(fileExt)){
                                        msg += ' and '
                                    }
                                    msg += 'file size must be less than 1MB';
                                }

                                if(msg != ''){
                                    msg = 'Course image - ' + msg + '. !';
                                    toastr['error'](msg);
                                    return; 
                                }

                            }
                            catch(err) {                          
                                toastr['error'](err.message);
                                return;
                            }
                        }
                    }                   

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

                    // Validate the container
                    //fv.validateContainer(currentIndex);

					//return true;

                    //var form = $(this);
                    $(this).validate().settings.ignore = ":disabled,:hidden";
                    return $(this).valid();                   
				},
				onStepChanged: function (event, currentIndex, priorIndex)
				{
					if(currentIndex ==2){
                        courseContentFunctionality.renderTopicsDropdown();
                        courseContentFunctionality.resetTopicsDropdown();
                        courseContentFunctionality.clearJsonPrev();
                        
                        /*if(!courseContentFunctionality.checkSelectedTopic()){
                            toastr['error'](`Please select a topic!`);
                        }*/
                    }                  
                },
                onFinishing: function (event, currentIndex){
                    console.log('onFinishing');
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();

                },
                onFinished: function (event, currentIndex){
                    console.log('onFinished');
                    if(!courseTopicFunctionality.isTopicEditFinished()){
                        toastr['error'](`Before submit, finish the editing topics!`);
                        return;
                    }
                                
                    if(!courseContentFunctionality.isContentEditFinished()){
                        toastr['error'](`Before submit, finish the editing links!`);
                        return;
                    }                


                    var form = $(this);
                    /*
                    var formdata = new FormData(this);
                    

                    // append FilePond files into the form data
                    pondFiles = pond.getFiles();
                    //console.log(pond.getFiles());
                    console.log(pondFiles[0].file);


                    //formdata.append('course-image', pondFiles[0].file);
                    //console.log(formdata);
                    $('#hidden-course-img').append($('<input type="hidden" ' + 
                                                    'name="course-image-hidden" ' + 
                                                    'value="' + pondFiles[0].file + '">')
                    );

                    $('#hidden-course-img').append($('<input type="text" ' + 
                                                    'name="xxx" ' + 
                                                    'value="777">')
                    );
                    */

                    // Submit form input
                    form.submit();
                }

			});



            /**/
            var validObjCourseForm = courseForm.validate({
                //ignore: [],
                onkeyup: false,
                errorClass: "validationErrorCls",
                rules:{
                    "course-name": {
                        //required: true,
                        //minlength: 3
                    },
                    //"subject"         : {required: true},
                    //"teacher"         : {required: true},
                    //"course-heading"  : {required: true},
                    //"video-count"     : {number: true,min:0},
                    /*
                    "course-img"        : { 
                        accept: "image/*",
                       filesize: 1 // 1MB
                    }*/

                },
                messages:{
                    "course-name": {
                        required:"Course name is required",
                        minlength:"Please enter at least 3 characters"
                    },
                    "subject":          {required: "Subject name is required"},
                    "teacher":          {required: "Teacher name is required"},
                    "course-heading":   {required: "Course heading is required"},
                    "video-count":      {digits:   "Video count must be digits only"},
                    /*                    
                    "course-img" :      { 
                        accept: 'Only image type jpg/png/jpeg/gif/webp is allowed',
                        filesize:" file size must be less than 1MB.",
                    }*/

                },
                submitHandler: function(form){
                    console.log('submitHandler');
                    form.submit();
                },
                errorPlacement: function (error, element)
                {
                    console.log(element);
                    //element.before(error);
                    //element.after(error);
                    error.appendTo(element.parent().find('.error-msg'));
                    element.parent().find('.error-msg').css('color','red');
                    element.parent().find('.error-msg').css('fontSize','12px');
                    error.css('margin','0px');
                },


                //When there is an error normally you just add the class to the element.
                // But in the case of select2s you must add it to a UL to make it visible.
                // The select element, which would otherwise get the class, is hidden from
                // view.
                highlight: function (element, errorClass, validClass) {
                    var elem = $(element);
                    if (elem.is("select")) {
                        elem.parent().find('.select2-selection--single').addClass(errorClass);
                        //$("#s2id_" + elem.attr("id") + " ul").addClass(errorClass);
                    } else {
                        elem.addClass(errorClass);
                    }
                },

                //When removing make the same adjustments as when adding
                unhighlight: function (element, errorClass, validClass) {
                    var elem = $(element);
                    if (elem.is("select")) {
                        //$("#s2id_" + elem.attr("id") + " ul").removeClass(errorClass);
                        elem.parent().find('.select2-selection--single').removeClass(errorClass);
                    } else {
                        elem.removeClass(errorClass);
                    }
                }

            });


            //If the change event fires we want to see if the form validates.
            //But we don't want to check before the form has been submitted by the user
            //initially.
            $(document).on("change", "select", function () {   
                console.log("=========");         
                 if (!$.isEmptyObject(validObjCourseForm.submitted)) {
                    validObjCourseForm.form();
                }
            });           

		});

     


        /*============= course topics module =========*/
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
                _fillInitialValues();
                if($('input[name=topicsJson]').length){
                    _render();
                }
                _sorting();              
            };



            const _fillInitialValues = () => {
                var dbCourseContentJson
                try {
                    //dbCourseContentJson = JSON.parse(courseContentFromOld) || {};
                    dbCourseContentJson = JSON.parse(courseContentFromOld);

                    // fix for prevent page load error if data format is 
                    if(!(dbCourseContentJson instanceof Object)){throw new Error();}
                }
                catch(e) {
                    dbCourseContentJson = {};
                    toastr['error'](`Course content set empty because invalid course content load from Database!`);
                }

                var _tempObj = {};
                Object.keys(dbCourseContentJson).forEach((key, index) => {
                    //console.log(key);
                    //console.log(dbCourseContentJson[key]);
                    _tempObj[index] = key;                    
                });

                console.log(_tempObj);
                console.log("_tempObj");
                _updateTopicsFieldVal(_tempObj);             
            };



            const _cacheDom = () => {
                form          = $("#course-add-form");
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
                        courseContentFunctionality.arrangContentArrByTopics(topicsJson);
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
                                        "<p style='width:calc(100% - 60px);'>" + inp_ele_txt + "</p>" +
                                        close_i + edit_i + undo_i + ok_i + edit_inp +
                                    "</li>";
                });

                if(_topicList == ''){
                    _topicList = '<div class="alert alert-danger" role="alert"><span class="font-bold">No Topics!</span></div>';
                }

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
                courseContentFunctionality.addEmptyContent(txt);
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
                    jsonResultDiv.html('<pre>' + JSON.stringify(getTopics(),undefined,2) + '</pre>');
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
        


        /*============= three State Checkbox module =========*/
        const threeStateCheckboxModule = (function (window, $,$checkBoxContainer) {
            let thisContainer;
            let checkbox;
            let lbl;
            let field;

            const _init = () => {
                _cacheDom();
                _bindEvents();
                _bind();
                
            }        
           
            const _cacheDom = () => {                
                thisContainer       = $checkBoxContainer;
                checkbox            = thisContainer.find('.three-state-checkbox');
                lbl                 = thisContainer.find('.label');
                field               = thisContainer.find('input[name="link_type"]');
            }
            
            const _bindEvents = () => {   
                checkbox.click(_changeCheckbox);                
            }

            const _bind = () => {
                checkbox.bind('video',switch2Video);
                checkbox.bind('other',switch2Other);
                checkbox.bind('download',switch2Download);
            }

            const _changeCheckbox = (event) => {

                /*
                * neutral   - other
                * positive  - video
                * negative  - download
                * 
                */

                if(checkbox.hasClass('positive')){
                    switch2Download();
                }else if (checkbox.hasClass('negative')){
                    switch2Other();
                }else {
                    switch2Video();
                }
                //console.log(checkbox.parent().find('.label').text());
            }  

            const switch2Video = () => {
                checkbox.addClass('positive');
                checkbox.html('<svg width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="10.9375%"><use xlink:href="#video_icon"></use></svg>');
                //checkbox.next().text('Positive');
                //checkbox.parent().find('.label').text('Video');
                lbl.text('Video');
                checkbox.parent().find('input[name="link_type"]').val('video');
            }

            const switch2Other = () => {
                checkbox.removeClass('negative');                                                        
                checkbox.html('');
                //checkbox.next().text('Neutral');
                lbl.text('Other(Zoom)');
                checkbox.parent().find('input[name="link_type"]').val('other');
            }

            const switch2Download = () => {
                checkbox.removeClass('positive');
                checkbox.addClass('negative');               
                checkbox.html('<svg width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="10.9375%"><use xlink:href="#download_icon"></use></svg>');
                //checkbox.next().text('Negative');
                lbl.text('Download');
                checkbox.parent().find('input[name="link_type"]').val('download');
            }

             _init();

            return {
                switch2Video,
                switch2Other,
                switch2Download, 
            };                 
        });



        /*============= course links module    =========*/
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
            let linkType;
            let $topicsField;
            let $topicDropDown;

            const _init = () => {
                _cacheDom();
                _bindEvents();
                _fillInitialValues();
                if($('input[name=contentJson]').length){
                    _render();
                }
                _sorting();
                //alert('2-init');
            };
           
            const addEmptyContent = (currentTopic) => {                
                var contentJson = _getContents();
                contentJson[currentTopic] = [];
                _updateContentFieldVal(contentJson);                
            }

            //
            const arrangContentArrByTopics = (topicsJson) => {
                var contentJson = _getContents();                
                var tempObj = {};

                Object.keys(topicsJson).forEach((key, index) => {                   
                    tempObj[topicsJson[key]] = contentJson[topicsJson[key]]
                }); 

                _updateContentFieldVal(tempObj); 
            }

           
            const _fillInitialValues = () => {
                var dbCourseContentJson
                try {
                    //dbCourseContentJson = JSON.parse(courseContentFromOld)  || {};
                    dbCourseContentJson = JSON.parse(courseContentFromOld);

                    // fix for prevent page load error if data format is 
                    if(!(dbCourseContentJson instanceof Object)){throw new Error();}                   
                }
                catch(e) {
                    dbCourseContentJson = {};
                    //toastr['error'](`Course content set empty because invalid course content load from Database!`);
                }
                _updateContentFieldVal(dbCourseContentJson);             
            };


            const _cacheDom = () => {
                form                = $("#course-add-form");
                thisTab             = $("#tab-add-course-content");
                addBtn              = thisTab.find("#add-course-content");
                contentListArea     = thisTab.find(".course-content-list-area");
                contentList         = thisTab.find(".course-content-list-area ul#course-content-list");
                jsonBtn             = thisTab.find("#json-btn");
                jsonResultDiv       = thisTab.find('.course-content-json-result');
                
                inputText           = thisTab.find('input[name="content-text"]');
                inputUrl            = thisTab.find('textarea[name="content-url"]');
                linkParam           = thisTab.find('input[name="link_param"]');
                isFree              = thisTab.find('input[name="is_free"]');
                linkType            = thisTab.find('input[name="link_type"]');
                

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
                    //var is_Download   = ($(li_item).find('.cc-type').html() == 'Video')?false:true;
                    var is_Download     = $(li_item).find('.cc-type').html();


                    var infoObj = {
                        inputText   : $(li_item).find('.cc-link').html(),
                        inputUrl    : $(li_item).find('.cc-link').attr('href'),
                        linkParam   : $(li_item).find('.cc-param').html(),
                        isFree      : is_Free,
                        type  : is_Download,
                    };
                    arr.push(infoObj);
                });
                contentJson[currentTopic] = arr;
                _updateContentFieldVal(contentJson);
            };


            const checkSelectedTopic = () => {
                return $topicDropDown.val();

            };

            const _render = (topic = null) => {
                var contentListHtml ='';
                var currentTopic = (topic)?topic:$topicDropDown.val();

                if(currentTopic == ''){
                    //toastr['error'](`Please select a topic!`);
                    contentListHtml =   `<div class="alert alert-primary" role="alert">
                                            <span class="font-bold">Please select a topic to display the content!</span>
                                        </div>`;                                        
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
                                                        <textarea rows="5" class="form-control" name="content-url"></textarea><br>
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
                                                <div class="col-sm-3 -ml-1 three-state checkbox-container">
                                                    <span class="three-state-checkbox"></span>
                                                    <span class="font-semibold">Link type : </span>                                                            
                                                    <span class="label">Other(Zoom)</span>
                                                    <input type="hidden" name="link_type" value="other">
                                                </div>
                                            </div>

                                        </div>
                                    </div>`;
                    var freeVal;
                    var c_type;

                    if (typeof content[currentTopic] != 'undefined'){
                        
                        


                        var tty = content[currentTopic];

                        if (!Array.isArray(content[currentTopic]) || !content[currentTopic].length) {
                            // array does not exist, is not an array, or is empty
                            // ⇒ do not attempt to process array

                            contentListHtml +=   `<div class="alert alert-danger" role="alert">
                                                    <span class="font-bold">No Links available for the selected Topic!</span>
                                                </div>`;
                        }else{

                            content[currentTopic].forEach((element, index) => {
                                freeVal   = (element.isFree == true)?'Free':'Paid';
                                //c_type    = (element.link_type == true)?'Download':'Video';
                                c_type    = element.type;


                                contentListHtml +=  "<li>" +
                                                        '<div class="txt-div border pl-2 py-1" style="font-size:14px; width:calc(100% - 60px);">' +
                                                            '<a class="cc-link" href="' + element.inputUrl + '">' + element.inputText + '</a>' +
                                                            
                                                            '<div class="-ml-2 border-b border-gray-300 my-2"></div>' + 
                                                            
                                                            '<div class="text-xs font-semibold">' + 
                                                                'Duration/Size - <span class="cc-param">' + element.linkParam + '</span><br>' +
                                                                'Price - <span class="cc-price">' + freeVal + '</span><br>' +
                                                                'Type - <span class="cc-type capitalize">' + c_type + '</span>' +
                                                            '</div>' + 
                                                        '</div>' +
                                                        close_i + edit_i + undo_i +ok_i +  formHtml +
                                                    "</li>";
                            });
                        }




                    }
                }



                /*if(contentListHtml == ''){
                    
                }*/

                contentList.html('');
                contentList.append(contentListHtml);


                // for free checkbox
                contentList.find('li').each(function( index, element ){
                    $(element).find('.i-checks').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });

                    var checkbox_container = $(element).find('.three-state.checkbox-container');  
                    threeStateCheckboxModule(window,jQuery,checkbox_container);
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
                    inputUrl    : thisTab.find('textarea[name="content-url"]').val(),
                    linkParam   : thisTab.find('input[name="link_param"]').val(),
                    isFree      : thisTab.find('input[name="is_free"]').is(":checked"),
                    type        : thisTab.find('input[name="link_type"]').val(),
                }
            };


            const _addContent = () => {

                if (inputText.val() == ""){
                    toastr['error'](`Content text cannot be empty!`);
                    return false;
                }

                if(inputUrl.val() == "") {
                    toastr['error'](`Content url cannot be empty!`);
                    return false;
                }else{
                    if(!isValidHttpUrl(inputUrl.val())){
                        toastr['error'](`Invalid URL !`);
                        return false;
                    }
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
                inputLinkType.switch2Other();
            };


            const _updateContentFieldVal = (contentJson) => {
                contentJsonStr = JSON.stringify(contentJson, null, 4);

                if(form.find($("input[name=contentJson]")).length === 0){
                    $("<input>").attr({
                        name: "contentJson",
                        id: "contentJson",
                        type: "hidden",
                        value: contentJsonStr
                    }).appendTo("#course-add-form");
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
                    var type = $(li_item).find('.cc-type').html()

                    var infoObj = {
                            inputText   : $(li_item).find('.cc-link').html(),
                            inputUrl    : $(li_item).find('.cc-link').attr('href'),
                            linkParam   : $(li_item).find('.cc-param').html(),
                            isFree      : is_Free,
                            type        : type,
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
                var _linkParam   = parent_li_item.children('.txt-div').find('.cc-param').html();
                var _isFree      = (parent_li_item.children('.txt-div').find('.cc-price').html()=='Free')?'check':'uncheck';
                var _type        = parent_li_item.children('.txt-div').find('.cc-type').html();

                parent_li_item.find('input[name="content-text"]').val(_inputText);
                parent_li_item.find('textarea[name="content-url"]').val(_inputUrl);
                parent_li_item.find('textarea[name="content-url"]').addClass('_inputUrl');
                parent_li_item.find('input[name="link_param"]').val(_linkParam);
                parent_li_item.find('input[name="is_free"]').iCheck(_isFree);
                
                // change 3 stste checkbox
                var elex = parent_li_item.find('.three-state.checkbox-container').find('.three-state-checkbox');
                if(_type == 'video'){
                    elex.trigger('video');
                }else if(_type == 'download'){
                    elex.trigger('download');
                }else{
                    elex.trigger('other');
                }

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
                var _inputUrl    = parent_li_item.find('textarea[name="content-url"]').val();
                var _linkParam   = parent_li_item.find('input[name="link_param"]').val();
                var _isFree      = (parent_li_item.find('input[name="is_free"]').is(":checked")==true)?'Free':'Paid';
                var _type        = parent_li_item.find('input[name="link_type"]').val();

                if (_inputText == ""){
                    thisTab.find(".msg-div").text("content text cant be empty!");
                    return false;
                }

                if(_inputUrl == ""){
                    thisTab.find(".msg-div").text("Content url cant be empty!");
                    return false;
                }else{
                    if(!isValidHttpUrl(_inputUrl)){
                        thisTab.find(".msg-div").text(`Invalid URL !`);
                        return false;
                    }
                }

                parent_li_item.find('.cc-link').html(_inputText);
                parent_li_item.find('.cc-link').attr("href", _inputUrl);
                parent_li_item.find('.cc-param').html(_linkParam);
                parent_li_item.find('.cc-price').html(_isFree);
                parent_li_item.find('.cc-type').html(_type);


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
                getContentByTopic,
                //_resetInputForm,
                //_getContents
                addEmptyContent,
                arrangContentArrByTopics,
                checkSelectedTopic
            };

        });

    </script>
@stop
