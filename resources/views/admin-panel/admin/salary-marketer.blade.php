@extends('admin-panel.layouts.master',['title' => 'Marketer salary'])
@section('title','Marketer salary')

@section('css-files')
    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@stop


@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table id="teacher-salary-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Teacher</th>
                                <th>Earning<br><small>(from courses)</small></th>
                                <th>Pending<br><small>(amount)</small></th>
                                <th>Earning ratio(%)</th>
                                <th>Salary<br><small>(monthly)</small></th>
                                <th>Last payment</th>
                                <th>Last paydate</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <!-- <td>314</td> -->
                                <td>aa Customer example</td>
                                <td>$500.00</td>
                                <td>
                                    <a class="text-lg" href="#"><i class="fa fa-check text-navy"></i></a>
                                </td>
                                <td>5%</td>
                                <td>5%</td>
                                <td>5000</td>
                                <td>5000</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button class="btn-white btn btn-xs">View</button>
                                        <button class="btn-danger btn btn-xs">Delete</button>
                                    </div>
                                </td>
                            </tr>

                            <?php for ($i=0; $i < 23 ; $i++):?>
                            <tr>
                                <!-- <td>315</td> -->
                                <td>Customer example</td>
                                <td>$500.00</td>
                                <td>03/04/2015</td>
                                <td>7%</td>
                                <td>7%</td>
                                <td>4000</td>
                                <td>4000</td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <button data-toggle="modal" class="btn-white btn btn-xs" href="#modal-t-salary-details">View & Update</button>
                                    </div>
                                </td>
                            </tr>
                            <?php endfor;?>

                            </tbody>

                            <tfoot>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Teacher</th>
                                <th>Earning<br><small>(from courses)</small></th>
                                <th>Pending<br><small>(amount)</small></th>
                                <th>Earning ratio(%)</th>
                                <th>Salary<br><small>(monthly)</small></th>
                                <th>Last payment</th>
                                <th>Last paydate</th>
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
    <div class="modal fade" id="modal-t-salary-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Teacher one Salary</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-3 py-2">
                    <label>Salary history</label>

                    <div class="border mb-2">
                        <div class="teacher-salary-list slimscroll">
                            <ul>
                                <?php for ($i=0; $i < 54 ; $i++):?>
                                <li  class="text-gray-800 text-sm text-center">Rs 20,000 - 2012/12/5</li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>

                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Date:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" placeholder="" class="form-control">
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Pay</button>
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script-files')

    <script src="{{asset('admin/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

@stop


@section('javascript')
<script>
    $(document).ready(function() {
		$('#teacher-salary-tbl').DataTable({
			pageLength: 10,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [],
			"columnDefs": [{
				"targets": [1,2,3,4,5,6],
				"searchable": false
			},
				{  className: "text-right", targets: 7 }


			],
			fnDrawCallback:function (oSettings) {

			}
		});

		$('.teacher-salary-list').slimScroll({
			height: '200px',
			//width: '500px',
			size: '10px',
			position: 'right',
			color: '#000',alwaysVisible: true,
		});

    });
</script>
@stop
