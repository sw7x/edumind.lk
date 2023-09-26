@extends('admin-panel.layouts.master')
@section('title','Add coupon code')

@section('css-files')
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

    <!-- rangeslider CSS file-->
    <link rel='stylesheet' href="{{asset('admin/plugins/rangeslider/css/rangeslider.min.css')}}">

     <!-- toastr CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/toastr/toastr.min.css')}}">

@stop




@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            @if(Session::has('message'))
                <x-flash-message
                    class="{{ Session::get('cls', 'flash-info')}}" 
                    :title="Session::get('msgTitle')"
                    :message="Session::get('message')">
                    <x-slot name="insideContent">
                        @if ($errors->couponCreateError->getMessages())
                            <ul class="mt-3 mb-4 ml-4 list-disc text-xs text-red-600 font-bold">
                                @foreach ($errors->couponCreateError->getMessages() as $field => $errorMsgArr)
                                    @foreach ($errorMsgArr as $errorMsg)
                                        <li class="">{{ $errorMsg }}</li>
                                    @endforeach
                                @endforeach
                            </ul>
                        @endif
                    </x-slot>
                </x-flash-message>            
            @endif 


            <?php 
            //dump($errors);
            //dump($errors->couponCreate);
            //dump($errors->couponCreate->getMessages());
            //dump($errors->couponCreateError->getMessages());
            ?>




            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Add coupon code</h3>

                    <form class="cc-add-form" id="cc-add-form" action="{{route('admin.coupon-code.store')}}" method="POST">
                        @csrf
                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Coupon code</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="cc-code" maxlength="6" value="{{old('cc-code')}}">
                                <div class="error-msg"></div>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-blue btn-sm text-base hover:bg-blue-600" type="button" id="generate-code" style="width: 100%;height: 35px;">Generate</button>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>                    


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Discount precentage 
                                <br><span class="text-xs text-red font-semibold">( from course price )</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="text-2xl text-center font-bold output"></div><br>
                                <input  type="range" name="discount_percentage" 
                                        value="{{old('discount_percentage',25)}}" min="1" max="99" step="1" >    
                                <div class="error-msg"></div>                            
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                            
                        @php
                            //dump($courses);
                        @endphp    
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select course <br><span class="text-xs text-red font-semibold">(Paid courses)</span></label>

                            <div class="col-sm-8">
                                <select class="form-control m-b" name="course">
                                    <option></option> 

                                    <optgroup class="select2-result-selectable" label="Select any">                                       
                                        <option value="0">Paid course (any)</option> 
                                    </optgroup>
                                    
                                    <optgroup class="select2-result-selectable" label="Select one">                    
                                        @foreach ($courses as $courseId => $coursesName)
                                            <option value="{{$courseId}}">{{$coursesName}}</option>
                                        @endforeach
                                    </optgroup>
                                                                  
                                </select>
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select - Marketer / Teacher <span class="text-xs text-red font-semibold">(course created teacher)</span></label>
                            <div class="col-sm-8">
                                
                                <select style="width:100%;" name="beneficiary">                 
                                </select>

                                    {{--
                                    <option></option>
                                    <optgroup class="select2-result-selectable" label="Teachers">        
                                        @foreach ($teachers1 as $teacherId => $teachersName)
                                            <option value="{{$teacherId}}">{{$teachersName}}</option>
                                        @endforeach                                 
                                    </optgroup>                                 
                                    <optgroup class="select2-result-selectable" label="Marketers" >                
                                        @foreach ($marketers1 as $marketerId => $marketersName)
                                            <option value="{{$marketerId}}">{{$marketersName}}</option>
                                        @endforeach                               
                                    </optgroup>
                                    --}} 
                                <div class="error-msg"></div>                                                   
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Count</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="cc-count" value="{{old('cc-count')}}">
                                <div class="error-msg"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="beneficiary_share_percentage_from_discount-wrapper">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Marketer/Teacher share <br>
                                    <span class="text-xs text-red font-semibold">( percentage from reduced price )</span>
                                </label>
                                <div class="col-sm-8">
                                    <div class="text-2xl text-center font-bold output"></div><br>
                                    <input  type="range" name="beneficiary_share_percentage_from_discount"
                                            value="{{old('beneficiary_share_percentage_from_discount', 100)}}"
                                            min="0" max="100" step="1">
                                    <div class="error-msg"></div>
                                </div>
                            </div>
                            //when not select Marketer/Teacher doable it
                            <div class="hr-line-dashed"></div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Submit status</label>

                            <div class="col-sm-8">
                                <div class="i-checks">
                                    <label>
                                        <input  type="radio" value="enable" name="ccode_stat" 
                                                {{(old('ccode_stat')) != 'disable'? 'checked':''}}> <i></i> Enable </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <input type="radio" value="disable" name="ccode_stat"
                                                {{(old('ccode_stat')) == 'disable'? 'checked':''}}> <i></i> Disable </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-4">
                                <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                <button class="btn btn-danger btn-sm reset-btn" type="reset">Cancel</button>
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

    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>

    <!-- rangeslider JS file-->
    <script src="{{asset('admin/plugins/rangeslider/js/rangeslider.min.js')}}"></script>

     <!-- toastr js file-->
    <script src="{{asset('admin/js/plugins/toastr/toastr.min.js')}}"></script>

    <!-- jQuery validate -->
    <script src="{{asset('admin/js/plugins/validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/validate/custom-additional-methods.js')}}"></script>
    <script src="{{asset('admin/js/plugins/validate/additional-methods.min.js')}}"></script>
    
