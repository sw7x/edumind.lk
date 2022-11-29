@extends('admin-panel.layouts.master',['title' => 'Cupon code usage'])
@section('title','Dashboard')

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
					    			<p class="font-bold text-base pb-1 text-right">Used : 2021/10/02 16:40 PM</p>
					    		</div>
					    		<div class="row">
					    			<div class="col-md-2">
					    				<img src="https://i.imgur.com/QpjAiHq.jpg" class="img-fluid rounded-start" alt="...">
					    			</div>
					    			<div class="col-md-10">
					    				<div class="card-body p-0 row">					    					
						                    <div class="col-md-6 mt-1 px-3">
						                    	<div class="">
						                    		<p class="font-bold text-xl mb-1">Amsterdam Walking Tour</p>
						                    	</div>
						                    	
						                    	<div class="mt-1 mb-1 spec-1 text-sm">Teacher : A.B.C Saman Hettiarachchi</div>
						                    	<div class="mt-1 mb-1 spec-1 text-sm">Student : F.C Nimal Hettiarachchi</div>			                    
						                    	<div class="text-justify mt-1 text-lg font-bold text-black">Cupon code : ABC4445</div>
												<div class="mt-1 mb-1 spec-1 text-sm">Paid</div>
						                    </div>
						                    <div class="col-md-6 align-items-center align-content-center border-left mt-1">
						                    	<div class="d-flex flex-column mt-4">
						                    		<p class="line-through text-xl font-semibold">RS 6000.00</p>
						                    		<p class="text-xl text-red font-semibold">-10%</p>
						                    		<p class="text-xl font-semibold">RS 5000.00</p>
						                    		<p class="text-xl font-semibold">RS 50.00</p>
						                    	</div>
						                    </div>
					    				</div>
					    			</div>
					    		</div>
					    	</div>



							<div class="card mb-4 p-1">
								<div class="ribbon-2">
									<p class="font-bold text-base pb-1 text-right">Used : 2021/10/02 16:40 PM</p>
								</div>
								<div class="row">
									<div class="col-md-2">
										<img src="https://i.imgur.com/JvPeqEF.jpg" class="img-fluid rounded-start" alt="...">
									</div>
									<div class="col-md-10">
										<div class="card-body p-0 row">
											<div class="col-md-6 mt-1 px-3">
												<div class="">
													<p class="font-bold text-xl mb-1">Amsterdam Walking Tour</p>
												</div>

												<div class="mt-1 mb-1 spec-1 text-sm">Teacher : A.B.C Saman Hettiarachchi</div>
												<div class="mt-1 mb-1 spec-1 text-sm">Student : F.C Nimal Hettiarachchi</div>
												<div class="text-justify mt-3 text-xl font-bold text-black">Cupon code : ABC4445</div>
											</div>
											<div class="col-md-6 align-items-center align-content-center border-left mt-1">
												<div class="d-flex flex-column mt-4">
													<p class="line-through text-2xl font-semibold">RS 6000.00</p>
													<p class="text-xl text-red font-semibold">-10%</p>
													<p class="text-xl font-semibold">RS 5000.00</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card mb-4 p-1">
								<div class="ribbon-2">
									<p class="font-bold text-base pb-1 text-right">Used : 2021/10/02 16:40 PM</p>
								</div>
								<div class="row">
									<div class="col-md-2">
										<img src="https://i.imgur.com/Bf4dIaN.jpg" class="img-fluid rounded-start" alt="...">
									</div>
									<div class="col-md-10">
										<div class="card-body p-0 row">
											<div class="col-md-6 mt-1 px-3">
												<div class="">
													<p class="font-bold text-xl mb-1">Amsterdam Walking Tour</p>
												</div>

												<div class="mt-1 mb-1 spec-1 text-sm">Teacher : A.B.C Saman Hettiarachchi</div>
												<div class="mt-1 mb-1 spec-1 text-sm">Student : F.C Nimal Hettiarachchi</div>
												<div class="text-justify mt-3 text-xl font-bold text-black">Cupon code : ABC4445</div>
											</div>
											<div class="col-md-6 align-items-center align-content-center border-left mt-1">
												<div class="d-flex flex-column mt-4">
													<p class="line-through text-2xl font-semibold">RS 6000.00</p>
													<p class="text-xl text-red font-semibold">-10%</p>
													<p class="text-xl font-semibold">RS 5000.00</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card mb-4 p-1">
								<div class="ribbon-2">
									<p class="font-bold text-base pb-1 text-right">Used : 2021/10/02 16:40 PM</p>
								</div>
								<div class="row">
									<div class="col-md-2">
										<img src="https://i.imgur.com/HO8e9b8.jpg" class="img-fluid rounded-start" alt="...">
									</div>
									<div class="col-md-10">
										<div class="card-body p-0 row">
											<div class="col-md-6 mt-1 px-3">
												<div class="">
													<p class="font-bold text-xl mb-1">Amsterdam Walking Tour</p>
												</div>

												<div class="mt-1 mb-1 spec-1 text-sm">Teacher : A.B.C Saman Hettiarachchi</div>
												<div class="mt-1 mb-1 spec-1 text-sm">Student : F.C Nimal Hettiarachchi</div>
												<div class="text-justify mt-3 text-xl font-bold text-black">Cupon code : ABC4445</div>
											</div>
											<div class="col-md-6 align-items-center align-content-center border-left mt-1">
												<div class="d-flex flex-column mt-4">
													<p class="line-through text-2xl font-semibold">RS 6000.00</p>
													<p class="text-xl text-red font-semibold">-10%</p>
													<p class="text-xl font-semibold">RS 5000.00</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="card mb-4 p-1">
								<div class="ribbon-2">
									<p class="font-bold text-base pb-1 text-right">Used : 2021/10/02 16:40 PM</p>
								</div>
								<div class="row">
									<div class="col-md-2">
										<img src="https://i.imgur.com/QpjAiHq.jpg" class="img-fluid rounded-start" alt="...">
									</div>
									<div class="col-md-10">
										<div class="card-body p-0 row">
											<div class="col-md-6 mt-1 px-3">
												<div class="">
													<p class="font-bold text-xl mb-1">Amsterdam Walking Tour</p>
												</div>

												<div class="mt-1 mb-1 spec-1 text-sm">Teacher : A.B.C Saman Hettiarachchi</div>
												<div class="mt-1 mb-1 spec-1 text-sm">Student : F.C Nimal Hettiarachchi</div>
												<div class="text-justify mt-3 text-xl font-bold text-black">Cupon code : ABC4445</div>
											</div>
											<div class="col-md-6 align-items-center align-content-center border-left mt-1">
												<div class="d-flex flex-column mt-4">
													<p class="line-through text-2xl font-semibold">RS 6000.00</p>
													<p class="text-xl text-red font-semibold">-10%</p>
													<p class="text-xl font-semibold">RS 5000.00</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>



							<div class="row mt-5">
								<ul class="pagination justify-content-end">
									<li class="page-item disabled">
										<a class="page-link" href="#" tabindex="-1">Previous</a>
									</li>
									<li class="page-item"><a class="page-link" href="#">1</a></li>
									<li class="page-item"><a class="page-link" href="#">2</a></li>
									<li class="page-item"><a class="page-link" href="#">3</a></li>
									<li class="page-item">
										<a class="page-link" href="#">Next</a>
									</li>
								</ul>
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


