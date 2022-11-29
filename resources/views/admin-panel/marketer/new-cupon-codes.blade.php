@extends('admin-panel.layouts.master',['title' => 'New cupon codes'])
@section('title','New cupon code')

@section('css-files')
@stop


@section('page-css')
<style type="text/css">
	.ribbon-2 {
		--f: 10px;
	    --r: 10px;
	    --t: -5px;
	    position: absolute;
	    inset: var(--t) calc(-1*var(--f)) auto auto;
	    padding: 5px 30px var(--f) calc(50px + var(--r));
	    clip-path: polygon(0 0,100% 0,100% calc(100% - var(--f)),calc(100% - var(--f)) 100%, calc(100% - var(--f)) calc(100% - var(--f)),0 calc(100% - var(--f)), var(--r) calc(50% - var(--f)/2));
	    box-shadow: 0 calc(-1*var(--f)) 0 inset #0005;
		background-color: #f1c40f;
	}
</style>
@stop

@section('content')

	<div class="row" id="_sortable-view">
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
					<div class="container mt-2 mb-5">					    
					    <div class="col-md-12">
					    	<div class="card mb-4 p-1">
					    		<div class="ribbon-2">
					    			<p class="font-bold text-base pb-1 text-right">CODE : ABC1234</p>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-12">
					    				<div class="card-body p-0">
						                    <div class="mt-1 px-3">
												<div class="d-flex">
													<div class="font-semibold text-sm mr-5">Discount precentage : 10%</div>
													<div class="font-semibold text-sm mr-5">Count : 33</div>
													<div class="font-semibold text-sm">Created date : 2022/7/16 06:45 PM</div>
												</div>

												<div class="d-flex">
													<div class="mt-1 text-sm mr-5">Works for : Any course</div>
												</div>
						                    </div>
					    				</div>
					    			</div>
					    		</div>
					    	</div>

							<div class="card mb-4 p-1">
								<div class="ribbon-2">
									<p class="font-bold text-base pb-1 text-right">CODE : ABC1234</p>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="card-body p-0">
											<div class="mt-1 px-3">
												<div class="d-flex">
													<div class="font-semibold text-sm mr-5">Discount precentage : 10%</div>
													<div class="font-semibold text-sm mr-5">Count : 33</div>
													<div class="font-semibold text-sm">Created date : 2022/7/16 06:45 PM</div>
												</div>

												<div class="d-flex">
													<div class="mt-1 text-sm mr-5">Works for : Any course</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card mb-4 p-1">
								<div class="ribbon-2">
									<p class="font-bold text-base pb-1 text-right">CODE : ABC1234</p>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="card-body p-0">
											<div class="mt-1 px-3">
												<div class="d-flex">
													<div class="font-semibold text-sm mr-5">Discount precentage : 10%</div>
													<div class="font-semibold text-sm mr-5">Count : 33</div>
													<div class="font-semibold text-sm">Created date : 2022/7/16 06:45 PM</div>
												</div>

												<div class="d-flex">
													<div class="mt-1 text-sm mr-5">Works for : Any course</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card mb-4 p-1">
								<div class="ribbon-2">
									<p class="font-bold text-base pb-1 text-right">CODE : ABC1234</p>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="card-body p-0">
											<div class="mt-1 px-3">
												<div class="d-flex">
													<div class="font-semibold text-sm mr-5">Discount precentage : 10%</div>
													<div class="font-semibold text-sm mr-5">Count : 33</div>
													<div class="font-semibold text-sm">Created date : 2022/7/16 06:45 PM</div>
												</div>

												<div class="d-flex">
													<div class="mt-1 text-sm mr-5">Works for : Any course</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card mb-4 p-1">
								<div class="ribbon-2">
									<p class="font-bold text-base pb-1 text-right">CODE : ABC1234</p>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="card-body p-0">
											<div class="mt-1 px-3">
												<div class="d-flex">
													<div class="font-semibold text-sm mr-5">Discount precentage : 10%</div>
													<div class="font-semibold text-sm mr-5">Count : 33</div>
													<div class="font-semibold text-sm">Created date : 2022/7/16 06:45 PM</div>
												</div>

												<div class="d-flex">
													<div class="mt-1 text-sm mr-5">Works for : Any course</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card mb-4 p-1">
								<div class="ribbon-2">
									<p class="font-bold text-base pb-1 text-right">CODE : ABC1234</p>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="card-body p-0">
											<div class="mt-1 px-3">
												<div class="d-flex">
													<div class="font-semibold text-sm mr-5">Discount precentage : 10%</div>
													<div class="font-semibold text-sm mr-5">Count : 33</div>
													<div class="font-semibold text-sm">Created date : 2022/7/16 06:45 PM</div>
												</div>

												<div class="d-flex">
													<div class="mt-1 text-sm mr-5">Works for : Any course</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>					     
					</div>			
				</div>
			</div>
			
		</div>
	</div>
	<div class="hr-line-dashed"></div>





@stop




@section('script-files')

@stop


@section('javascript')

@stop


