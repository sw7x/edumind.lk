@extends('admin-panel.layouts.master',['title' => 'Course Earnings'])
@section('title','Course earnings')

@section('css-files')

    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">

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
        padding: 11px 12px;
    }

</style>
@stop

@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">

                        

                    <div class="px-3 row mb-3" id="">
                        
                        <div class="col-md-5">
                            <div class="text-center text-sm px-2 py-1 mb-1">Select course</div>
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

                        <div class="offset-sm-2 col-md-5 ">
                            <div class="text-center text-sm px-2 py-1 mb-1">Select date range</div>
                            <div class="course-earning-daterange input-daterange input-group" id="datepicker">
                                <input type="text" class="_form-control-sm form-control" name="start" value="2021/01/01"/>
                                <span class="input-group-addon px-3"> to </span>
                                <input type="text" class="_form-control-sm form-control" name="end" value="<?php echo date("Y/m/d"); ?>" />
                            </div>
                        </div>

                    </div>
                    <hr>

                    <div class="table-responsive">
                        <table id="course-earning-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Course</th>
                                <th>Earning</th>
                                <th>Purchased<small>(count)</small></th>
                                <th>Cupons<small>(count)</small></th>
                                <th>Discount<small>(total)</small></th>
                                <th>Teacher</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    314
                                </td>
                                <td>
                                    Customer example
                                </td>
                                <td>
                                    $500.00
                                </td>
                                <td>
                                    <a class="text-lg" href="#"><i class="fa fa-check text-navy"></i></a>
                                </td>
                                <td>
                                    <img src="{{asset('images/category/design.jpg')}}" width="100px" alt="">
                                </td>
                                <td>
                                    <input type="checkbox" class="switch-t-approve" checked />
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button data-toggle="modal" class="btn-white btn btn-xs" href="#modal-t-approve">View</button>
                                        <button class="btn-danger btn btn-xs">delete</button>
                                    </div>
                                </td>
                            </tr>

                            <?php for ($i=0; $i < 23 ; $i++):?>
                            <tr>
                                <td>
                                    315
                                </td>
                                <td>
                                    Customer example
                                </td>
                                <td>
                                    <?php echo '$'.$i*500; ?>                                    
                                </td>
                                <td>
                                    03/04/2015
                                </td>
                                <td>
                                    03/04/2015
                                </td>
                                <td>
                                    <input type="checkbox" class="switch-t-approve" checked />
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn-white btn btn-xs">View</button>
                                        <button class="btn-danger btn btn-xs">Delete</button>
                                    </div>
                                </td>
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



        



		$('#course-earning-tbl').DataTable({
			pageLength: 10,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [],
			"columnDefs": [

                //{"targets": [1,2,3,4,5,6],"searchable": false},
                // {  className: "text-right", targets: 6 },
                
                //{ "width": "10%", "targets": 0 },
                //{ "width": "20%", "targets": 1 },
                { "width": "20%", "targets": 2 },
                //{},
                //null,
                //null,
                {  'className': "text-right", targets: 6 },


			],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total = api
                    .column(2)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(2, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(1).footer()).html('Total : ');
                $(api.column(2).footer()).html('$' + pageTotal + ' ( $' + total + ' total)');

                console.log(api.column(2));
            },
			fnDrawCallback:function (oSettings) {
				console.log("after table create");
				var elems = Array.prototype.slice.call(document.querySelectorAll('.switch-t-approve'));

				elems.forEach(function(html) {
					//need to check that it has not already be instantiated.
					if(!html.getAttribute('data-switchery')){
						var switchery = new Switchery(html, { size: 'small' });
					}
					html.onchange = function () {
						console.log("on click");
						var checked = html.checked;
						var id = $(html).attr('bid');
						if (checked == false) {
							checked = 2;
						} else {
							checked = 1;
						}
						//todo
						//changeBannerState(id, checked);
					}
				});
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
</script>
@stop
