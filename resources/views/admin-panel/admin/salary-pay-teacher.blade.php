@extends('admin-panel.layouts.master',['title' => 'Pay teacher salary'])
@section('title','Pay teacher salary')


@section('css-files')
    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

    <link rel='stylesheet' href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'>
    <link rel='stylesheet' href='https://unpkg.com/filepond/dist/filepond.min.css'>


    <!-- Date Range Picker CSS file-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


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

    </style>
@stop




@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            @if(Session::has('message'))
                <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                    <p>{{ Session::get('message') ?? 'Info!' }}</p>
                    <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                </div>
            @endif

            <!-- content -->
            <div class="ibox ">
                <div class="ibox-content px-3">

                    <form class="edit-user-form" id="add-subject" action="{{route('admin.subject.store')}}" method="POST">

                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Amount (Rs)</label>
                            <div class="col-sm-8"><input type="text" name="amount" class="form-control" required="required"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Time period</label>
                            <div class="col-sm-8">
                                <input type="text" name="daterange" class="p-0 px-2 py-1 form-control text-center text-lg"/>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Enrollments</label>
                            <div class="col-sm-8">
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
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row"><label class="col-sm-4 col-form-label">Salary slip image</label>
                            <div class="col-sm-8">
                                {{--                                        <input type="file" class="form-control" name="subject_image">--}}
                                <input type="file"
                                       class="filepond-img"
                                       name="salary_slip_img"
                                       accept="image/webp, image/png, image/jpeg, image/gif"
                                       data-max-file-size="1MB"/>
                                <p>Image Size 300X350</p>
                            </div>

                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-4">
                                <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                <button class="btn btn-danger btn-sm" type="reset">Cancel</button>
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
    <!-- iCheck -->
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>



    <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
    <script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src='https://unpkg.com/filepond/dist/filepond.min.js'></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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



        $('input[name="daterange"]').daterangepicker({
            //"minYear": 2020,
            //"minYear": 2022,
            //customClass:'hhh7777',
            minDate: new Date('01/01/2022'),
            maxDate: new Date(),
            showDropdowns: true,
            //"maxYear": moment().year(),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "alwaysShowCalendars": true,
            "startDate": new Date('01/01/2022'),
            "endDate": new Date(),
            //"startDate": "10/19/2020",
            //"endDate": "10/25/2022",
            //"endDate": moment(),

            "opens": "center",
            "drops": "auto",
            "buttonClasses": "medium-size btn",
            locale: {
                format: 'YYYY-MM-DD',
                applyLabel: 'Select <br><small>date range</small>',
                cancelLabel: 'Clear <br><small>date range</small>'
            },
            "cancelClass": "btn-danger",
            "applyButtonClasses": "btn-primary",
            //autoUpdateInput: false,
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.addClass('custom-daterangepicker');
        });


        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            picker.setStartDate('01/01/2022');
            picker.setEndDate(new Date());
        });


    })();

    // Select the file input and use create() to turn it into a pond
    const pond = FilePond.create(document.querySelector('.filepond-img'));

</script>
@stop
