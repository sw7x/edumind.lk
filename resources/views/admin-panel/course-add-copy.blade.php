@extends('admin-panel.layouts.master')
@section('title','404')

@section('css-files')
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin/plugins/summernote-0.8.18/summernote-bs4.css')}}">
    <!-- <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">-->

    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

    <link rel='stylesheet' href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/filepond/dist/filepond.min.css'>
@stop



@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">

                    <!--
                    Course name
                    Subject
                    Teacher
                    small-desc
                    desc

                    image

                    Price
                    Duration
                    Videos






                    -->
                    <h3>Add new course</h3>

                    <form class="" id="" action="" method="POST">

                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8"><input type="text" name="teacher-name" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Subject</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b" id="teacher-gender" name="teacher-gender">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Teacher</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b" id="teacher-gender" name="teacher-gender">
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
                                                          cols="30" rows="7" placeholder="Message" autocomplete="off"></textarea>
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
                                <input type="file" class="form-control" name="teacher-profile-img">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>










                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Duration</label>
                            <div class="col-sm-8"><input type="text" name="video-duration" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Videos</label>
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


    <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src='https://unpkg.com/filepond/dist/filepond.min.js'></script>
@stop

@section('javascript')
<script>
    $(document).ready(function() {

    });
</script>
@stop
