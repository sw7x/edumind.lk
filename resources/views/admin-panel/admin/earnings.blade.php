
@extends('admin-panel.layouts.master',['title' => 'Earnings(ADMIN)'])
@section('title','View Earnings')


@section('css-files')
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- Magnific Popup core CSS file 
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">-->

    <!-- sweetalert2 CSS file
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">-->
    
    <!-- Date Range Picker CSS file-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/plugins/daterangepicker/css/daterangepicker.css')}}" />
@stop

@section('page-css')
    <style>
        .custom-daterangepicker{
            
        }
    </style>
@stop




@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            
            @php
                //dump(Session::get('key111'));                        
            @endphp           
            
            
            @if(isset($message))
                <x-flash-message  
                    :class="$cls ?? 'flash-info'"  
                    :title="$msgTitle ?? 'Info!'" 
                    :message="$message ?? ''"  
                    :message2="$message2 ?? ''"  
                    :canClose="true" />
            @else                    
            @if(isset($data) && is_array($data))                    
                @if(!empty($data))
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
                            @php //dump($data); @endphp
                            
                            <div class="table-responsive">
                                <table id="edumind-earnings-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Total <br>claimed Amount Rs</th>
                                            <th>Invoice ID <br><small>(Enrollement)</small></th>                                    
                                            <th>Enrolled <br>Date/time</th>
                                            <th>Used <br>coupon code</th>
                                            <th>Coupon code <br>discount %</th>
                                            <th>id</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($data as $rec)
                                            @php  
                                                //$rec = $record->toArray(); 
                                            @endphp
                                            <tr>
                                                <td></td>
                                                <td>{{$rec['edumindEarnAmount']}}</td>  
                                                <td>{{$rec['invoiceId']}}</td>
                                                <td>{{$rec['enrolledDateTime']}}</td>
                                                <td>{{$rec['couponCode'] ?? '-'}}</td>
                                                <td>{{$rec['discountPercentage'] ? $rec['discountPercentage'].'%' : '-'}}</td>
                                                <td>{{$rec['id']}}</td>
                                            </tr>
                                        @endforeach                               
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>                                                                       
                                            <th></th>                                    
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>

                        </div>
                    </div>
                @else
                    <x-flash-message 
                        class="flash-info"  
                        title="No Earnings!" 
                        message=""  
                        message2=""  
                        :canClose="false" />
                @endif
            @else                
                <x-flash-message 
                    class="flash-danger"  
                    title="Data not available!" 
                    message="Earnings data is not available or not in correct format"  
                    message2=""  
                    :canClose="false" />                
            @endif
            

            

        </div>
    </div>
@stop



@section('script-files')

    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>

    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Magnific Popup core JS file 
    <script src="{{asset('admin/js/jquery.magnific-popup.min.js')}}"></script>-->

    <!-- sweetalert2 js file
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>-->

    <script type="text/javascript" src="{{asset('admin/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/plugins/daterangepicker/js/daterangepicker.min.js')}}"></script>
@stop


