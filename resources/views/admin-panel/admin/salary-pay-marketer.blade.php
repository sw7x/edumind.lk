@extends('admin-panel.layouts.master',['title' => 'Pay marketer salary'])
@section('title','Pay marketer salary')


@section('css-files')
    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond-plugin-image-preview.min.css')}}">
    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond.min.css')}}">


    <!-- Date Range Picker CSS file-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/plugins/daterangepicker/css/daterangepicker.css')}}" />


@stop


@section('page-css')
    <style>


    </style>
@stop




@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            @if(Session::has('message'))
                <x-flash-message  
                    :class="Session::get('cls', 'flash-info')"  
                    :title="Session::get('msgTitle') ?? 'Info!'" 
                    :message="Session::get('message') ?? ''"  
                    :message2="Session::get('message2') ?? ''"  
                    :canClose="true" />
            @endif

            <!-- content -->
            <div class="ibox ">
                <div class="ibox-content px-3">

                    <form class="edit-user-form" id="add-subject" action="{{route('admin.subject.store')}}" method="POST">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select Teacher <span class="text-red-500 text-sm font-bold">*</span></label>
                            <div class="col-sm-8">
                                <select class="form-control m-b" name="beneficiary">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>



                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Time period <span class="text-red-500 text-sm font-bold">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" name="daterange" class="p-0 px-2 py-1 form-control text-center text-lg"/>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Enrollments</label>
                            <div class="col-sm-8">
                                <div class="p-1 border-1 mb-1">
                                    <table class="table table-striped table-bordered mb-0">
                                        <thead  class="thead-dark">
                                            <tr>
                                                <th></th>
                                                <th>Enrollement </th>
                                                <th>Comission</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input class="iCheck" type="checkbox" value="" name="is_free">
                                                </td>
                                                <td class="font-bold text-base"><a href="hhh" target="_blank">ABC123 <i class="ml-1 fa fa-external-link" aria-hidden="true"></i></a></td>
                                                <td class="font-bold text-base text-red-500">RS 2000</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <input class="iCheck" type="checkbox" value="" name="is_free">
                                                </td>
                                                <td class="font-bold text-base"><a href="hhh" target="_blank">CCC123 <i class="ml-1 fa fa-external-link" aria-hidden="true"></i></a></td>
                                                <td class="font-bold text-base text-red-500">RS 2000</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <input class="iCheck" type="checkbox" value="" name="is_free">
                                                </td>
                                                <td class="font-bold text-base"><a href="hhh" target="_blank">FBC173 <i class="ml-1 fa fa-external-link" aria-hidden="true"></i></a></td>
                                                <td class="font-bold text-base text-red-500">RS 2500</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-base text-red">Amount for selected enrollemens : RS 200</div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Amount (Rs) <span class="text-red-500 text-sm font-bold">*</span></label>
                            <div class="col-sm-8"><input type="text" name="amount" class="form-control" required="required"></div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Remarks</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="remarks"
                                            cols="30" rows="7" placeholder="" autocomplete="off"></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Salary slip image <span class="text-red-500 text-sm font-bold">*</span></label>
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



    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-encode.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-size.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-exif-orientation.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-preview.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-type.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('admin/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/plugins/daterangepicker/js/daterangepicker.min.js')}}"></script>
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


        $('input.iCheck').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });


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

