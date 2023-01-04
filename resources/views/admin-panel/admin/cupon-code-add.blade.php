@extends('admin-panel.layouts.master')
@section('title','Add cupon code')

@section('css-files')
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

    <!-- rangeslider CSS file-->
    <link rel='stylesheet' href="{{asset('admin/plugins/rangeslider/css/rangeslider.min.css')}}">

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
                    <h3>Add cupon code</h3>

                    <form class="edit-user-form" id="add-category" action="http://local.arcade.lk/categories/add-category" method="POST">

                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Cupon code</label>
                            <div class="col-sm-6"><input type="text" class="form-control"></div>
                            <div class="col-sm-2"><button class="btn btn-blue btn-sm" type="button">Generate</button></div>

                        </div>
                        <div class="hr-line-dashed"></div>                    


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Discount precentage 
                                <br><span class="text-xs text-red font-semibold">( from course price )</span>
                            </label>
                            <div class="col-sm-8">
                                <div class="text-2xl text-center font-bold output"></div><br>
                                <input type="range" name="discount_percentage" value="10" min="0" max="100" step="1">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select course</label>
                            <div class="col-sm-8">
                                <select class="form-control m-b" name="account">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div>//when course select then load all marketers and course own teacher</div><br>
                        


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select Marketer/Teacher <span class="text-xs text-red font-semibold">(course created teacher)</span></label>
                            <div class="col-sm-8">
                                <select class="form-control m-b" name="account">
                                    <option>option 1</option>
                                    <option>option 2</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                </select>
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
    
</script>
@stop

