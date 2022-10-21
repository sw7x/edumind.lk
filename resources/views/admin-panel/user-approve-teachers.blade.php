@extends('admin-panel.layouts.master')
@section('title','Approve student changes')

@section('css-files')
    <link href="{{asset('admin/css/plugins/switchery/switchery.css')}}" rel="stylesheet">
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
                        <table id="teacher-approve-list" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>Order ID</th>
                                <th data-hide="phone">User</th>
                                <th data-hide="phone">Amount</th>
                                <th data-hide="phone">Date added</th>
                                <th data-hide="phone,tablet" >Date modified</th>
                                <th data-hide="phone">Status</th>
                                <th class="text-right">Action</th>



                                <!-- name
                                username
                                email
                                phone
                                gender
                                dob


                                profile pic
                                edu details -->
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
                                <img src="{{asset('images/category/development.jpg')}}" width="100px" alt="">
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
                        <tr>
                            <td>
                                324
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $320.00
                            </td>
                            <td>
                                12/04/2015
                            </td>
                            <td>
                                21/07/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                546
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                <a class="text-lg text-danger" href="#"><i class="fa fa-times"></i></a>
                            </td>
                            <td>
                                <a class="text-lg" href="#"><i class="fa fa-check-square-o text-navy"></i></a>
                            </td>
                            <td>
                                <a class="text-lg" href="#"><i class="fa fa-check text-navy"></i></a>
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                6327
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $8560.00
                            </td>
                            <td>
                                01/12/2015
                            </td>
                            <td>
                                05/12/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                642
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $6843.00
                            </td>
                            <td>
                                10/04/2015
                            </td>
                            <td>
                                13/07/2015
                            </td>
                            <td>
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                7435
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $750.00
                            </td>
                            <td>
                                04/04/2015
                            </td>
                            <td>
                                14/05/2015
                            </td>
                            <td>
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                3214
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
                                03/05/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                324
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $320.00
                            </td>
                            <td>
                                12/04/2015
                            </td>
                            <td>
                                21/07/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                546
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $2770.00
                            </td>
                            <td>
                                06/07/2015
                            </td>
                            <td>
                                04/08/2015
                            </td>
                            <td>
                                <span class="label label-danger">Canceled</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                6327
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $8560.00
                            </td>
                            <td>
                                01/12/2015
                            </td>
                            <td>
                                05/12/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                642
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $6843.00
                            </td>
                            <td>
                                10/04/2015
                            </td>
                            <td>
                                13/07/2015
                            </td>
                            <td>
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                7435
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $750.00
                            </td>
                            <td>
                                04/04/2015
                            </td>
                            <td>
                                14/05/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                324
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $320.00
                            </td>
                            <td>
                                12/04/2015
                            </td>
                            <td>
                                21/07/2015
                            </td>
                            <td>
                                <span class="label label-warning">Expired</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                546
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $2770.00
                            </td>
                            <td>
                                06/07/2015
                            </td>
                            <td>
                                04/08/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                6327
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $8560.00
                            </td>
                            <td>
                                01/12/2015
                            </td>
                            <td>
                                05/12/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                642
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $6843.00
                            </td>
                            <td>
                                10/04/2015
                            </td>
                            <td>
                                13/07/2015
                            </td>
                            <td>
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                7435
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $750.00
                            </td>
                            <td>
                                04/04/2015
                            </td>
                            <td>
                                14/05/2015
                            </td>
                            <td>
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                3214
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
                                03/05/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                324
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $320.00
                            </td>
                            <td>
                                12/04/2015
                            </td>
                            <td>
                                21/07/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                546
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $2770.00
                            </td>
                            <td>
                                06/07/2015
                            </td>
                            <td>
                                04/08/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                6327
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $8560.00
                            </td>
                            <td>
                                01/12/2015
                            </td>
                            <td>
                                05/12/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                642
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $6843.00
                            </td>
                            <td>
                                10/04/2015
                            </td>
                            <td>
                                13/07/2015
                            </td>
                            <td>
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                7435
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $750.00
                            </td>
                            <td>
                                04/04/2015
                            </td>
                            <td>
                                14/05/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                324
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $320.00
                            </td>
                            <td>
                                12/04/2015
                            </td>
                            <td>
                                21/07/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                546
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $2770.00
                            </td>
                            <td>
                                06/07/2015
                            </td>
                            <td>
                                04/08/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                6327
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $8560.00
                            </td>
                            <td>
                                01/12/2015
                            </td>
                            <td>
                                05/12/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                642
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $6843.00
                            </td>
                            <td>
                                10/04/2015
                            </td>
                            <td>
                                13/07/2015
                            </td>
                            <td>
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                7435
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $750.00
                            </td>
                            <td>
                                04/04/2015
                            </td>
                            <td>
                                14/05/2015
                            </td>
                            <td>
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                3214
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
                                03/05/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                324
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $320.00
                            </td>
                            <td>
                                12/04/2015
                            </td>
                            <td>
                                21/07/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                546
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $2770.00
                            </td>
                            <td>
                                06/07/2015
                            </td>
                            <td>
                                04/08/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                6327
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $8560.00
                            </td>
                            <td>
                                01/12/2015
                            </td>
                            <td>
                                05/12/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                642
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $6843.00
                            </td>
                            <td>
                                10/04/2015
                            </td>
                            <td>
                                13/07/2015
                            </td>
                            <td>
                                <span class="label label-success">Shipped</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                7435
                            </td>
                            <td>
                                Customer example
                            </td>
                            <td>
                                $750.00
                            </td>
                            <td>
                                04/04/2015
                            </td>
                            <td>
                                14/05/2015
                            </td>
                            <td>
                                <span class="label label-primary">Pending</span>
                            </td>
                            <td class="text-right">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs">View</button>
                                    <button class="btn-white btn btn-xs">Edit</button>
                                    <button class="btn-white btn btn-xs">Delete</button>
                                </div>
                            </td>
                        </tr>
                        </tbody>

                        <tfoot>
                        <tr>
                            <th>Order ID</th>
                            <th data-hide="phone">Customer</th>
                            <th data-hide="phone">Amount</th>
                            <th data-hide="phone">Date added</th>
                            <th data-hide="phone,tablet" >Date modified</th>
                            <th data-hide="phone">Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                        </tfoot>

                        <!--
                        <tfoot>
                        <tr>
                            <td colspan="7">
                                <ul class="pagination float-right"></ul>
                            </td>
                        </tr>
                        </tfoot>
                        -->

                    </table>
                </div>


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


@stop


@section('javascript')
<script>
	$(document).ready(function() {
		$('#teacher-approve-list').DataTable({
			pageLength: 10,
			responsive: true,
			dom: 'Bfrtip',
			buttons: [{
				text: 'Approve all',
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
