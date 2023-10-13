@extends('layouts.master')
@section('title','Student registration')



@section('css-files')
<!-- sweetalert2 CSS file-->
<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
@stop




@section('page-css')
    <style>
        input , .bootstrap-select.btn-group button{
            background-color: #f3f4f6  !important;
            height: 40px  !important;
            box-shadow: none  !important;
        }
    </style>
@stop

@section('content')
    <div class="main-container container">
        <div class="__lg:p-12 max-w-xl lg:my-0 my-12 mx-auto __p-6 space-y-">
            
            @if ($errors->studentReg->getMessages())
                <x-flash-message 
                    style="margin-bottom:0px;"
                    class="flash-danger rounded-none"  
                    title="Form submit error!" 
                    message=""  
                    message2=""  
                    :canClose="true" >
                    <x-slot name="insideContent">
                        <ul class="list-disc">
                            @foreach ($errors->studentReg->getMessages() as  $field => $errorMsgArr)
                                @foreach ($errorMsgArr as $errorMsg)
                                    <li class="text-sm ml-3">{{ $errorMsg }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    </x-slot>    
                </x-flash-message>
            @endif

            @if(Session::has('message'))
                <x-flash-message  
                    :class="Session::get('cls', 'flash-info').' rounded-none'"  
                    :title="Session::get('msgTitle') ?? 'Info!'" 
                    :message="Session::get('message') ?? ''"  
                    :message2="Session::get('message2') ?? ''"  
                    :canClose="true" />
            @endif
            
            
            <form class="lg:p-10 p-6 space-y-3 relative bg-white shadow-xl rounded-md __uk-form student-reg"
                  method="post" action="{{route('auth.register-submit')}}">

                <h1 class="lg:text-2xl text-xl font-semibold mb-6">Register </h1>
                
                <div class="text-base"><span class="font-bold text-red-500 text-lg">*</span> - Required Information </div>

                <div>
                    <input value="{{old('full_name')}}" type="text" placeholder="Full Name *" name="full_name" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" required minlength="3" maxlength="100">
                    <div class="error-msg"></div>
                </div>

                <div>
                    <input value="{{old('username')}}" type="text" placeholder="Username (leave blank if you want to use email as username)" name="username" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                    <div class="error-msg"></div>
                </div>

                <div>
                    <input value="{{old('email')}}" type="email" placeholder="Email *" name="email" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" required>
                    <div class="error-msg"></div>
                </div>

                <div class="password-container">
                    <input type="password" placeholder="Password (6 to 12 alpha numeric characters) *" name="password"
                           class="password_field bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" required maxlength="12" minlength="6">
                    <button type="button" id="btnToggle" class="pw-toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                    <div class="error-msg"></div>
                </div>                    

                <div>
                    <input value="{{old('phone')}}" type="text" name="phone" placeholder="Phone *" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" required>
                    <div class="error-msg"></div>
                </div>

                <div class="grid lg:grid-cols-2 gap-3 mt-3">
                    <div>
                        <div>
                            <label id="lbl2" class="control-label" for="dob2">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                            <select class="selectpicker" name="gender">
                                <option value="male">Male</option>
                                <option {{ old('gender') == 'female' ? "selected" : "" }} value="female">Female</option>
                            </select>
                        </div>
                        <div class="error-msg"></div>
                    </div>
                    <div class="">
                        <!-- todo date validate -->
                        <!--
                        <label id="lbl2" class="control-label" for="dob2">Date of Birth</label>
                        <div class="controls">
                            <input type="text" id="dob2" style="width: 9em;">
                        </div>
                        -->
                        <label for="inputDate">Date of birth (Year)</label>
                        <input value="{{old('dob_year')}}" type="text" class="form-control px-3" name="dob_year" required>
                        <div class="error-msg"></div>
                    </div>
                </div>
                
                <div class="col-span-2">
                    <div id='recaptcha_element' class="recaptcha_box"></div>
                    <input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
                    <div class="error-msg"></div>

                    <span id="recaptcha-error" class="invalid-feedback">
                        <span class="font-bold text-red text-sm">Captcha is required</span>
                    </span>
                </div>

                <div class="checkbox">
                    <input type="checkbox" name="check-agree" id="stud-check-agree" class="check-agree" checked>
                    <label for="stud-check-agree">
                        <span class="checkbox-icon"></span>
                        I agree to the <a class="text-blue-500" href="{{route('terms-and-services')}}" target="_blank"> Terms and Conditions </a>
                    </label>
                </div>

                <div class="grid md:grid-cols-2 gap-3">
                    <div>
                        <button type="submit" class="submit-btn btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Submit</button>
                    </div>
                    <div>
                        <button type="reset" class="reset-btn btn bg-red-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white w-full">Clear</button>
                    </div>
                </div>

                {{csrf_field ()}}

                <div class="font-semibold text-center text-sm">Already have an account? <a class="text-blue-600" href="{{route('auth.login')}}">Sign In</a></div>

            </form>

        </div>
    </div>
@stop


@section('script-files')
<!-- sweetalert2 js file-->
<script src="{{asset('js/sweetalert2.min.js')}}"></script>


<script src="//www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

<!-- jquery form validation js file-->
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

        //form validations
        var validator =  $("form.student-reg").validate({
            focusInvalid: false,
            rules:{
                full_name   :{required: true,minlength:3,maxlength:100},                
                email       :{required: true,email:true},
                password    :{required: true,minlength: 6,maxlength:12},
                phone       :{required: true},
                gender      :{required: true},
                dob_year    :{required: true,range:[(new Date().getFullYear()-120),new Date().getFullYear()]},
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
                dob_year        :   {range:"Invalid Birth Year"},
                hiddenRecaptcha :   {required:"Please confirm captcha to proceed"},
            },
            submitHandler: function(form){
                //student reg form agree to the Terms and Conditions validation
                let isAgree = $('form.student-reg input[type=\'checkbox\'].check-agree').is(":checked");

                if(isAgree == true){

                    var response = grecaptcha.getResponse();

                    //recaptcha failed validation
                    if (response.length == 0) {
                        $('#recaptcha-error').show();
                        return false;
                    }
                    //recaptcha passed validation
                    else {
                        $('#recaptcha-error').hide();
                        form.submit();
                        //return true;
                    }
                                        
                }else{
                    //alert('Cannot proceed without agreeing Terms and Conditions');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Cannot proceed without agreeing Terms and Conditions!',
                    });
                }
                    
            },
            invalidHandler: function(form, validator) {
                if (!validator.numberOfInvalids()){
                    //return;
                }
            },
            errorPlacement: function(error, element)
            {
                //console.log(error);
                error.appendTo(element.parent().find('.error-msg'));
                element.parent().find('.error-msg').css('color','red');
                element.parent().find('.error-msg').css('fontSize','12px');
                error.css('margin','0px');
            }
        });


        $("form.student-reg").find("button.reset-btn").click(function() {            
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