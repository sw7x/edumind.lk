@extends('layouts.master')
@section('title','billing information')

@section('css-files')
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('page-css')
<style type="text/css">
    .error-msg{
        min-height: 20px;
        margin-left: 5px;
    }

    .error-msg label{
        margin-bottom: 0px;
    }

</style>
@stop




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">

            @if(Session::has('message'))
                <x-flash-message
                    class="{{ Session::get('cls', 'flash-info')}}" 
                    :title="Session::get('msgTitle')"
                    :message="Session::get('message')">
                    <x-slot name="insideContent">
                        @if ($errors->billingInfo->getMessages())
                            <ul class="mt-3 mb-4 ml-4 list-disc text-xs text-red-600 font-bold">
                                @foreach ($errors->billingInfo->getMessages() as $field => $errorMsgArr)
                                    @foreach ($errorMsgArr as $errorMsg)
                                        <li class="">{{ $errorMsg }}</li>
                                    @endforeach
                                @endforeach
                            </ul>
                        @endif
                    </x-slot>
                </x-flash-message>            
            @endif 
            
            <x-flash-message
                class="flash-info"
                title='Cart'
                message="Summary of your cart"
                :canClose="false"
                >
                <x-slot name="insideContent">                    
                    <ul class="mt-3 mb-4 ml-4 list-disc text-sm __text-red-600">
                        <li class="">12 courses</li>
                        <li class=""><span class="inline-block w-1/10">Subtotal</span> <span class="text-red-500">: + Rs 578298</span></li>
                        <li class=""><span class="inline-block w-1/10">Discount</span> <span class="text-red-500">: - Rs 6523.60</span></li>
                        <li class="mt-2"><span class="inline-block w-1/10">Total</span>    <span class="text-red-500">: + Rs 571774.4</span></li>
                    </ul>
                </x-slot>                    
            </x-flash-message>
            




            <form class="bill-info" id="bill-info" action="{{route('submit-billing-info')}}" 
                    method="POST" autocomplete="off">
                <div class="shadow bg-white grid grid-cols-2 gap-3 lg:p-6 p-4 wrapper">
                    <div class="col-span-2">
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Billing details Page</h2>
                        <hr class="mb-5">
                    </div>

                    @csrf

                    <div>
                        <label class="text-sm font-medium" for="first-name">First name <span class="text-red-500 text-lg">*</span></label>
                        <input type="text" placeholder="" name="fname" class="shadow-none with-border" maxlength="15">
                        <div class="error-msg"></div>
                    </div>

                    <div class="">
                        <label class="text-sm font-medium" for="lname">Last name <span class="text-red-500 text-lg">*</span></label>
                        <input name="lname" type="text" class="form-control shadow-none with-border" maxlength="15">
                        <div class="error-msg"></div>
                    </div>

                    <div>
                        <label class="text-sm font-medium" for="email">E-mail Address <span class="text-red-500 text-lg">*</span></label>
                        <input name="email" type="email" class="form-control shadow-none with-border">
                        <div class="error-msg"></div>
                    </div>
                    
                    <div class="form-group">
                        <label class="text-sm font-medium" for="phone">Phone Number <span class="text-red-500 text-lg">*</span></label>
                        <input name="phone" type="text" class="form-control shadow-none with-border">
                        <div class="error-msg"></div>    
                    </div> 


                    <div class="">
                        <label class="text-sm font-medium" for="country">Country <span class="text-red-500 text-lg">*</span></label>
                        <div>
                            <x-country-dropdown id="country" name="country" cls="__selectpicker" req="required">                                
                            </x-country-dropdown>
                            <div class="error-msg"></div>
                        </div>
                    </div>

                    <div class="">
                        <label class="text-sm font-medium" for="city">City <span class="text-red-500 text-lg">*</span></label>
                        <input name="city" type="text" class="form-control shadow-none with-border" maxlength="25">
                        <div class="error-msg"></div>
                    </div>

                    <div class="col-span-2">
                        <label class="text-sm font-medium" for="street_address">Street Address <span class="text-red-500 text-lg">*</span></label>
                        <input name="street_address" type="text" class="form-control shadow-none with-border">
                        <div class="error-msg"></div>
                    </div>

                   <!--  <div class="col-span-2">
                        <button name="submit" type="submit" class="btn-w-m bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Place Order</button>
                        <button name="clear" type="reset" class="btn-w-m bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded min-w-min">Clear</button>
                    </div> -->
                </div>

                <div class="grid grid-cols-2 md:gap-6 gap-3 md:mt-10 mt-5">
                    <a class="bg-gray-200 flex font-medium items-center justify-center py-3 rounded-md" href="{{route('view-cart')}}">
                        <i class="icon-feather-chevron-left mr-1"></i>
                        <span class="">Back to Cart</span>
                    </a>
                    <!-- <a class="bg-blue-600 text-white flex font-medium items-center justify-center py-3 rounded-md hover:text-white" 
                        onclick="document.getElementById('bill-info').submit()">
                        <span class="text-white"> Pay using credit card</span>
                        <i class="text-white icon-feather-chevron-right ml-1"></i>
                    </a> -->

                    <button class="w-full py-3 rounded-md bg-blue-600 hover:bg-blue-700 text-white font-medium text-base block" type="submit">
                        <span class="text-white"> Pay using credit card</span>
                        <i class="text-white icon-feather-chevron-right ml-1"></i>
                    </button>
                </div>

                <input type="hidden" name="from" value="{{route('billing-info')}}">
            </form>

        </div>
    </div>
