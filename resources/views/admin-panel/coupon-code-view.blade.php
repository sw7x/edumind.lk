@extends('admin-panel.layouts.master',['title' => 'View coupon code'])
@section('title','View coupon code')

@section('css-files')
    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
@stop

@section('page-css')
<style>
	.faq-section .mb-0 > a {
		display: block;
		position: relative;
	}

	.faq-section .mb-0 > a:after {
		content: "\f067";
		font-family: "Font Awesome 5 Free";
		position: absolute;
		right: 0;
		font-weight: 600;
	}

	.faq-section .mb-0 > a[aria-expanded="true"]:after {
		content: "\f068";
		font-family: "Font Awesome 5 Free";
		font-weight: 600;
	}

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
            
        	@if(isset($coupon) && isNotEmptyArray($coupon))
            	<!-- content -->
	            <div class="ibox ">
	                <div class="ibox-content">
	                    <form class="edit-subject-form" id="edit-subject" action="" method="POST">

	                        <div class="form-group row mt-1">
	                            <label class="col-sm-4 col-form-label">Code</label>
	                            <div class="col-sm-8"><label class="col-form-label">{{$coupon['code']}}</label></div>
	                        </div>
	                        <div class="hr-line-dashed my-0"></div>

							<div class="form-group row mt-1">
								<label class="col-sm-4 col-form-label">Discount <small>(percentage)</small></label>
								<div class="col-sm-8"><label class="col-form-label">{{$coupon['discountPercentage']}}</label></div>
							</div>
							<div class="hr-line-dashed my-0"></div>


							<div class="form-group row mt-1">
								<label class="col-sm-4 col-form-label">Claimed total discount</label>
								<div class="col-sm-8"><label class="col-form-label">Rs 5000.00- //todo</label></div>
							</div>
							<div class="hr-line-dashed my-0"></div>

							<div class="form-group row mt-3">
								<label class="col-sm-4 col-form-label">Count</label>

								<div class="col-sm-6">
									<div>
										<p class="float-right font-semibold text-red">Used {{$coupon['usedCount'] }} / Total {{$coupon['totalCount']}}</p>
									</div>
									<br>
									<div class="progress progress-small mb-3" style="height:30px">
										<div style="width: calc(({{$coupon['usedCount']}}/{{$coupon['totalCount']}})*100%);height:30px" class="progress-bar"></div>
									</div>
									<span>Available : {{($coupon['totalCount'] - $coupon['usedCount'])}}</span>
								</div>
							</div>
							<div class="hr-line-dashed my-0"></div>


							<div class="form-group row mt-1">
								<label class="col-sm-4 col-form-label">Works for</label>
								<div class="col-sm-8">
									<label class="col-form-label">							
									@if($coupon['courseName'])
										{{$coupon['courseName']}}
									@else
										Any course
									@endif
									</label>
								</div>
							</div>
							<div class="hr-line-dashed my-0"></div>

							<div class="form-group row mt-1">
								<label class="col-sm-4 col-form-label">Created date</label>
								<div class="col-sm-8"><label class="col-form-label">{{$coupon['createdDate']}}</label></div>
							</div>
							<div class="hr-line-dashed my-0"></div>


	                        <div class="form-group row">
	                            <label class="col-sm-4 col-form-label">Submit status</label>
	                            <div class="col-sm-8">
	                                <div class="i-checks mt-3">
	                                    <label> <input type="radio" value="draft" name="subject_stat" disabled {{($coupon['isEnabled'])?'':'checked'}}> <i></i> Draft </label>
	                                </div>
	                                <div class="i-checks">
	                                    <label> <input type="radio" value="published" name="subject_stat" disabled {{($coupon['isEnabled'])?'checked':''}}> <i></i> Published </label>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="hr-line-dashed my-0"></div>

							//todo
							<div class="panel-group mt-3" id="accordion" role="tablist" aria-multiselectable="true">
								<div class="panel panel-default">
									<div class="panel-heading bg-blue-500" role="tab" id="" style="padding: 6px 15px;background: #179a7f;color: #fff;">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												<i class="more-less glyphicon glyphicon-plus"></i>
												<span class="ml-5 text-base">View this coupon code usage </span>
											</a>
										</h4>
									</div>
									<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<div class="table-detail-content">
												<ul>
													<li>
														<div class="detail"></div>

														<div class="detail detail-main">
															<fieldset>
																<div class="p-1">
																	<table class="table table-striped table-bordered">
																		<thead class="thead-dark">
																		<tr>
																			<th>Course</th>
																			<th>Course Price</th>
																			<th>Discount amount</th>
																			<th>New Price</th>
																			<th>Date / Time</th>
																			<th>Student</th>
																		</tr>
																		</thead>
																		<tr>
																			<td>Course one</td>
																			<td>RS 6000.00</td>
																			<td>RS 600.00</td>
																			<td>RS 5400.00</td>
																			<td>2022/7/4 13.11 PM</td>
																			<td>A.B.C Saman Fernando</td>
																		</tr>
																		<tr>
																			<td>Course one</td>
																			<td>RS 6000.00</td>
																			<td>RS 600.00</td>
																			<td>RS 5400.00</td>
																			<td>2022/7/4 13.11 PM</td>
																			<td>A.B.C Saman Fernando</td>
																		</tr>
																		<tr>
																			<td>Course one</td>
																			<td>RS 6000.00</td>
																			<td>RS 600.00</td>
																			<td>RS 5400.00</td>
																			<td>2022/7/4 13.11 PM</td>
																			<td>A.B.C Saman Fernando</td>
																		</tr>

																	</table>
																</div>
															</fieldset>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>

	                    </form>
	                </div>
	            </div>
            @else
            	<x-flash-message 
                    class="flash-danger mt-3" 
                    title="Data not available!" 
                    message="Coupon code data is not available or not in correct format" 
                    :canClose="false"/>
            @endif

        </div>
    </div>
@stop



@section('script-files')
    <!-- iCheck -->
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>
@stop


@section('javascript')
<script>
	function toggleIcon(e) {
		$(e.target)
			.prev('.panel-heading')
			.find(".more-less")
			.toggleClass('glyphicon-plus glyphicon-minus');
	}
	$('.panel-group').on('hidden.bs.collapse', toggleIcon);
	$('.panel-group').on('shown.bs.collapse', toggleIcon);
</script>
@stop
