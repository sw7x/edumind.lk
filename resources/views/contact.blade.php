@extends('layouts.master')
@section('title','Contact-us')




@section('content')
    <div class="main-container container pb-20 contact-page">

        <h1 class="md:text-2xl text-xl leading-none font-semibold tracking-tight my-3">Contact Us</h1>
        @php
            //var_dump($userArr);
        @endphp

        <div class="grid lg:grid-cols-4 mt-12 gap-8">

            <div class="col-span-2">
                <h3 class="text-xl mb-2 font-semibold">Connect with us</h3>
                {{--
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                --}}
                <br>
                <div class="row d-flex contact-details">
                    <div class="col-md-12 col-sm-12 pr-md-0 mb-5">
                        <div class="glyph fs1">
                            <div class="clearfix bshadow0 pbs">
                                <span class="icon icon-feather-phone-incoming"></span>
                                <span class="mls"><a href="tel:+94771755556">+94771755556</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 pr-md-0 mb-5">
                        <div class="glyph fs1">
                            <div class="clearfix bshadow0 pbs">
                                <span class="icon icon-feather-mail"></span>
                                <span class="mls"><a href="mailto:info@abc.lk">info@abc.lk</a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 pr-md-0 mb-5">
                        <div class="glyph fs1">
                            <div class="clearfix bshadow0 pbs">
                                <span class="icon icon-feather-map-pin"></span>
                                <span class="mls"><address>402, Galle Road, Colombo 03</address></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-md lg:shadow-md shadow col-span-2 lg:mx-4">
                <form action="{{route('contact-us.submit')}}" method="post" id="contact-form">
                    
                    @if(Session::has('message'))
                        <x-flash-message  
                            :class="Session::get('cls', 'flash-info')"  
                            :title="Session::get('msgTitle') ?? 'Info!'" 
                            :message="Session::get('message') ?? ''"  
                            :message2="Session::get('message2') ?? ''"  
                            :canClose="true" >
                            <x-slot name="insideContent">
                                @if (count($errors) > 0)
                                    <br>
                                    <ul class="list-disc ml-2">
                                        @foreach ($errors as $error)
                                            <li class="text-sm ml-3">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </x-slot>
                        </x-flash-message>
                    @endif


                    <div class="grid grid-cols-2 gap-0 lg:p-6 p-2">
                        <h3 class="text-xl mb-2 font-semibold">Contact Form</h3>
                        @if(isset($userArr['full_name']))
                            <input type="hidden" name="full_name_hidden" value="{{ $userArr['full_name'] }}">
                        @else
                            <div class="col-span-2">
                                <input type="text" placeholder="Full Name  (required)" name="full_name" class="shadow-none with-border" value="{{ old('full_name') }}">
                                <div class="error-msg" style="min-height:1.25rem"></div>
                            </div>
                        @endif

                        @if(isset($userArr['email']))
                            <input type="hidden" name="email" value="{{ $userArr['email'] }}">
                        @else
                            <div class="col-span-2 mb-5">
                                <input type="text" placeholder="Email" name="email" class="shadow-none with-border" value="{{old('email')}}">
                            </div>
                        @endif

                        <div class="col-span-2">
                            <input type="text" placeholder="Subject   (required)" name="subject" class="shadow-none with-border" value="{{old('subject')}}" minlength="3" maxlength="50">
                            <div class="error-msg" style="min-height:1.25rem"></div>
                        </div>

                        @if(isset($userArr['phone']))
                            <input type="hidden" name="phone" value="{{ $userArr['phone'] }}">
                        @else
                            <div class="col-span-2 mb-5">
                                <input type="text" placeholder="Phone" name="phone" class="shadow-none with-border" value="{{old('phone')}}">
                            </div>
                        @endif

                        <div class="col-span-2">
                            <textarea id="about" name="message" cols="30" rows="7" class="with-border" placeholder="Message  (required)">{{old('message')}}</textarea>
                            <div class="error-msg" style="min-height:1.25rem"></div>
                        </div>

                        <div class="col-span-2">
                            <div id='recaptcha_element' class="recaptcha_box"></div>
                            <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
                            <div class="error-msg"></div>

                            <span id="recaptcha-error" class="invalid-feedback">
                                <span class="font-bold text-red text-sm">Captcha is required</span>
                            </span>
                        </div>


                        <input type="hidden" name="user_id" value="{{ $userArr['id'] ?? null }}">


                        {{csrf_field ()}}

                        <div class="grid md:grid-cols-2 gap-3 buttons-div">
                            <div>
                                <button type="submit" class="btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Submit</button>
                            </div>
                            <div>
                                <button type="reset" class="reset-btn btn bg-red-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Clear</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>

        </div>


    </div>
