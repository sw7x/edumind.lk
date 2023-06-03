@extends('layouts.master')
@section('title','Pay with credit card')


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
            
            <x-flash-message
                class="flash-info"
                title='Cart'
                message="Summary of your cart"
                :canClose="false">
                <x-slot name="insideContent">                    
                    <ul class="mt-3 mb-4 ml-4 list-disc text-sm __text-red-600">
                        <li class="">12 courses</li>
                        <li class=""><span class="inline-block w-1/10">Subtotal</span> <span class="text-red-500">: + Rs 578298</span></li>
                        <li class=""><span class="inline-block w-1/10">Discount</span> <span class="text-red-500">: - Rs 6523.60</span></li>
                        <li class="mt-2"><span class="inline-block w-1/10">Total</span>    <span class="text-red-500">: + Rs 571774.4</span></li>
                    </ul>
                </x-slot>                    
            </x-flash-message>


            <form method="POST" action="{{route('checkout')}}" id="credit-card-details" autocomplete="off">
                <div class="shadow bg-white lg:p-6 p-4 wrapper">
                    <div class="col-span-2">
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Pay with credit card</h2>
                        <hr class="">
                    </div>
                    @csrf

                    <!-- 
                    <div>
                        <p class="text-base py-5 font-medium">
                            We accept following credit cards:&nbsp;&nbsp;
                            <img class="inline-block" src="{{asset('images/cards.png')}}" style="width: 250px;" alt="Cerdit Cards">
                        </p>                            
                    </div>
                    
                    <div class="text-base pb-5">
                        <span class="font-bold text-red-500 text-lg">*</span> - Required Information </div>
                     -->

                    <div class="flex justify-center">
                        <div class="w-8/12">
                            <p class="text-base py-5 font-medium">
                                We accept following credit cards:&nbsp;&nbsp;
                                <img class="inline-block" src="{{asset('images/cards.png')}}" style="width: 250px;" alt="Cerdit Cards">
                            </p>
                        </div>
                        <div class="w-4/12">
                            <div class="text-base text-right py-5">
                                <span class="font-bold text-red-500 text-lg">*</span> - Required Information </div>
                        </div>                                
                    </div>
                    





                    <div class="grid grid-cols-2 gap-3">
                        <div class="">
                            <input type="text" name="card_number" placeholder="Card Number *" 
                                class="with-border"  id="creditCardNumber">
                                <div class="error-msg"></div>
                        </div>

                        <div class="">
                            <input type="text" name="full_name" placeholder="Full Name *" class="with-border">
                            <div class="error-msg"></div>
                        </div>
                    
                        <div> 
                            <input type="text" name="expiry" id="expiry" placeholder="MM/YY *" class="with-border">
                            <div class="error-msg"></div>
                        </div>

                        <div>    
                            <input type="text" name="cvc" placeholder="CVC *" class="with-border" 
                                   maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <div class="error-msg"></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:gap-6 gap-3 md:mt-10 mt-5">
                    {{-- <a class="bg-gray-200 flex font-medium items-center justify-center py-3 rounded-md" href="">
                        <i class="icon-feather-chevron-left mr-1"></i>
                        <span class="">Back to billing info</span>
                    </a> --}}

                    <div class="flex font-medium items-center justify-center">
                        <button class="bg-gray-500 w-full py-3 rounded-md hover:bg-gray-700 text-white text-base block" type="button" id="goBack">
                            <i class="icon-feather-chevron-left mr-1"></i>
                            <span class="">Back to billing info</span>
                        </button>
                    </div>
                    <!-- <a class="bg-blue-600 text-white flex font-medium items-center justify-center py-3 rounded-md hover:text-white" href="pages-account-info.html">
                        <span class="md:block hidden">Billing address </span><span class="md:hidden block">Review</span>
                        <i class="icon-feather-chevron-right ml-1"></i>
                    </a> -->

                    <div class="border rounded-md border-blue-500 font-medium">
                        <button class="w-full py-3 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-base block" type="submit">Checkout</button>
                    </div>
                </div>
            </form>

            <form method="get" action="{{route('billing-info')}}" id="back-to-bill-info">
                <input type="hidden" name="key" value="{{csrf_token()}}">            
            </form>
            

        </div>
    </div>
@stop






@section('script-files')

    <!-- Cleave.js Format your <input/> content when you are typing -->
    <script src="{{asset('plugins/cleave.js-1.6.0/dist/cleave.min.js')}}"></script>
    
    <!-- jquery form validation js file-->
    <script src="{{asset('js/jquery-validation-1.19.3/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/jquery-validation-1.19.3/additional-methods.min.js')}}"></script>
    <script src="{{asset('js/jquery-validation-1.19.3/custom-additional-methods.js')}}"></script>   
    
@stop


@section('javascript')
<script>

    $(document).ready(function(){
        
        /**/
        var cleaveCreditCard = new Cleave('#creditCardNumber', {
            creditCard: true,
            delimiter: '-',
            onCreditCardTypeChanged: function (type) {
                // do something when credit card type changes
                console.log(type);
            },
            swapHiddenInput:true
        });

        var cleaveExpiry = new Cleave('#expiry', {
            date: true,
            datePattern: ['m', 'y']
        });







        /*
        jquery.validate ignores hidden fields by default, not validating them.
        To turn it back on simply do the following:
        */
        $.validator.setDefaults({ ignore: '' });

        var validator =  $("#credit-card-details").validate({                       
            //ignore: [],
            onkeyup: false,
            errorClass: "validationErrorCls",
            //focusInvalid: false,
            rules:{    

                'card_number' :{required: true},
                'full_name'   :{required: true},
                'expiry'      :{required: true},
                'cvc'         :{required: true, digits: true,exactlength: 3},
            },
            messages:{
                'card_number':{
                    required    : 'Credit card number is required', 
                },
                'full_name'   :{
                    required  : 'Full name is required', 
                },
                'expiry':{
                    required: 'Expiry date and month is required', 
                },
                'cvc':{
                    required    : 'CVC is required', 
                    exactlength : 'Please enter exactly 3 digits'
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
               
                $errMsgDiv = element.parent().find('.error-msg');                   
                error.appendTo($errMsgDiv);
                $errMsgDiv.find('label').css('color','red');
                $errMsgDiv.find('label').css('fontSize','13px');                               
            }

        }); 



    });


    $('#goBack').on('click',function(event){
        var form = $('form#back-to-bill-info');
        form.submit();
        //alert();

        event.preventDefault();

    });


    /*    
    function formatCreditCardNumber(event) {
        const input = event.target;
        const trimmed = input.value.replace(/\s+/g, '');
        const numbers = [];

        for (let i = 0; i < trimmed.length; i += 4) {
            numbers.push(trimmed.substr(i, 4));
        }

        input.value = numbers.join(' ');
    }
    */




</script>
@stop

















