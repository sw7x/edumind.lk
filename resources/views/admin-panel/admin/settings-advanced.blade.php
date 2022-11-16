@extends('admin-panel.layouts.master',['title' => 'Advanced settings'])
@section('title','Advanced settings')




@section('css-files')
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- bootstrap datapicker -->
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <link rel='stylesheet' href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/filepond/dist/filepond.min.css'>
    
    <!-- Switchery -->
    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">
@stop




@section('content')

    <div class="row" id="_sortable-view">
        <div class="col-lg-12">

            <div class="ibox">
                <div class="ibox-content">                                    

                    <form class="advanced-settings" method="post" action="">
                        
                        @if (count($errors) > 0)
                            <div class="flash-msg flash-danger rounded-none" style="margin-bottom:0px;">
                                <a href="#" class="close">×</a>
                                <div class="text-lg"><strong>Form submit error!</strong></div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm ml-3">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(Session::has('message'))
                            <div class="flash-msg {{ Session::get('cls', 'flash-info')}}  rounded-none">
                                <a href="#" class="close">×</a>
                                <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                                <p>{{ Session::get('message') ?? 'Info!' }}</p>
                                <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                            </div>
                        @endif

                        <div class="text-right mb-4"><span class="font-bold text-red-500 text-sm">*</span> - Required Information </div>
                                            
                        
                        <fieldset class="p-3 border-solid border-1 border-gray-700 mb-5">
                            <legend class="font-bold rounded col-sm-3 text-xl py-1 border-gray-500 border-1">
                                <p class="text-center">Subject</p>
                            </legend>                        
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Subject changes need to approve <span class="text-red-500 text-sm font-bold">*</span></label>
                                <div class="col-sm-8">
                                    <span class="mr-1 text-gray-400 text-xs font-bold">No</span>
                                    <input type="checkbox" class="js-switch" checked />
                                    <span class="ml-1 text-green-500 text-xs font-bold">Yes</span> 
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>                  
                        </fieldset>

                        
                        <fieldset class="p-3 border-solid border-1 border-gray-700 mb-5">
                            <legend class="font-bold rounded col-sm-3 text-xl py-1 border-gray-500 border-1">
                                <p class="text-center">Course</p>
                            </legend>                       
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Course changes need to approve <span class="text-red-500 text-sm font-bold">*</span></label>
                                <div class="col-sm-8">
                                    <span class="mr-1 text-gray-400 text-xs font-bold">No</span>
                                    <input type="checkbox" class="js-switch" checked />
                                    <span class="ml-1 text-green-500 text-xs font-bold">Yes</span> 
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Course creation need to approve <span class="text-red-500 text-sm font-bold">*</span></label>
                                <div class="col-sm-8">
                                    <span class="mr-1 text-gray-400 text-xs font-bold">No</span>
                                    <input type="checkbox" class="js-switch" checked />
                                    <span class="ml-1 text-green-500 text-xs font-bold">Yes</span> 
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Need to enroll - watch free courses  :</label>
                                <div class="col-sm-8">
                                    <span class="mr-1 text-gray-400 text-xs font-bold">No</span>
                                    <input type="checkbox" class="js-switch" checked />
                                    <span class="ml-1 text-green-500 text-xs font-bold">Yes</span> 
                                    <div class="error-msg"></div>
                                </div>
                            </div>          
                        </fieldset>

                        
                        <fieldset class="p-3 border-solid border-1 border-gray-700 mb-5">
                            <legend class="font-bold rounded col-sm-3 text-xl py-1 border-gray-500 border-1">
                                <p class="text-center">User Accounts</p>
                            </legend>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Teacher Accounts need to approve :</label>
                                <div class="col-sm-8">
                                    <span class="mr-1 text-gray-400 text-xs font-bold">No</span>
                                    <input type="checkbox" class="js-switch" checked />
                                    <span class="ml-1 text-green-500 text-xs font-bold">Yes</span> 
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">User Account changes need to approve :</label>
                                <div class="col-sm-8">
                                    <span class="mr-1 text-gray-400 text-xs  font-bold">No</span>
                                    <input type="checkbox" class="mx-2 js-switch" checked />
                                    <span class="ml-1 text-green-500 text-xs  font-bold">Yes</span>                                    
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                        </fieldset>


                        <fieldset class="p-3 border-solid border-1 border-gray-700 mb-5">
                            <legend class="font-bold rounded col-sm-3 text-xl py-1 border-gray-500 border-1">
                                <p class="text-center">Revenue</p>
                            </legend>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">=== :</label>
                                <div class="col-sm-8">
                                    <span class="mr-1 text-gray-400 text-xs font-bold">No</span>
                                    <input type="checkbox" class="js-switch" checked />
                                    <span class="ml-1 text-green-500 text-xs font-bold">Yes</span> 
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                        </fieldset>


                        <fieldset class="p-3 border-solid border-1 border-gray-700 mb-5">
                            <legend class="font-bold rounded col-sm-3 text-xl py-1 border-gray-500 border-1">
                                <p class="text-center">Salary</p>
                            </legend>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">=== :</label>
                                <div class="col-sm-8">
                                    <span class="mr-1 text-gray-400 text-xs font-bold">No</span>
                                    <input type="checkbox" class="js-switch" checked />
                                    <span class="ml-1 text-green-500 text-xs font-bold">Yes</span> 
                                    <div class="error-msg"></div>
                                </div>
                            </div>                            
                        </fieldset>


                        <fieldset class="p-3 border-solid border-1 border-gray-700 mb-5">
                            <legend class="font-bold rounded col-sm-3 text-xl py-1 border-gray-500 border-1">
                                <p class="text-center">Cupon code</p>
                            </legend>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">=== :</label>
                                <div class="col-sm-8">
                                    <span class="mr-1 text-gray-400 text-xs font-bold">No</span>
                                    <input type="checkbox" class="js-switch" checked />
                                    <span class="ml-1 text-green-500 text-xs font-bold">Yes</span> 
                                    <div class="error-msg"></div>
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

    <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src='https://unpkg.com/filepond/dist/filepond.min.js'></script>

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


