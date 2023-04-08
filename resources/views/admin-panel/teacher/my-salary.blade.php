
@extends('admin-panel.layouts.master',['title' => 'My salary(t)'])
@section('title','My salary')


@section('css-files')
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">

    <!-- sweetalert2 CSS file
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">-->
    
    <!-- Date Range Picker CSS file-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/plugins/daterangepicker/css/daterangepicker.css')}}" />
@stop

@section('page-css')
    
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

            <div class="ibox">
                <div class="ibox-content">

                    <div class="px-3 row mb-3" id="">
                        <div class="offset-md-6 col-md-6 px-0">
                            <div class="text-center"><h3> Date range select:</h3></div>
                            <div class="earnings-daterange input-daterange input-group" id="datepicker">
                                <input type="text" name="daterange" class="p-0 px-2 py-1 form-control text-center text-lg"/>
                            </div>
                        </div>
                    </div>
                   
                    <div class="table-responsive">
                        <table id="coupon-code-list-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Slip ID</th>
                                    <th>paysheet image</th>
                                    <th>Time period</th>
                                    <th>Amount (Rs)</th>                                    
                                </tr>
                            </thead>

                            <tbody>
                                <?php                           
                                for ($x = 0; $x <= 100; $x+=1): ?>
                                <tr>
                                    <td></td>
                                    <td>SS123</td>  
                                    <td>
                                        @if($x != '')
                                            <a class="no-clickable popup-img effect" href="{{asset('images/salary-slip.jpg')}}" data-effect="mfp-zoom-in">
                                                {{--<img src="{{URL('/')}}/storage/--" width="100px" alt="">--}}
                                                <img src="{{asset('images/salary-slip.jpg')}}" width="200px" alt="">
                                            </a>
                                        @endif
                                    </td>
                                    <td>2022/01/16 to 2022/07/16</td>
                                    <td>5000</td>
                                </tr>
                                <?php endfor;  ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Slip ID</th>
                                    <th>paysheet image</th>
                                    <th>Time period</th>
                                    <th>Amount (Rs)</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
@stop



@section('script-files')

    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>

    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Magnific Popup core JS file -->
    <script src="{{asset('admin/js/jquery.magnific-popup.min.js')}}"></script>

    <!-- sweetalert2 js file
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>-->

    <script type="text/javascript" src="{{asset('admin/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/plugins/daterangepicker/js/daterangepicker.min.js')}}"></script>
@stop


@section('javascript')
<script>



    $(document).ready(function() {

        $('a.popup-img').magnificPopup({
			type: 'image',
			closeBtnInside: true,
			closeOnContentClick: true,
			tLoading: '', // remove text from preloader
			fixedContentPos : false,
			/* don't add this part, it's just to disable cache on image and test loading indicator */
			callbacks: {
				beforeChange: function() {
					this.items[0].src = this.items[0].src + '?=' + Math.random();
				},
				beforeOpen: function() {
					this.st.mainClass = this.st.el.attr('data-effect');
				},
				open: function() {
					jQuery('body').addClass('noscroll');
				},
				close: function() {
					jQuery('body').removeClass('noscroll');
				}
			},
			//removalDelay: 500, //delay removal by X to allow out-animation
			mainClass: 'mfp-with-fade',
		});







        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            /*return (
                '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Full name:</td>' +
                '<td>' +
                d.name +
                '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Extension number:</td>' +
                '<td>' +
                d.extn +
                '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Extra info:</td>' +
                '<td>And any further details here (images etc)...</td>' +
                '</tr>' +
                '</table>');*/


            return (`

            <div class="table-detail-content ml-3">                    
                <ul class="mb-3">
                    <li>
                        <div class="detail"></div>
                        <div class="detail detail-main">
                            <fieldset>
                                <div class="p-1">
                                    <table class="table table-striped table-bordered mb-0">
                                        <thead  class="thead-dark">
                                            <tr>
                                                <th>Enrollement </th>
                                                <th>Course Fee</th>
                                                <th>Comission</th>
                                                <th class="font-bold text-base text-red-500">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="font-bold text-base"><a href="hhh" target="_blank">ABC123 <i class="ml-1 fa fa-external-link" aria-hidden="true"></i></a></td>
                                                <td>RS 1000</td>
                                                <td>RS 1000</td>
                                                <td class="font-bold text-base text-red-500">RS 2000</td>
                                            </tr>

                                            <tr>
                                                <td class="font-bold text-base"><a href="hhh" target="_blank">CCC123 <i class="ml-1 fa fa-external-link" aria-hidden="true"></i></a></td>
                                                <td>RS 2000</td>
                                                <td>RS 0</td>
                                                <td class="font-bold text-base text-red-500">RS 2000</td>
                                            </tr> 

                                            <tr>
                                                <td class="font-bold text-base"><a href="hhh" target="_blank">FBC173 <i class="ml-1 fa fa-external-link" aria-hidden="true"></i></a></td>
                                                <td>RS 500</td>
                                                <td>RS 2000</td>
                                                <td class="font-bold text-base text-red-500">RS 2500</td>
                                            </tr>
                                        </tbody>
                                    </table>                    
                                </div>
                            </fieldset>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Remarks</label>
                                <div class="col-sm-9">
                                    <p class="text-base font-bold">Note that you can also use other methods provided by the Carbon library to perform other types of date calculations, such as adding or subtracting days, weeks, months, years, etc.</p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>             
            </div>
            `);
        }





        var table = $('#coupon-code-list-tbl').DataTable({
            //ajax: './ajax.txt',
            columns: [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                { data: 'slip_id' },                
                { data: 'paysheet_image' },
                { data: 'time_period' },
                { data: 'amount' },           
            ],            
            //order: [[1, 'asc']],
            "ordering": false,
            pageLength: 10,
            responsive: true,
            // dom: '<"html5buttons"B>lTfgitp',
            //dom: 'Bfrtip',
            lengthChange: false,
        });

        // Add event listener for opening and closing details
        $('#coupon-code-list-tbl tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);


            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                console.log(row.data());
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });

        $("#coupon-code-list-tbl thead tr").css("border-bottom","5px solid #000");





        


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


        

    });

</script>
@stop