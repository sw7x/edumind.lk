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
                <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                    <p>{{ Session::get('message') ?? 'Info!' }}</p>
                    <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                </div>
            @endif

            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Add coupon code</h3>

                    <form class="edit-user-form" id="add-category" action="http://local.arcade.lk/categories/add-category" method="POST">
                        @csrf
                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Coupon code</label>
                            <div class="col-sm-5"><input type="text" class="form-control" name="cc-code"></div>
                            <div class="col-sm-3">
                                <button class="btn btn-blue btn-sm text-base hover:bg-blue-600" type="button" id="generate-code" style="width: 100%;height: 100%;">Generate</button>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>                    


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Discount precentage 
                                <br><span class="text-xs text-red font-semibold">( from course price )</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="text-2xl text-center font-bold output"></div><br>
                                <input type="range" name="discount_percentage" value="10" min="0" max="20" step="1">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select course</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b" name="course">
                                    <option></option>                            
                                    @foreach ($courses as $courseId => $coursesName)
                                        <option value="{{$courseId}}">{{$coursesName}}</option>
                                    @endforeach                                   
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div>//when course select then load all marketers and course own teacher</div><br>
                        
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select Marketer/Teacher <span class="text-xs text-red font-semibold">(course created teacher)</span></label>
                            <div class="col-sm-8">
                                
                                <select style="width:100%;" name="benificiary">                 
                                </select>

                                    {{--
                                    <option></option>
                                    <optgroup class="select2-result-selectable" label="Teachers"   >        
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
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Count</label>
                            <div class="col-sm-8"><input type="text" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Marketer/Teacher share <br>
                                <span class="text-xs text-red font-semibold">( percentage from reduced price )</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="text-2xl text-center font-bold output"></div><br>
                                <input type="range" name="author_share_percentage" value="100" min="0" max="100" step="1">
                            </div>
                        </div>
                        //when not select Marketer/Teacher doable it
                        <div class="hr-line-dashed"></div>

                        



                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Submit status</label>

                            <div class="col-sm-8">
                                <div class="i-checks">
                                    <label> <input type="radio" checked value="enable" name="ccode_stat"> <i></i> Enable </label>
                                </div>
                                <div class="i-checks">
                                    <label> <input type="radio" value="disable" name="ccode_stat"> <i></i> Disable </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        // on the fly validate coupon code precentage<br>
                        //for edumind total income from course is not less than 0<br>
                        //for this calc use Marketer/Teacher share  value also
                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-4">
                                <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                <button class="btn btn-danger btn-sm" type="reset">Cancel</button>
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
@stop


@section('javascript')
<script>
    $(document).ready(function() {
        var $inputAuthorShareRange          = $('input[name="author_share_percentage"]');
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


        $('select[name="benificiary"]').select2({
            placeholder: "Select a benificiary",
            allowClear: true,
            width: '100%'
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

        populateBeneficiaries(0);



    });


    function valueOutput(element) {
        let value  = $(element).val();
        $(element).parent().find('.output').html(value + '%');
    }


    $(document).on('input', 'input[name="author_share_percentage"]', function(e) {
        valueOutput(e.target);
    });

    $(document).on('input', 'input[name="discount_percentage"]', function(e) {
        valueOutput(e.target);
    });


    $(document).on('click', '#generate-code', function(e) {
        
        $.ajax({
            url: "{{route('admin.coupon-code.generate-code')}}",
            type: "post",
            async:true,
            dataType:'json',
            data:{
                _token : '{{ csrf_token() }}',                    
            },
            success: function (response) {

                if(response.status == 'success'){
                    //toastr[response.status]('Successfully generate coupon code','Success');
                    $('[name="cc-code"]').val(response.code); 
                }else{
                    toastr["error"]("Coupon code generate failed!")
                }

            },
            error:function(request,errorType,errorMessage)
            {
                //alert ('error - '+errorType+'with message - '+errorMessage);
                //toastr["success"]("User updated successfully! ", "Good Job!")
                toastr["error"]("Coupon code generate failed!")
            }
        });

    })


   $(document).on('change', 'select[name="course"]', function(e) {
        var optionSelected = $(this).find("option:selected");
        var valueSelected  = optionSelected.val();
        var textSelected   = optionSelected.text();
        
        if(!valueSelected){
            valueSelected = 0;
        }

        populateBeneficiaries(valueSelected)

   });
        


    function populateBeneficiaries(valueSelected){

        $.ajax({
            url: "{{route('admin.coupon-code.load-beneficiaries')}}",
            type: "post",
            async:true,
            dataType:'json',
            data:{
                _token      : '{{ csrf_token() }}', 
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

                    $('select[name="benificiary"]').html(dropDown);

                }else{
                    toastr["error"](response.message);
                }

            },
            error:function(request,errorType,errorMessage)
            {
                //alert ('error - '+errorType+'with message - '+errorMessage);
                //toastr["success"]("User updated successfully! ", "Good Job!")
                toastr["error"]("Beneficiaries loading failed!")
            }
        });
    }

    
</script>
@stop

