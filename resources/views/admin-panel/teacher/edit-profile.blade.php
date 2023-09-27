@extends('admin-panel.layouts.master',['title' => 'Teacher profile edit'])
@section('title','Teacher profile edit')




@section('css-files')
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- bootstrap datapicker -->
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond-plugin-image-preview.min.css')}}">
    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond.min.css')}}">
@stop




@section('content')

    <div class="row" id="_sortable-view">
        <div class="col-lg-12">

            @if(Session::has('message'))
                <x-flash-message  
                    :class="Session::get('cls', 'flash-info')"  
                    :title="Session::get('msgTitle') ?? 'Info!'" 
                    :message="Session::get('message') ?? ''"  
                    :message2="Session::get('message2') ?? ''"  
                    :canClose="true" />
            @endif

            
            <div class="ibox">
                <div class="ibox-content">
                    <form class="teacher-profile-edit" method="post" action="">
                        
                        @if (count($errors) > 0)
                            <x-flash-message 
                                style="margin-bottom:0px;"
                                class="flash-danger rounded-none"  
                                title="Form submit error!" 
                                message=""  
                                message2=""  
                                :canClose="true" >
                                <x-slot name="insideContent">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-sm ml-3">{{ $error }}</li>
                                        @endforeach
                                    </ul>    
                                </x-slot>    
                            </x-flash-message>
                        @endif

                        @if(Session::has('message'))
                            <x-flash-message  
                                :class="Session::get('cls', 'flash-info').' rounded-none'"  
                                :title="Session::get('msgTitle') ?? 'Info!'" 
                                :message="Session::get('message') ?? ''"  
                                :message2="Session::get('message2') ?? ''"  
                                :canClose="true" />
                        @endif

                        <div class="text-right mb-4"><span class="font-bold text-red-500 text-sm">*</span> - Required Information </div>
                    

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Full Name <span class="text-red-500 text-sm font-bold">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="full_name" required minlength="3" maxlength="100" value="{{old('full_name')}}">
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8 col-form-label">
                                <!-- <input type="text" class="form-control" name="username" disabled value="lasantha50"> -->
                                <p class="form-control-static">lasantha50</p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8 col-form-label">
                                <p class="form-control-static">email@example.com</p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                            <div class="col-sm-8">
                                <input value="{{old('phone')}}" type="text" class="form-control" name="phone" required>
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                            <div class="col-sm-8">
                                <select class="selectpicker form-control" name="gender" id="gender">
                                    <option></option>
                                    <option value="male">Male</option>
                                    <option {{ old('gender') == 'female' ? "selected" : "" }} value="female">Female</option>                                    
                                </select>
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Date of birth (Year) <span class="text-red-500 text-sm font-bold">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control px-3" name="teacher_birth_year" required>
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Profile picture</label>
                            <div class="col-sm-8">
                                <input type="file" class="filepond-img" name="profile_pic"
                                           accept="image/webp, image/png, image/jpeg, image/gif"
                                           data-max-file-size="1MB"/>
                               <div class="text-right text-red-500"><small>Image Size 630X820</small></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>   


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Education Details</label>
                            <div class="col-sm-8">
                                <textarea name="edu_qualifications" cols="30" rows="7" class="form-control" placeholder="" autocomplete="off">{{old('edu_qualifications')}}</textarea>
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-4">
                                <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                <button class="form-reset btn btn-danger btn-sm" type="reset">Cancel</button>
                            </div>
                        </div>
                              
                        {{csrf_field ()}}                    
                    </form>            
                </div>
            </div>
        
        </div>
    </div>





@stop




@section('script-files')
    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>

    <!-- Data picker -->
    <script src="{{asset('admin/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>

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




        $('[name="teacher_birth_year"]').datepicker({
            autoclose: true,
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years",
            endDate: '+0d',
            startDate: '-99y',
        });
        @if(old('teacher_birth_year'))
            $("[name='teacher_birth_year']").datepicker("update", '{{old('teacher_birth_year')}}');
        @endif


        $("#gender").select2({
            placeholder: "Select the gender",
            allowClear: true,
            width: '100%'
        });

    })();

    // Select the file input and use create() to turn it into a pond
    const pond = FilePond.create(document.querySelector('.filepond-img'));

    //form reset
    $('button.form-reset').on( "click", function(event) {        
        $(this).closest('form').trigger('reset');
        event.preventDefault();
        
        if(typeof pond !== 'undefined'){
            pond.removeFile();
        }        
    });
</script>
@stop


