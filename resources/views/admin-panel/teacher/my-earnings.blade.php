
@extends('admin-panel.layouts.master',['title' => 'My earnings(t)'])
@section('title','My earnings')

@section('css-files')
	<!-- select2 -->
	<link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Magnific Popup core CSS file 
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">-->

    <!-- sweetalert2 CSS file
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">-->
	
	<!-- Date Range Picker CSS file-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
            <div class="ibox">


                <div class="ibox-content">

                    @if(Session::has('message'))
                        <div class="col-lg-12">
                            <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                                <a href="#" class="close">×</a>
                                <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                                <p>{{ Session::get('message') ?? 'Info!' }}</p>
                                <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                            </div>
                        </div>
                    @endif

					

                    <div>// move last : available = 0</div>
                    <h1 class="font-bold my-1">teacher my earnings</h1>
                   
                    <div class="px-3 row mb-3" id="">
                        <div class="col-md-4 px-0">
                            <div class="text-center"><h3> Date range select:</h3></div>
                            <div class="earnings-daterange input-daterange input-group" id="datepicker">
                                <input type="text" name="daterange" class="p-0 px-2 py-1 form-control text-center text-lg"/>
                            </div>
                        </div>

                        <div class="offset-md-2 col-md-4">
                        </div>
                    </div>

                   
                    <div class="table-responsive">
                        <table id="cupon-code-list-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
							<thead>
								<tr>
									<th></th>
									<th>Enrollment <br>Link</th>									
									<th>Course</th>
									<th>Enrolled <br>Date/time</th>
									<th>Total <br>claimed Amount</th>
									<th>is Paid</th>
									<th>Used <br>cupon code</th>																	
								</tr>
							</thead>

							<tbody>
								<?php							
								for ($x = 0; $x <= 100; $x+=1): ?>
								<tr>
									<td></td>
									<td>ABC<?php echo $x; ?></td>
									<td>Course<?php echo $x; ?></td>
									<td>2022/7/16 06:45 PM</td>
									<td><?php echo 'RS '.$x.'000.00'; ?></td>									
									<td>
                                        @if($x%2 ==0)
                                            <span class="label label-primary">Yes : <a href="">DDE123</a></span>
                                        @else
                                            <span class="label label-disable">Pending</span>
                                        @endif
                                    </td>
									<td>
										@if($x%2 ==0)
                                            CCC123
                                        @else
                                            -
                                        @endif
									</td>
								</tr>
								<?php endfor;  ?>
							</tbody>

							<tfoot>
								<tr>
									<th></th>
									<th>Enrollment <br>Link</th>									
									<th>Course</th>
									<th>Enrolled <br>Date/time</th>
									<th>Total <br>claimed Amount</th>
									<th>is Paid</th>
									<th>Used <br>cupon code</th>
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

    <!-- Magnific Popup core JS file 
    <script src="{{asset('admin/js/jquery.magnific-popup.min.js')}}"></script>-->

    <!-- sweetalert2 js file
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>-->

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@stop


@section('javascript')
<script>



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
												<th>Teacher</th>
												<th>Course original price</th>
												<th>Student</th>
											</tr>
                                        </thead>
                                        <tr class="">
                                            <td>A.B.C Saman Fernando</td>
											<td>RS 6000.00</td>
											<td>A.B.C Vikum Amaraweera</td>
										</tr>
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
                        	<td>Teacher share from course fee</td>
                            <td>60%</td>
                        </tr>
                        <tr class="text-red-600 font-bold">
							<td>Teacher claimed Amount from course fee</td>
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
							<td>Cupon code discount %</td>
							<td>10%</td>
						</tr>
                        <tr>
                        	<td>Cupon code discount amount</td>
                            <td>RS 600.00 = (6000*10%)</td>
                        </tr>						
                        <tr>
                        	<td>Marketer/Teacher share from discount</td>
                            <td>100%</td>
                        </tr>
                        <tr>
                        	<td>Edumind share from discount</td>
                            <td>0%</td>
                        </tr>						
						<tr class="text-red-600 font-bold">
							<td>Marketer/Teacher claimed Amount from cupon code discount</td>
							<td>RS 600.00 = (600*100%)</td>
						</tr>
						<tr class="text-red-600 font-bold">
							<td>Edumind claimed Amount from cupon code discount</td>
							<td>RS 00.00 = (600*0%)</td>
						</tr>                                       
                    </table>
                </div>

                <div class="mb-4 w-3/4 ml-3 border">
                	<fieldset>
	                    <table class="w-full">
	                        <tr>
								<td>Course original price</td>
								<td>RS 6000.00</td>
							</tr>
							<tr class="">
								<td>Edumind share from course fee</td>
								<td>40%</td>
							</tr>
							<tr class="">
								<td>Reduced share of cupon code discount from Edumind</td>
								<td>100%</td>
							</tr>
							<tr class="">
								<td>New Edumind share (if cupon code used)</td>
								<td>30% = (40% - 10%*100%)</td>
							</tr>
							<tr class="text-red-600 font-bold">
								<td>Edumind claimed Amount from course fee</td>
								<td>RS 1800.00 = (6000*30%)</td>
							</tr> 
						</table>
					</fieldset>
                </div>
            </div>
			`);
		}





		var table = $('#cupon-code-list-tbl').DataTable({
			//ajax: './ajax.txt',
			columns: [
				{
					className: 'dt-control',
					orderable: false,
					data: null,
					defaultContent: '',
				},
				{ data: 'enrollment link' },
				{ data: 'course' },
				{ data: 'enrollment date' },
				{ data: 'claimed Amount' },
				{ data: 'is paid',visible: true },
				{ data: 'discount precentage',visible: true },
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
		$('#cupon-code-list-tbl tbody').on('click', 'td.dt-control', function () {
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

		$("#cupon-code-list-tbl thead tr").css("border-bottom","5px solid #000");





		


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