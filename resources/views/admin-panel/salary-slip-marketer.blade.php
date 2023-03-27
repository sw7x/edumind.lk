
@extends('admin-panel.layouts.master',['title' => 'Salary slip'])
@section('title','Salary slip')


@section('css-files')    
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">
@stop


@section('page-css')
    
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
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Amount</label>
                        <div class="col-sm-9">
                            <label class="col-form-label">Rs 5000</label>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Time period</label>
                        <div class="col-sm-9">
                            <label class="col-form-label">2022/08/04 - 2022/08/04</label>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Salary slip image</label>
                        <div class="col-sm-9">
                            <a class="no-clickable popup-img effect" href="{{asset('images/salary-slip.jpg')}}" data-effect="mfp-zoom-in">
                                <img src="{{asset('images/salary-slip.jpg')}}" width="100%" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Enrollments</label>
                        <div class="col-sm-9">
                            <table class="table table-striped table-bordered mb-0">
                                <thead  class="thead-dark">
                                    <tr>
                                        <th>Enrollement </th>
                                        <th>Comission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-bold text-base"><a href="hhh" target="_blank">ABC123 <i class="ml-1 fa fa-external-link" aria-hidden="true"></i></a></td>
                                        <td class="font-bold text-base text-red-500">RS 2000</td>
                                    </tr>

                                    <tr>
                                        <td class="font-bold text-base"><a href="hhh" target="_blank">CCC123 <i class="ml-1 fa fa-external-link" aria-hidden="true"></i></a></td>
                                        <td class="font-bold text-base text-red-500">RS 2000</td>
                                    </tr> 

                                    <tr>
                                        <td class="font-bold text-base"><a href="hhh" target="_blank">FBC173 <i class="ml-1 fa fa-external-link" aria-hidden="true"></i></a></td>
                                        <td class="font-bold text-base text-red-500">RS 2500</td>
                                    </tr>
                                </tbody>
                            </table>                      
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>


                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Remarks</label>
                        <div class="col-sm-9">
                            <p class="text-base font-bold">Note that you can also use other methods provided by the Carbon library to perform other types of date calculations, such as adding or subtracting days, weeks, months, years, etc.</p>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>


                </div>
            </div>

            
        </div>
    </div>
@stop



@section('script-files')
    <!-- Magnific Popup core JS file -->
    <script src="{{asset('admin/js/jquery.magnific-popup.min.js')}}"></script>
@stop


@section('javascript')
<script>

    $(document).ready(function() {

        $('a.popup-img').magnificPopup({
			type: 'image',
			closeBtnInside: true,
			closeOnContentClick: true,
			tLoading: '', // remove text from preloader
			fixedContentPos : false,
			/* don't add this part, it's just to disable cache on image and test loading indicator */
			callbacks: {
				beforeChange: function() {
					this.items[0].src = this.items[0].src + '?=' + Math.random();
				},
				beforeOpen: function() {
					this.st.mainClass = this.st.el.attr('data-effect');
				},
				open: function() {
					jQuery('body').addClass('noscroll');
				},
				close: function() {
					jQuery('body').removeClass('noscroll');
				}
			},
			//removalDelay: 500, //delay removal by X to allow out-animation
			mainClass: 'mfp-with-fade',
		});
    });

</script>
@stop