@stop

@section('script-files')
     <!-- jquery form validation js file-->
    <script src="{{asset('js/jquery-validation-1.19.3/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/jquery-validation-1.19.3/additional-methods.min.js')}}"></script>
    <script src="{{asset('js/jquery-validation-1.19.3/custom-additional-methods.js')}}"></script>
    
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stop



@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        

        /*
        jquery.validate ignores hidden fields by default, not validating them.
        To turn it back on simply do the following:
        */
        $.validator.setDefaults({ ignore: '' });

        var validator =  $("#bill-info").validate({                       
            //ignore: [],
            onkeyup: false,
            errorClass: "validationErrorCls",
            //focusInvalid: false,
            rules:{                
                'fname'         :{required: true, minlength:3, maxlength:15},
                'lname'         :{required: true, minlength:3, maxlength:15},
                'email'         :{required: true, email:true},
                'phone'         :{required: true, phone:true},
                'country'       :{required: true},
                'city'          :{required: true, maxlength:25},
                'street_address':{required: true},
            },
            messages:{
                'fname'         :{
                    required : 'First name is required', 
                    minlength: 'First name value must be at least 3 characters long', 
                    maxlength: 'First name value must not exceed 15 characters in length'
                },
                'lname'         :{
                    required  : 'Last name is required', 
                    minlength : 'Last name value must be at least 3 characters long', 
                    maxlength : 'Last name value must not exceed 15 characters in length'
                },
                'email'         :{
                    required: 'Email is required', 
                    email   : 'This should be a email address'
                },
                'phone'         :{
                    required: 'Phone is required', 
                    phone   : 'This should be a phone number'
                },
                'country'       :{
                    required: 'Country is required'
                },
                'city'          :{
                    required : 'City is required', 
                    maxlength: 'City value must not exceed 15 characters in length'
                },
                'street_address':{
                    required: 'Street sddress is required'
                }
            },
            submitHandler: function(form){
                console.log('submitHandler');
                form.submit();
            },
            invalidHandler: function(form, validator) {
                if (!validator.numberOfInvalids()){
                    //return;
                }
            },
            errorPlacement: function (error, element)
            {
                var elementName = $(element).attr("name");
                //console.log(element);
                //console.log(error);
                //console.log(error.text());
                //element.before(error);
                //element.after(error);
                                  
                if(elementName == 'country'){
                    $errMsgDiv = element.parent().parent().find('.error-msg');                   
                }else{
                    $errMsgDiv = element.parent().find('.error-msg');                    
                }

                error.appendTo($errMsgDiv);
                $errMsgDiv.find('label').css('color','red');
                $errMsgDiv.find('label').css('fontSize','13px');                               
            }

        });    
        
        $('select[name="country"]').select2({
            placeholder: "Please select a country",
            allowClear: true,
            width: '100%'
        });



        
       

















        $('select[name="country"]').on('change',function(event){
            validator.element('select[name="country"]');
            //alert();
        });


        console.log(validator);
        console.log('validator');


    });
</script>
@stop