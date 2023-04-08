@extends('admin-panel.layouts.master',['title' => 'Course Earnings'])
@section('title','Course earnings')

@section('css-files')
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- bootstrap datapicker -->
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@stop

@section('page-css')
<style type="text/css">
    .select2-selection__rendered {
        line-height: 31px !important;
    }
    .select2-container .select2-selection--single {
        height: 35px !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
    }

    .course-earning-daterange .form-control{
        padding: 10px 12px;
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

            <div class="ibox">
                <div class="ibox-content">

                    // test drodown cancel    
                    <div class="row mb-3" id="">                        
                        <div class="col-md-5">
                            <div class="text-center text-base px-2 py-1 mb-1 font-semibold">Course</div>
                            <div class="input-group" id="">
                                <select class="m-b" id="course" name="course" multiple="multiple">
                                    <option> </option>
                                    <option value="all">All</option>                                               
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="iii">Three</option>
                                    <option value="4">Four</option>                                                
                                </select>
                            </div>
                        </div>
                        <div class="offset-sm-1 col-md-6">
                            <div class="text-center text-base px-2 py-1 mb-1 font-semibold">Date range</div>
                            <div class="course-earning-daterange input-daterange input-group" id="datepicker">
                                <input type="text" class="__form-control-sm form-control" name="start" value="2021/01/01"/>
                                <span class="input-group-addon px-3"> to </span>
                                <input type="text" class="__form-control-sm form-control" name="end" value="<?php echo date("Y/m/d"); ?>" />
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="table-responsive">
                        
                        <table id="course-earning-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Course</th>
                                    <th>Original price</th>
                                    <th>Order ID <br><small>(Enrollement)</small></th>                                    
                                    <th>Order <br>Date/time</th>
                                    <th class="bg-primary">Total <br>claimed Amount Rs</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php for ($i=0; $i < 23 ; $i++):?>
                                <tr>
                                    <td></td>
                                    <td>Course<?php echo $i; ?></td>
                                    <td>Rs 5000</td>
                                    <td>ADF123</td>                                    
                                    <td>03/04/2015</td>
                                    <td class="table-success"><?php echo $i.'000.00'; ?></td>                                    
                                </tr>
                                <?php endfor;?>
                            </tbody>

                            <tfoot>
                                <tr>
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

        </div>
    </div>


@stop




@section('script-files')

    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>


    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Switchery -->
    <script src="{{asset('admin/js/plugins/switchery/switchery.js')}}"></script>



    <!-- Data picker -->
    <script src="{{asset('admin/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>


@stop


@section('javascript')
<script>






    $('#course').on('change', function () {
        console.log();

        //var val     = $(this).val();
        //var values  = new Array();

        
        /*$('#course').find('option').each(function () {
            var opt     = $(this);
            var opvalue = opt.attr('value');
            if(opvalue != "all")
                values.push(opvalue);
        });

        //alert(val);
        if(val.indexOf('all') != -1){
            $('#course').select2('val', values);
        }
        else{
            $('#course').select2('val', val);
        }*/
    });



	$(document).ready(function() {


        $("#course").select2({
            placeholder: "Select course",
            allowClear: true,
            width: '100%'
        });


        $('.fav_clr').on("select2:select", function (e) {           
            if(data=='all'){
                $(".fav_clr > option").prop("selected","selected");
                $(".fav_clr").trigger("change");
            }
        });


        $(document.body).on("select2:select select2:unselect","#course",function(e){
            //console.log($(this));
            var data    = e.params.data.id;    
            var val     = $(this).val();
            var values  = new Array();

            if(data=='all'){
                $(this).find('option').each(function (index, element) {
                    var opt     = $(element);
                    var opvalue = opt.attr('value');
                    if(opvalue != "all" && typeof opvalue !== 'undefined')
                        values.push(opvalue);
                });
            }

            //console.log(values);

            if(val.indexOf('all') != -1){
                $(this).select2('val', values);
            }
            else{
                $(this).select2('val', val);
            }

            //console.log($(this).val());    
        });

        



		var table = $('#course-earning-tbl').DataTable({
			pageLength: 10,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [],
            columns: [
                {
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                { data: 'course' },
                { data: 'course price' },
                { data: 'order' },
                { data: 'order-date-time' },
                { data: 'claimed Amount' },
            ],			
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total = api
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(5, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(4).footer()).html('Total : ');
                $(api.column(5).footer()).html('Rs ' + pageTotal + ' ( Rs ' + total + ' total)');

                console.log(api.column(5));
            }			
		});

        // Add event listener for opening and closing details
        $('#course-earning-tbl tbody').on('click', 'td.dt-control', function () {
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


		$('.course-earning-daterange').datepicker({
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,

			///startView: 2,
			todayBtn: "linked",
			format: 'yyyy-mm-dd',
			endDate: '+0d',
			autoclose: true
		});








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
                            <div>
                                <table class="table table-condensed">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>teacher</th>
                                            <th>coupon code</th>
                                            <th>coupon code discount %</th>
                                            <th>Student</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="">
                                            <td>A.B.C Saman Fernando</td>
                                            <td>EFD123</td>
                                            <td>10%</td>
                                            <td>A.B.C Vikum Amaraweera</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </li>
            </ul>                
            <div class="mb-4 w-3/4 ml-3 border">                    
                <table class="w-full">
                    <tr>
                        <td>Course original price</td>
                        <td>RS 6000.00</td>
                    </tr>                       
                    
                    <tr>
                        <td>Edumind share from course fee</td>
                        <td>60%</td>
                    </tr>
                    <tr class="text-red-600 font-bold text-lg">
                        <td>Edumind earn amount from course fee</td>
                        <td>RS 3240.00 = (6000*60%)</td>
                    </tr>
                </table>                    
            </div>
            <div class="mb-4 w-3/4  ml-3 border">
                <table class="w-full">
                    <tr>
                        <td>Course original price</td>
                        <td>RS 6000.00</td>
                    </tr>
                    <tr>
                        <td>Coupon code discount %</td>
                        <td>10%</td>
                    </tr>
                    <tr>
                        <td>Coupon code discount amount</td>
                        <td>RS 600.00 = (6000*10%)</td>
                    </tr>                       
                    <tr>
                        <td>Marketer/Teacher share from discount</td>
                        <td>80%</td>
                    </tr>
                    <tr>
                        <td>Edumind share from discount</td>
                        <td>20%</td>
                    </tr>                       
                    <tr class="">
                        <td>Marketer/Teacher commission from coupon code discount</td>
                        <td>RS 600.00 = (600*80%)</td>
                    </tr>
                    <tr class="text-red-600 font-bold text-lg">
                        <td>Edumind lose Amount due to coupon code use</td>
                        <td>RS 600.00 = 600*(200% - 20%)</td>
                    </tr>                                       
                </table>
            </div>
        </div>
        `);
    }
</script>
@stop