@stop


@section('javascript')
<script>
    $(document).ready(function() {
        var $inputAuthorShareRange          = $('input[name="beneficiary_share_percentage_from_discount"]');
        var $inputDiscountPercentageRange   = $('input[name="discount_percentage"]');


        for (var i = $inputAuthorShareRange.length - 1; i >= 0; i--) {
            valueOutput($inputAuthorShareRange[i]);
        }

        for (var i = $inputDiscountPercentageRange.length - 1; i >= 0; i--) {
            valueOutput($inputDiscountPercentageRange[i]);
        }



        $inputAuthorShareRange.rangeslider({
            polyfill: false 
        });

        $inputDiscountPercentageRange.rangeslider({
            polyfill: false 
        });




        $('select[name="course"]').select2({
            placeholder: "Select a course",
            allowClear: true,
            width: '100%'
        });


        /*
        $('select[name="course"]').on('select2:unselect', function (e) {
            console.log(e.params.data);
            console.log(e.params);


            // If the dropdown is cleared, select the first option
            if (e.params.data == null) {
                var firstOption = $select2.find('option').first();
                $select2.val(firstOption.val());
                $select2.trigger('change');
            }
        });
        */


        //if old submit value is there for course then set it
        @if(!is_null(old('course')) && array_key_exists(old('course'), $courses))
            var courseVal = {{ Js::from(old('course')) }};
            $('select[name="course"]').select2().select2('val', courseVal);
        @endisset


        $('select[name="beneficiary"]').select2({
            placeholder: "Select a beneficiary",
            allowClear: true,
            width: '100%'
        });


        $('select[name="beneficiary"]').on('change',function(event){
            console.log($(this).val());
            if($(this).val()){
                $('.beneficiary_share_percentage_from_discount-wrapper').slideDown("slow");

            }else{
                $('.beneficiary_share_percentage_from_discount-wrapper').slideUp("slow");                
            }
        });



        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            //"positionClass": "toast-top-full-width",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        
        // when page loads populate Beneficiaries dropdown
        populateBeneficiaries(0)
            .then(function(response) {
                // Code to run if the AJAX call is successful
                //console.log('Beneficiaries loaded:', response);

                @if(!is_null(old('course')) && !is_null(old('beneficiary')))           
                    var beneficiaryVal      = {{ Js::from(old('beneficiary')) }};
                    var beneficiaryValArr   = [];
                    
                    // Add each option's value to the array
                    $('select[name="beneficiary"] option').each(function() {                        
                        //console.log($(this).val());
                        beneficiaryValArr.push($(this).val());
                    });

                    if (beneficiaryValArr.includes(beneficiaryVal))
                        $('select[name="beneficiary"]').select2().select2('val',beneficiaryVal);
                
                @endif
            })
            .catch(function(error) {
                // Code to run if there's an error
                //console.error('Error:', error);
            });



        
        $('.beneficiary_share_percentage_from_discount-wrapper').hide();



        /*
        jquery.validate ignores hidden fields by default, not validating them.
        To turn it back on simply do the following:
        */
        $.validator.setDefaults({ ignore: '' });

        var validator =  $("#cc-add-form").validate({                       
            //ignore: [],
            onkeyup: false,
            errorClass: "validationErrorCls",
            //focusInvalid: false,
            rules:{
                
                "course": {
                    required: true                        
                },
                "cc-code"                 : {required: true, exactlength :6, lettersAndNumbersOnly:true},
                "cc-count"                : {required: true,number: true, min:1},
                'discount_percentage'     : {required: true,number: true, min:1,max:99},
                'beneficiary_share_percentage_from_discount' : {
                    //required: true,
                    required: function(element) {
                        return ($('select[name="beneficiary"]').val() != '');
                    },
                    number: true, 
                    min:0,
                    max:100
                },
            },
            messages:{
                "course": {
                    required:"Course is required",
                },
                "cc-code":          {
                    required: "Coupon code is required",
                    exactlength: "Coupon code length should be 6 characters",
                    lettersAndNumbersOnly: "Coupon code should be in alpha numeric characters"
                },
                "cc-count"         : {
                    required: "Coupon code count is required",
                    number: "Coupon code count should be a number",
                    min: "Coupon code count minimum value can be 1"
                },
                'discount_percentage': {
                    required:'Discount percentage is required',
                    number  :'Discount percentage should be a number', 
                    min     :'Discount percentage minimum value can be 1',
                    max     :'Discount percentage maximum value can be 99'
                },
                'beneficiary_share_percentage_from_discount': {
                    required:'Author share percentage is required',
                    number  :'Author share percentage should be a number', 
                    min     :'Author share percentage minimum value can be 0',
                    max     :'Author share percentage maximum value can be 100'
                },
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
                console.log(element);
                //console.log(error);
                //console.log(error.text());
                //element.before(error);
                //element.after(error);
                                  
                if(elementName == 'course-duration-minutes'){
                    //error.appendTo($(element).parent().parent().find('.error-msg-minutes'));
                }else if(elementName == 'course-duration-hours'){
                     //error.appendTo($(element).parent().parent().find('.error-msg-hours'));
                }else{
                    error.appendTo(element.parent().find('.error-msg'));
                }
               
                //element.parent().find('.error-msg').html(error.text());
                

                element.parent().find('.error-msg').css('color','red');
                element.parent().find('.error-msg').css('fontSize','12px');
                //error.css('margin','0px');                 
            }

        });    
        
        
        $(document).on('click', '#generate-code', function(e) {            
            $.ajax({
                url: "{{route('admin.coupon-code.generate-code')}}",
                type: "post",
                async:true,
                dataType:'json',
                data:{
                   // _token : '{{ csrf_token() }}',                    
                },
                success: function (response) {

                    if(response.status == 'success'){
                        //toastr[response.status]('Successfully generate coupon code','Success');
                        $('[name="cc-code"]').val(response.code); 
                    }else{
                        toastr["error"]("Coupon code generate failed!")
                    }
                    //$("#cc-add-form").valid();
                    validator.element('input[name="cc-code"]');
                },
                error:function(request,errorType,errorMessage)
                {
                    //alert ('error - '+errorType+'with message - '+errorMessage);
                    //toastr["success"]("User updated successfully! ", "Good Job!")
                    toastr["error"]("Coupon code generate failed!")
                }
            });
        });

        // reset form
        $("#cc-add-form").find("button.reset-btn").click(function(e) {

            $(':input')
                .not(':button, :submit, :reset, :hidden, .i-checks :radio')
                .val('')
                .removeAttr('checked')
                .removeAttr('selected');

            $('select[name="course"]').select2("val", "");
            $('select[name="beneficiary"]').select2("val", "");
            
            //var validator = $("#contact-form").validate();
            validator.resetForm();

            $('input[name="discount_percentage"]').val(25).change();
            $('input[name="beneficiary_share_percentage_from_discount"]').val(100).change();
            
            $('input[name="ccode_stat"][value="enable"]').iCheck('check');
            //$('input[name="ccode_stat"]:checked').val()
            e.preventDefault();        
        });


        console.log(validator);
        console.log('validator');


    });


        




    function valueOutput(element) {
        let value  = $(element).val();
        $(element).parent().find('.output').html(value + '%');
    }

    
    $(document).on('input', 'input[name="beneficiary_share_percentage_from_discount"]', function(e) {
        valueOutput(e.target);
    });

    $(document).on('input', 'input[name="discount_percentage"]', function(e) {
        valueOutput(e.target);
    });





   $(document).on('change', 'select[name="course"]', function(e) {
        var optionSelected = $(this).find("option:selected");
        var valueSelected  = optionSelected.val();
        var textSelected   = optionSelected.text();
        
        if(!valueSelected){
            valueSelected = 0;
        }
        
        populateBeneficiaries(valueSelected)
            .then(function(response) {
                $("#cc-add-form").valid();
            })
            .catch(function(error) {
                // Code to run if there's an error
                //console.error('Error:', error);
            });    
    });





        


    function populateBeneficiaries(valueSelected){
        return new Promise(function(resolve, reject) {
            
            $.ajax({
                url: "{{route('admin.coupon-code.load-beneficiaries')}}",
                type: "post",
                async:true,
                dataType:'json',
                data:{
                    //_token      : '{{ csrf_token() }}', 
                    courseId   : valueSelected                  
                },
                success: function (response) {

                    if(response.status == 'success'){                  

                        // console.log(response.marketers);
                        // console.log(response.teachers);

                        // console.log(Object.keys(response.marketers).length);
                        // console.log(Object.keys(response.teachers).length);

                        var dropDown = '';
                        
                        dropDown    +=      '<option></option>';
                        
                        if(Object.keys(response.teachers).length >0 && (valueSelected != 0)){                                                
                            //dropDown    +=  '<optgroup class="select2-result-selectable" label="Teachers">';
                            dropDown    +=  '<optgroup class="select2-result-selectable" label="Author">';
                            for (let x in response.teachers) {
                                dropDown +=     '<option value="' + x + '">' + response.teachers[x] + '</option>';
                            }                    
                            dropDown    +=  '</optgroup>';                                
                        }

                        if(Object.keys(response.marketers).length >0){
                            dropDown    +=  '<optgroup class="select2-result-selectable" label="Marketers" >';               
                            for (let x in response.marketers) {
                                dropDown +=     '<option value="' + x + '">' + response.marketers[x] + '</option>';
                            }                    
                            dropDown   +=    '</optgroup>';                    
                        }

                        $('select[name="beneficiary"]').html(dropDown);
                        resolve(response); // Resolve the Promise
                    }else{
                        toastr["error"](response.message);
                        reject(response); // Reject the Promise
                    }

                },
                error:function(request,errorType,errorMessage)
                {
                    //alert ('error - '+errorType+'with message - '+errorMessage);
                    //toastr["success"]("User updated successfully! ", "Good Job!")
                    toastr["error"]("Beneficiaries loading failed!");
                    reject(errorMessage); // Reject the Promise
                }
            });

        });        
    }

    
</script>
@stop

