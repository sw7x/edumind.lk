@extends('admin-panel.layouts.master',['title' => 'View Teacher cupon codes'])
@section('title','View cupon codes')

@section('css-files')
	<link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

	<!-- select2 -->
	<link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

	<!-- datatables -->
	<link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
	<link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">

	<!-- Magnific Popup core CSS file
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">-->

	<!-- sweetalert2 CSS file
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">-->

	<!-- multiselect CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/multiselect.css')}}">

@stop

@section('page-css')
	<style>


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

            @if(isset($message))
                <div class="flash-msg {{$cls ?? 'flash-info'}} rounded-none">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ $msgTitle ?? 'Info!'}}</strong></div>
                    <p>{{ $message ?? 'Info!' }}</p>
                    <div class="text-base">{!! $message2 ?? '' !!}</div>
                </div>
            @endif

			<div class="ibox">
				<div class="ibox-content">

					<div class="d-flex justify-between col-md-12 mb-4 mt-1">
						<div class="multiselect-wrapper">
							<div class="text-sm text-white text-center py-1 px-2 bg-gray-400 heading">Select Teacher</div>
							<div class="multiselect custom-scrollbar" id="multiselect-marketer">

								<label class="custom-checkbox-container select-all">
									<span>Select All</span>
									<input type="checkbox" class="mr-2"/>
									<span class="checkmark"></span>
								</label>
								<div class="mb-1 border" ></div>

								<div>
									<label class="custom-checkbox-container">
										<span>One</span>
										<input type="checkbox" class="mr-2 vvv"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Ant</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Big</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Cook</span>
										<input type="checkbox" checked="checked" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Doll</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Eat</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Fruit</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>GO</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>
								</div>
							</div>
						</div>

						<div class="multiselect-wrapper">
							<div class="text-sm text-white text-center py-1 px-2 bg-gray-400 heading">Select Course</div>
							<div class="multiselect custom-scrollbar" id="multiselect-course">

								<label class="custom-checkbox-container select-all">
									<span>Select All</span>
									<input type="checkbox" class="mr-2"/>
									<span class="checkmark"></span>
								</label>
								<div class="mb-1 border" ></div>

								<div>
									<label class="custom-checkbox-container">
										<span>One</span>
										<input type="checkbox" class="mr-2 vvv"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Ant</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Big</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Cook</span>
										<input type="checkbox" checked="checked" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Doll</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Eat</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>Fruit</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>

									<label class="custom-checkbox-container">
										<span>GO</span>
										<input type="checkbox" class="mr-2"/>
										<span class="checkmark"></span>
									</label>
								</div>

							</div>
						</div>
					</div>
					<hr><br>

					<div class="table-responsive">
						<table id="cupon-code-list-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
							<thead>
							<tr>
								<th></th>
								<th>Code</th>
								<th>Discount</th>
								<th>Works for</th>
								<th>Used</th>
								<th>Available</th>
								<th>Total</th>
								<th>Assigned Date/time</th>
								<th>Claimed discount</th>
								<th>Status</th>
								<th>Action</th>
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
								<td>
                                    <input type="checkbox" class="js-switch1" checked />
                                </td>
								<td>
									<div class="btn-group">
                                        <button class="btn-white btn btn-xs">View</button>
                                        <button class="btn-white btn btn-xs">Edit</button>
                                        <button class="btn-white btn btn-xs">Delete</button>
                                    </div>
                                </td>





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
								<th>Assigned Date/time</th>
								<th>Claimed discount</th>
								<th>Status</th>
								<th>Action</th>
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

	<!-- Switchery -->
    <script src="{{asset('admin/js/plugins/switchery/switchery.js')}}"></script>

	<!-- Select2 -->
	<script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>

	<script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
	<script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

	<!-- Magnific Popup core JS file
    <script src="{{asset('admin/js/jquery.magnific-popup.min.js')}}"></script>-->

	<!-- sweetalert2 js file
    <script src="{{asset('admin/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>-->

	<!-- multiselect js file-->
    <script src="{{asset('admin/js/multiselect.js')}}"></script>

@stop


@section('javascript')
	<script>

		$(document).ready(function() {


			//$(".multiselect").multiselect();
			$('#multiselect-course').multiselect();
			$('#multiselect-marketer').multiselect();



			console.log('');

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
												<th>Course Price</th>
												<th>Teacher</th>
												<th>Applied count</th>
                                                <th>Discount amount</th>
											</tr>
                                        </thead>
                                        <tr>
                                            <!--<td>Course one</td>-->
											<td>RS 6000.00</td>
											<td>A.B.C Saman Fernando</td>
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
												<th>Course Price</th>
												<th>Teacher</th>
												<th>Applied count</th>
                                                <th>Discount amount</th>
											</tr>
                                        </thead>
                                        <tr>
                                            <!--<td>Course one</td>-->
											<td>RS 7000.00</td>
											<td>D.B.A Alex Fernando</td>
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
												<th>Course Price</th>
												<th>Teacher</th>
												<th>Applied count</th>
                                                <th>Discount amount</th>
											</tr>
                                        </thead>
                                        <tr>
                                            <!--<td>Course one</td>-->
											<td>RS 8000.00</td>
											<td>A.B.C Peter Fernando</td>
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





			var table = $('#cupon-code-list-tbl').DataTable({
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
					{ data: 'b1',visible: true },
					{ data: 'c1',visible: true },
				],
				//order: [[1, 'asc']],

				"ordering": false,
				pageLength: 10,
				responsive: true,
				// dom: '<"html5buttons"B>lTfgitp',
				//dom: 'Bfrtip',
				lengthChange: false,

				fnDrawCallback:function (oSettings) {
					console.log("after table create");
					var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch1'));

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







			$('#cupon-code-list-tbl1').DataTable({
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
