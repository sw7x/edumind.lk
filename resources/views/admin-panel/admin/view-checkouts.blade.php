@extends('admin-panel.layouts.master',['title' => 'View Checkouts'])
@section('title','View Checkouts')

@section('css-files')
    <!-- bootstrap datapicker -->
    <link href="{{asset('admin/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
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
                    <div class="px-3 row mb-3" id="">
                        <div class="col-md-6">
                            <div class="text-center"><h3>Range select:</h3></div>
                            <div class="checkouts-daterange input-daterange input-group" id="datepicker">
                                <input type="text" class="form-control-sm form-control" name="start" value="2021/01/01"/>
                                <span class="input-group-addon px-3"> to </span>
                                <input type="text" class="form-control-sm form-control" name="end" value="<?php echo date("Y/m/d"); ?>" />
                            </div>
                        </div>

                        <div class="offset-md-2 col-md-4">
                            <table class="table table-bordered table-fixed w-full">
                                <thead>
                                <tr>
                                    <th>Earning</th>
                                    <td class="break-words"><h4 class="text-navy m-0">Rs 20,0000</h4></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="font-fullbold">Enrolments</td>
                                    <td class="break-words"><h4 class="font-semibold text-navy m-0">231</h4></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <hr>
                </div>
            </div>

            
        </div>


        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">

                    <div class="px-3 row mb-3" id="">
                        <div class="col-lg-12">

                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>From:</h5>

                                    <!--
                                    <div>First name Last name</div>
                                    <address>
                                        <strong>Street Address</strong><br>
                                        Town / City <br>
                                        Country / Region<br>
                                        Postcode / ZIP<br>
                                        <abbr title="Phone">P:</abbr> Phone
                                    </address>
                                    <a href = "mailto: abc@example.com">Email</a>
                                    Additional information (optional)
                                    -->
                                    <div>Evans Frank Ghosh Hills Irwin Jones</div>
                                    <address>
                                        <strong>Inspinia, Inc.</strong><br>
                                        106 Jorg Avenu, 600/10<br>
                                        Chicago, VT 32456<br>
                                        <abbr title="Phone">P:</abbr> (123) 601-4590
                                    </address>
                                    <a href = "mailto: abc@example.com">abc@example.com</a>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy">INV-000567F7-00</h4>
                                    <p>
                                        <span><strong>Invoice Date:</strong> Marh 18, 2014</span><br/>
                                        <span><strong>Due Date:</strong> March 24, 2014</span>
                                    </p>
                                </div>
                            </div>


                            <div class="table-responsive m-t m-b">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Item List</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>Admin Theme with psd project layouts</strong></div>
                                        <td>1</td>
                                        <td>$26.00</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div><strong>Wodpress Them customization</strong></div>
                                        </td>
                                        <td>1</td>
                                        <td>$80.00</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>Angular JS & Node JS Application</strong></div></td>
                                        <td>1</td>
                                        <td>$420.00</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                <tr>
                                    <td><strong>Coupon Code :</strong></td>
                                    <td>ABCD123</td>
                                </tr>
                                <tr>
                                    <td><strong>Discont(%) :</strong></td>
                                    <td>45%</td>
                                </tr>
                                <tr>
                                    <td><strong>Discont Applied Item :</strong></td>
                                    <td>Wodpress Them customization</td>
                                </tr>
                                <tr>
                                    <td><strong>Discont Applied Item :</strong></td>
                                    <td>For total</td>
                                </tr>
                                <tr>
                                    <td><strong>Sub Total :</strong></td>
                                    <td>$1026.00</td>
                                </tr>
                                <tr>
                                    <td><strong>TAX :</strong></td>
                                    <td>$235.98</td>
                                </tr>
                                <tr>
                                    <td><strong>Coupon Code Discount Amount :</strong></td>
                                    <td>-$1026*45% = -$235.98</td>
                                </tr>
                                <tr class="total-price">
                                    <td><strong>TOTAL :</strong></td>
                                    <td>$1261.98</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop



@section('script-files')


    <!-- Data picker -->
    <script src="{{asset('admin/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>


@stop


@section('javascript')
<script>
	$(document).ready(function() {
        $('.checkouts-daterange').datepicker({
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
