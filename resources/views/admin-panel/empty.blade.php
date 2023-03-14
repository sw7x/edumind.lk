@extends('admin-panel.layouts.master',['title' => 'Empty'])
@section('title','Empty')




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




@section('page-css')
    <style>
        .custom-checkbox-form-group input {
          padding: 0;
          height: initial;
          width: initial;
          margin-bottom: 0;
          display: none;
          cursor: pointer;
        }

        .custom-checkbox-form-group label {
          position: relative;
          cursor: pointer;
          
          margin-bottom: 0px;
        }

        .custom-checkbox-form-group label:before {
          content:'';
          -webkit-appearance: none;
          background-color: transparent;
          border: 2px solid #fff;
          box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
          padding: 8px;
          display: inline-block;
          position: relative;
          vertical-align: middle;
          cursor: pointer;
          margin-right: 15px;
        }

        .custom-checkbox-form-group label span{
            top: 2px;
            position: relative;
            font-size: 14px;
        }

        .custom-checkbox-form-group input:checked + label:after {
            content: '';
            display: block;
            position: absolute;
            top: 1px;
            left: 8px;
            width: 5px;
            height: 14px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }






        /*https://codepen.io/nikkz/pen/BzVBJo?editors=1100*/
        .nikko-aboy-checkbox-container{
            /*padding: 50px;*/
        }

        .nikko-aboy-checkbox-container .checkbox {
            display: block;
            margin-bottom: 15px;
        }

        .nikko-aboy-checkbox-container .checkbox input {
            padding: 0;
            height: initial;
            width: initial;
            margin-bottom: 0;
            display: none;
            cursor: pointer;
        }

        .nikko-aboy-checkbox-container .checkbox label {
            position: relative;
            cursor: pointer;
            width: 10px;
        }

        .nikko-aboy-checkbox-container .checkbox label:before {
            content:'';
            -webkit-appearance: none;
            background-color: transparent;
            border: 2px solid #0079bf;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
            padding: 10px;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            cursor: pointer;
            margin-right: 5px;
        }

        .nikko-aboy-checkbox-container .checkbox input:checked + label:after {
            content: '';
            display: block;
            position: absolute;
            top: 3px;
            left: 9px;
            width: 6px;
            height: 14px;
            border: solid #0079bf;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
@stop


@section('content')

    <div class="row" id="_sortable-view">
        <div class="col-lg-12">

            @if(Session::has('message'))
                <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                    <p>{{ Session::get('message') ?? 'Info!' }}</p>
                    <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                </div>
            @endif


            

            <div class="ibox">
                <div class="ibox-content">
                                


                                <div class="nikko-aboy-checkbox-container">                
                                    <div class="checkbox">
                                        <input type="checkbox" id="html">
                                        <label for="html">HTML</label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" id="css">
                                        <label for="css"></label>
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" id="javascript">
                                        <label for="javascript">Javascript</label>
                                    </div>                
                                </div>



                                <table class="table table-condensed border-2">
                                    <tbody>
                                        <tr class="">
                                            <td>
                                                <?php 
                                                $arr = [
                                                    'DDE123','CSS','HTML','JAVA','Javascript',
                                                    'HTML','DDE123','CSS','JAVA','Javascript',
                                                    'CSS','HTML','JAVA','Javascript','DDE123',
                                                    'HTML','JAVA','Javascript','ABC123','FFF56',
                                                    'JAVA','ABC123','FFF56','DDE123','CSS'
                                                ];
                                                for ($x = 0; $x < 20; $x+=1): ?>
                                                <span class="custom-checkbox-form-group">
                                                    <span class="label label-primary mr-3 mb-2 inline-block pt-1 pb-2 pl-2 pr-4">
                                                        <input type="checkbox" id="Javascript<?= $x ?>">
                                                        <label for="Javascript<?= $x ?>">
                                                            <span><a href="hhh" target="_blank"><?= $arr[$x] ?></a></span>
                                                        </label>
                                                    </span>
                                                </span>
                                                <?php endfor;  ?>
                                            </td>
                                        </tr>                                            
                                    </tbody>
                                </table>




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


