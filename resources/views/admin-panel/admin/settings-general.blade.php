@extends('admin-panel.layouts.master',['title' => 'General settings'])
@section('title','General settings')




@section('css-files')
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- bootstrap datapicker -->
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond-plugin-image-preview.min.css')}}">
    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond.min.css')}}">
    
    <!-- Switchery -->
    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">
@stop




@section('content')

    <div class="row" id="_sortable-view">
        <div class="col-lg-12">

            <div class="ibox">
                <div class="ibox-content">
                    <form class="general-settings" method="post" action="">                        
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
                    
                        <fieldset class="p-3 border-solid border-1 border-gray-700 mb-5">
                            <legend class="font-bold rounded col-sm-3 text-xl py-1 border-gray-500 border-1">
                                <p class="text-center">Contact details</small></p>
                            </legend>
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Phone number <span class="text-red-500 text-sm font-bold">*</span></label>
                                <div class="col-sm-8">
                                    <input type="tel" class="form-control" name="phone" required value="{{old('phone')}}">
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>



                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="email" required value="{{old('email')}}">
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Address <span class="text-red-500 text-sm font-bold">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="address" required value="{{old('address')}}">
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                        </fieldset>



                        <fieldset class="p-3 border-solid border-1 border-gray-700 mb-5">
                            <legend class="font-bold rounded col-sm-3 text-xl py-1 border-gray-500 border-1">
                                <p class="text-center">Social links</small></p>
                            </legend>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Facebook <span class="text-red-500 text-sm font-bold">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="facebook" required value="{{old('facebook')}}">
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Twitter <span class="text-red-500 text-sm font-bold">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="twitter" required value="{{old('twitter')}}">
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>


                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Instagram <span class="text-red-500 text-sm font-bold">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="instagram" required value="{{old('instagram')}}">
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="p-3 border-solid border-1 border-gray-700 mb-5">
                            <legend class="font-bold rounded col-sm-3 text-xl py-1 border-gray-500 border-1">
                                <p class="text-center">Logo</p>
                            </legend>
                            <div class="form-group row"><label class="col-sm-4 col-form-label">Site Logo</label>
                                <div class="col-sm-8">
                                    {{--                                        <input type="file" class="form-control" name="subject_image">--}}
                                    <input type="file"
                                           class="filepond-img"
                                           name="logo"
                                           accept="image/webp, image/png, image/jpeg, image/gif"
                                           data-max-file-size="1MB"/>
                                    <div class="text-right text-red-500">Image Size 630X820</div>
                                </div>
                            </div>
                        </fieldset>                        
                        
                              
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

    <!-- Switchery -->
    <script src="{{asset('admin/js/plugins/switchery/switchery.js')}}"></script>
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



        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
          var switchery = new Switchery(html);
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


