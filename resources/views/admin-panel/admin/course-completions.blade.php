
@extends('admin-panel.layouts.master',['title' => 'Course completions'])
@section('title','Course completions')

@section('css-files')
	<!-- select2 -->
	<link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- datatables -->
    <link href="{{asset('admin/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
	<link href="{{asset('admin/css/plugins/dataTables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">


    <!-- Magnific Popup core CSS file 
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">-->

    <!-- sweetalert2 CSS file
    <link rel="stylesheet" href="{{asset('admin/css/plugins/sweetalert2/sweetalert2.min.css')}}">-->
	
	<!-- Date Range Picker CSS file-->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->
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
                            <div class="text-center"><h3>Course</h3></div>
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
                        <div class="offset-sm-1 col-md-6 px-0">
                            <div class="text-center"><h3>Date range select:</h3></div>
                            <div class="course-enrollments-daterange input-daterange input-group" id="datepicker">
                                <input type="text" name="daterange" class="p-0 px-2 py-1 form-control text-center text-lg"/>
                            </div>
                        </div>
                    </div>
                   
                    <div class="table-responsive">
                        <table id="cupon-code-list-tbl" class="display dataTable table-striped table-h-bordered _table-hover" style="width:100%">
							<thead>
								<tr>
									<th>Completed <br>Date/time</th>
									<th>Course</th>
									<th>Enrollment <br>Link</th>									
									<th>Student</th>
								</tr>
							</thead>

							<tbody>
								<?php							
								for ($x = 0; $x <= 100; $x+=1): ?>
								<tr>
									<td>2022/7/16 06:45 PM</td>
									<td>Course<?php echo $x; ?></td>
									<td>2022/7/16 06:45 PM</td>
									<td>A.B.C Saman Fernando</td>
								</tr>
								<?php endfor;  ?>
							</tbody>

							<tfoot>
								<tr>
									<th>Completed <br>Date/time</th>
									<th>Course</th>
									<th>Enrollment <br>Link</th>									
									<th>Student</th>
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

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
    <script type="text/javascript" src="{{asset('admin/js/moment.min.js')}}"></script>
	<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
	<script type="text/javascript" src="{{asset('admin/plugins/daterangepicker/js/daterangepicker.min.js')}}"></script>
	
@stop


@section('javascript')
<script>



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



		var table = $('#cupon-code-list-tbl').DataTable({
			//ajax: './ajax.txt',
			columns: [
				{ data: 'completed date' },
				{ data: 'course' },				
				{ data: 'enrollment date' },
				{ data: 'student' },
				//{ data: 'course-teacher' },				
			],
			//order: [[1, 'asc']],
			"ordering": false,
			pageLength: 10,
			responsive: true,
			// dom: '<"html5buttons"B>lTfgitp',
			//dom: 'Bfrtip',
			lengthChange: false,
		});

		$("#cupon-code-list-tbl thead tr").css("border-bottom","15px solid #000");





		


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




