@extends('admin-panel.layouts.master',['title' => 'View teacher coupon codes'])
@section('title','View coupon codes')

@section('css-files')
	<!-- select2 -->
	<link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    <!-- Magnific Popup core CSS file 
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">-->

    <!-- sweetalert2 CSS file
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">-->
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

            <div class="ibox">
                <div class="ibox-content">                  
					<div>// move last : available = 0</div>

                    <div class="table-responsive">
                        <table id="coupon-code-list-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
							<thead>
								<tr>
									<th></th>
									<th>Code</th>
									<th>Discount</th>
									<th>Works for</th>
									<th>Used</th>
									<th>Available</th>
									<th>Total</th>
									<th>Created Date/time</th>
									<th>Total Discount<br> <small>(teacher claimed amount)</small></th>
								</tr>
							</thead>

							<tbody>
								<?php
								$arr = ['Any course','Maths 101','Multiple courses (3)'];

								for ($x = 0; $x <= 100; $x+=1): ?>

								<tr>
									<td></td>
									<td>ABC<?php echo $x; ?></td>
									<td><?php echo $x; ?>%</td>
									<td><?php echo $arr[array_rand($arr)];?></td>
									<td><?php echo $x*100; ?></td>
									<td><?php echo $x*20; ?></td>
									<td><?php echo $x; ?></td>
									<td>2022/7/16 06:45 PM</td>
									<td><?php echo 'RS '.$x.'000.00'; ?></td>
								</tr>
								<?php endfor;  ?>
							</tbody>

							<tfoot>
								<tr>
									<th></th>
									<th>Code</th>
									<th>Discount</th>
									<th>Works for</th>
									<th>Used</th>
									<th>Available</th>
									<th>Total</th>
									<th>Created Date/time</th>
									<th>Discount <br> <small>(teacher claimed amount)</small></th>
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

            <div class="table-detail-content">
                <ul>
                    <li>
                        <div class="detail"></div>

                        <div class="detail detail-main">
                            <fieldset>
                                <legend>
									<span class="label label-primary">
										<a href="" class="hover:text-white">Course one</a>
									</span>
								</legend>
                                <div>
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
												<!--<th>Course name</th>-->
												<th>Original price</th>
												<th>New price</th>
												<th>Used coupon code count</th>
                                                <th>Discount</th>
											</tr>
                                        </thead>
                                        <tr>
                                            <!--<td>Course one</td>-->
											<td>RS 6000.00</td>
											<td>RS 5000.00</td>
											<td>12</td>
                                            <td>RS 6200.00</td>
										</tr>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </li>

                    <li>
                        <div class="detail"></div>

                        <div class="detail detail-main">
                            <fieldset>
                                <legend>
									<span class="label label-primary">
										<a href="" class="hover:text-white">Course two</a>
									</span>
								</legend>
                                <div>
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
												<!--<th>Course name</th>-->
												<th>Original price</th>
												<th>New price</th>
												<th>Used coupon code count</th>
                                                <th>Discount</th>
											</tr>
                                        </thead>
                                        <tr>
                                            <!--<td>Course one</td>-->
											<td>RS 7000.00</td>
											<td>RS 5000.00</td>
											<td>33</td>
                                            <td>RS 4300.00</td>
										</tr>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </li>

                    <li>
                        <div class="detail"></div>

                        <div class="detail detail-main">
                            <fieldset>
                                <legend>
									<span class="label label-primary">
										<a href="" class="hover:text-white">Course three</a>
									</span>
								</legend>
                                <div>
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
												<!--<th>Course name</th>-->
												<th>Original price</th>
												<th>New price</th>
												<th>Used coupon code count</th>
                                                <th>Discount</th>
											</tr>
                                        </thead>
                                        <tr>
                                            <!--<td>Course one</td>-->
											<td>RS 8000.00</td>
											<td>RS 5000.00</td>
											<td>42</td>
                                            <td>RS 880.00</td>
										</tr>
                                    </table>
                                </div>
                            </fieldset>
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
				{ data: 'name' },
				{ data: 'position' },
				{ data: 'office' },
				{ data: 'salary' },

				{ data: 'x1',visible: true },
				{ data: 'y1',visible: true },
				{ data: 'z1',visible: true },
				{ data: 'a1',visible: true },


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







		$('#coupon-code-list-tbl1').DataTable({
			"columns": [
				null,
				{ "width": "40%" },
				null,
				null,
				null
			],
			"ordering": false,
			pageLength: 10,
			responsive: true,
			// dom: '<"html5buttons"B>lTfgitp',
			dom: 'Bfrtip',
			lengthChange: false,
			buttons: [
				/*
                {extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    }
                }
                */
				{
					text: 'Add subject',
					action: function ( e, dt, node, config ) {
						//$('#addProjectModal').modal('show');
						//$('#add-modal').modal('show');
						window.location = '{{route('admin.subject.create')}}';
						//  alert( 'Button activated' );
					},
					className: 'add-ct mb-3 btn-green '
				}
			]

		});

	});

</script>
@stop
