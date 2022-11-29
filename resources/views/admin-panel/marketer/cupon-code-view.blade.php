@extends('admin-panel.layouts.master',['title' => 'View cupon code'])
@section('title','View cupon code')

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


            <!-- content -->
            <div class="ibox ">
                <div class="ibox-content">
                    <form class="edit-subject-form" id="edit-subject" action="" method="POST">

                        <div class="form-group row mt-1">
                            <label class="col-sm-4 col-form-label">Code</label>
                            <div class="col-sm-8"><label class="col-form-label">ABC123</label></div>
                        </div>
                        <div class="hr-line-dashed my-0"></div>

						<div class="form-group row mt-1">
							<label class="col-sm-4 col-form-label">Discount <small>(percentage)</small></label>
							<div class="col-sm-8"><label class="col-form-label">-10%</label></div>
						</div>
						<div class="hr-line-dashed my-0"></div>


						<div class="form-group row mt-1">
							<label class="col-sm-4 col-form-label">Claimed total discount</label>
							<div class="col-sm-8"><label class="col-form-label">Rs 5000.00</label></div>
						</div>
						<div class="hr-line-dashed my-0"></div>

						<div class="form-group row mt-3">
							<label class="col-sm-4 col-form-label">Count</label>

							<div class="col-sm-6">
								<div>
									<p class="float-right font-semibold text-red">Used 22 / Total 44</p>
								</div>
								<br>
								<div class="progress progress-small mb-3" style="height:30px">
									<div style="width: 60%;height:30px" class="progress-bar"></div>
								</div>
								<span>Available 21</span>
							</div>
						</div>
						<div class="hr-line-dashed my-0"></div>


						<div class="form-group row mt-1">
							<label class="col-sm-4 col-form-label">Works for</label>
							<div class="col-sm-8"><label class="col-form-label">Multiple courses (3)</label></div>
						</div>
						<div class="hr-line-dashed my-0"></div>

						<div class="form-group row mt-1">
							<label class="col-sm-4 col-form-label">Created date</label>
							<div class="col-sm-8"><label class="col-form-label">2022/7/5 13:55 PM</label></div>
						</div>
						<div class="hr-line-dashed my-0"></div>



                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Submit status</label>
                            <div class="col-sm-8">
                                <div class="i-checks mt-3">
                                    <label> <input type="radio" value="draft" name="subject_stat" checked disabled> <i></i> Draft </label>
                                </div>
                                <div class="i-checks">
                                    <label> <input type="radio" value="published" name="subject_stat" disabled> <i></i> Published </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed my-0"></div>

						<div class="panel-group mt-3" id="accordion" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default">
								<div class="panel-heading bg-blue-500" role="tab" id="" style="padding: 6px 15px;background: #179a7f;color: #fff;">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
											<i class="more-less glyphicon glyphicon-plus"></i>
											<span class="ml-5 text-base">View this cuponn code usage</span>
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
															<div>
																<table class="table table-condensed">
																	<thead>
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