@stop


@section('script-files')
    {{--
        <script src="//www.google.com/recaptcha/api.js" async defer></script>

        --}}
    <script src="//www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <script src="{{asset('js/jquery-validation-1.19.3/jquery.validate.min.js')}}"></script>
@stop

@section('javascript')
    <script type="text/javascript">
		$('#recaptcha-error').hide();

        //Recaptcha render callback
		var onloadCallback = function() {
			grecaptcha.render('recaptcha_element', {
				'sitekey' : "{{config('services.recaptcha.site-key')}}",
				'callback' : correctCaptcha
			});
		};

		//after reCAPTCHA submission response will then be sent to the 'correctCaptcha' function.
		var correctCaptcha = function(response) {
			//alert(response);
			//alert('delete error msg');
			$('#hiddenRecaptcha-error').hide();
			//delete error msg
		};


		// Wait for the DOM to be ready
		$(document).ready(function() {

            //form elements disable caching  values
			$("form :input").attr("autocomplete", "off");

            /*
            jquery.validate ignores hidden fields by default, not validating them.
			To turn it back on simply do the following:
			*/
            $.validator.setDefaults({ ignore: '' });

		    //inquiry form validations
			var validator =  $("#contact-form").validate({
				focusInvalid: false,
				rules:{
					full_name  :  {
						required: function(element) {
							return $("input[name='full_name']").length;
						}
					},
                    subject:    {required: true,minlength: 3,maxlength:50},
					message:    {required: true},
					hiddenRecaptcha: {
						required: function () {
							if (grecaptcha.getResponse() == '') {
								return true;
							} else {
								return false;
							}
						}
					}
                },
				messages:{
					full_name       :   {required:"Full name is required"},
					subject         :   {required:"Subject is required"},
					message         :   {required:"Message is required"},
					hiddenRecaptcha :   {required:"Please confirm captcha to proceed"},
                },
				submitHandler: function(form){
					
                    var response = grecaptcha.getResponse();

					//recaptcha failed validation
					if (response.length == 0) {
						$('#recaptcha-error').show();
						return false;
					}
					//recaptcha passed validation
					else {
						$('#recaptcha-error').hide();
						return true;
					}
				},
				invalidHandler: function(form, validator) {
					if (!validator.numberOfInvalids()){
						//return;
					}
				},
				errorPlacement: function(error, element)
				{
					console.log(error);
					/*

					//console.log(element.attr('name'));

					//offset = element.offset();
					//error.insertAfter(element);
					//eleName = element.attr('name');
					element.parent().find('.error-msg').text(error.text());
					//error.appendTo();
					//error.appendTo(element.parent());
					element.parent().find('.error-msg').css('color','red');
					element.parent().find('.error-msg').css('fontSize','12px');
					element.parent().find('.error-msg').addClass('mb-2');
					element.parent().find('.error-msg').addClass('ml-2');
				    */
					error.addClass('ml-2');
					error.appendTo(element.parent().find('.error-msg'));

					//error.appendTo(element.parent());
					error.css('color','red');
					error.css('fontSize','12px');
				}
			});


			$("#contact-form").find("button.reset-btn").click(function() {

				$(':input')
					.not(':button, :submit, :reset, :hidden, .i-checks :radio')
					.val('')
					.removeAttr('checked')
					.removeAttr('selected');

				//var validator = $("#contact-form").validate();
				validator.resetForm();
				grecaptcha.reset();
				e.preventDefault();
			});

		});








    </script>
@stop