@section('javascript')
<script>

    
    var earningsData = {!! json_encode($data ?? []) !!};
    console.log(earningsData);
    console.log(Array.isArray(earningsData));    
    if(!Array.isArray(earningsData)){ earningsData = []; }






    $(document).ready(function() {

        

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

            console.log(d);
            //console.log('earningsData');
            //console.log(earningsData);
            

            var position = earningsData.findIndex(item => item.id == d.id); 
            //console.log(position);
            console.log(position);
            return (`

            <div class="table-detail-content ml-3">                    
                <ul class="mb-3">
                    <li>
                        <div class="detail"></div>
                        <div class="detail detail-main">
                            <fieldset>
                                <div>
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Course</th>
                                                <th>Teacher</th>
                                                <th>Course original price</th>
                                                <th>Student</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td>${earningsData[position]['course']}</td>
                                                <td>${earningsData[position]['teacher']}</td>
                                                <td>Rs ${earningsData[position]['coursePrice']}</td>
                                                <td>${earningsData[position]['student']}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </li>
                </ul>                
                <div class="mb-4 w-4/5 ml-3 border">                    
                    <table class="w-full">
                        <tr>
                            <td>Course original price</td>
                            <td>Rs 
                                ${earningsData[position]['coursePrice']}
                            </td>
                        </tr>                       
                        
                        <tr>
                            <td>Edumind share from course fee</td>
                            <td>${earningsData[position]['edumindShareFromCoursePrice'] ?? 0}%</td>
                        </tr>
                        <tr class="text-red-600 font-bold text-lg">
                            <td>Edumind earn amount from course fee</td>
                            <td>
                                Rs  ${earningsData[position]['edumindEarnAmountFromCoursePrice']} = (
                                    ${earningsData[position]['coursePrice']} * 
                                    ${earningsData[position]['edumindShareFromCoursePrice'] ?? 0}%
                                )
                            </td>
                        </tr>
                    </table>                    
                </div>
                <div class="mb-4 w-4/5  ml-3 border">
                    <table class="w-full">
                        <tr>
                            <td>Course original price</td>
                            <td>
                                Rs ${earningsData[position]['coursePrice']}
                            </td>
                        </tr>
                        <tr>
                            <td>Coupon code discount %</td>
                            <td>
                                ${
                                    earningsData[position]['discountPercentage']? 
                                    earningsData[position]['discountPercentage']+'%' :
                                    '0% <span class="text-red text-xs">(Not available)</span>'
                                }
                            </td>
                        </tr>
                        <tr>
                            <td>Coupon code discount amount</td>
                            <td>
                                Rs  ${earningsData[position]['discountAmount'] ?? 0} = (
                                    ${earningsData[position]['coursePrice']} * 
                                    ${earningsData[position]['discountPercentage'] ?? 0}%
                                )
                            </td>
                        </tr>                       
                        <tr>
                            <td>Marketer/Teacher share from discount</td>
                            <td>
                                ${
                                    earningsData[position]['beneficiaryShareFromDiscount']? 
                                    earningsData[position]['beneficiaryShareFromDiscount']+'%' :
                                    '0% <span class="text-red text-xs">(Not available)</span>'
                                }
                            </td>
                        </tr>
                        <tr>
                            <td>Edumind share from discount</td>
                            <td>
                                ${
                                    earningsData[position]['edumindShareFromDiscount']? 
                                    earningsData[position]['edumindShareFromDiscount']+'%' :
                                    '0% <span class="text-red text-xs">(Not available)</span>'
                                }
                            </td>
                        </tr>                       
                        <tr class="">
                            <td>Marketer/Teacher commission from coupon code discount</td>
                            <td>Rs  
                                ${earningsData[position]['beneficiaryEarnAmount'] ?? 0} = (
                                    ${earningsData[position]['discountAmount']} * 
                                    ${earningsData[position]['beneficiaryShareFromDiscount'] ?? 0}%
                                )
                            </td>
                        </tr>
                        <tr class="text-red-600 font-bold text-lg">
                            <td>Edumind lose Amount due to coupon code use</td>
                            <td>
                                Rs  ${earningsData[position]['edumindLoseAmount'] ?? 0} = 
                                    ${earningsData[position]['discountAmount']} * 
                                    ( 100% + ${earningsData[position]['beneficiaryShareFromDiscount'] ?? 0}% )
                            </td>
                        </tr>                                       
                    </table>
                </div>                    
                </div>
            </div>
            `);
        }

        






        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }); 
        


        var table = $('#edumind-earnings-tbl').DataTable({
            //ajax: './ajax.txt',

            /* 
            "ajax": {
                "url": '{{route('admin.revenue.all-earnings-records')}}',
                
                //"type": "POST",
                "data": {
                    //_token : '{{ csrf_token() }}',
                    //'csrf_token' : '{{ csrf_token() }}',
                    //csrf_token
                }
                //data: function(data) {
                    // Add CSRF token to the data object
                   //data._token = '{{ csrf_token() }}';
                //}
            },
           



            

            processing: true,
            serverSide: true,
            serverMethod: 'POST',
            */


            columns: [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    "searchable": false
                },/**/
                { data: 'claimed Amount',"searchable": false },                
                { data: 'order',"searchable": true },
                { data: 'enrollment date',"searchable": false },
                { data: 'coupon code',"searchable": true },
                { data: 'coupon code discount precentage',visible: true,"searchable": false },
                { data: 'id',visible: false,"searchable": false },
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total = api
                    .column(1)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(1, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                //rounding to two decimal places
                total       = parseFloat(total).toFixed(2);
                pageTotal   = parseFloat(pageTotal).toFixed(2);

                // Update footer
                //$(api.column(0).footer()).html('Total : ');
                $(api.column(1).footer()).html('Total : Rs ' + pageTotal + '<br>( Rs ' + total + ' total )');

                //console.log(api.column(5));
            },
            //order: [[1, 'asc']],
            "ordering": false,
            pageLength: 10,
            responsive: true,
            // dom: '<"html5buttons"B>lTfgitp',
            //dom: 'Bfrtip',
            lengthChange: false,
        });

        // Add event listener for opening and closing details
        $('#edumind-earnings-tbl tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            console.log('table');
            console.log(table);
            console.log(row.data());
            console.log('_________');


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

        $("#edumind-earnings-tbl thead tr").css("border-bottom","5px solid #000");





        


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