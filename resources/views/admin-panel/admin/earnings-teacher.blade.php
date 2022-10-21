@extends('admin-panel.layouts.master',['title' => 'Teacher Earnings'])
@section('title','Teacher earnings')

@section('css-files')
    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- bootstrap datapicker -->
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
@stop



@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">



                    <div class="px-3 row mb-3" id="">
                        <div class="offset-sm-3 col-sm-2 align-middle">
                            <h3><b>Range select: </b></h3>
                            <!-- <label class="font-normal">Range select</label>-->
                        </div>
                        <div class="col-md-7">
                            <div class="teacher-earning-daterange input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control-sm form-control" name="start" value="2021/01/01"/>
                                <span class="input-group-addon px-3"> to </span>
                                <input type="text" class="form-control-sm form-control" name="end" value="<?php echo date("Y/m/d"); ?>" />
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="table-responsive">
                        <table id="teacher-earning-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Teacher</th>
                                <th>Earning ratio(%)</th>
                                <th>Earning</th>
                                <th>salary <small>(monthly)</small></th>
                                <th>courses<small>(count)</small></th>
                                <th>students<small>(count)</small></th>
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
                                    $500.00
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
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Date added</th>
                                <th>Date modified</th>
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




@section('bootstrap-modals')
    <div class="modal fade" id="modal-t-approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">t-approve</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" placeholder="Password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>
@stop


@section('script-files')


    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Switchery -->
    <script src="{{asset('admin/js/plugins/switchery/switchery.js')}}"></script>



    <!-- Data picker -->
    <script src="{{asset('admin/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>


@stop


@section('javascript')
    <script>
		$(document).ready(function() {
			$('.teacher-earning-daterange').datepicker({
				keyboardNavigation: false,
				forceParse: false,
				autoclose: true,

                ///startView: 2,
				todayBtn: "linked",
				format: 'yyyy-mm-dd',
				endDate: '+0d',
				autoclose: true
			});


			$('#teacher-earning-tbl').DataTable({
				pageLength: 10,
				responsive: true,
				dom: 'Bfrtip',
				buttons: [{
					text: 'w Approve all',
					href : 'uuu',
					action: function ( e, dt, node, config ) {
						window.location = 'user-add.php#tab-teachers';
					},
					className: 'add-ct mb-3 btn-green '
				}],
				"columnDefs": [{
					"targets": [1,2,3,4,5,6],
					"searchable": false

				}],
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





		});

    </script>
@stop
