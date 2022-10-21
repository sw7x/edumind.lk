@extends('admin-panel.layouts.master')
@section('title','Course content')

@section('css-files')
    <!-- select2 -->
    <link href="{{asset('admin/css/plugins/select2/select2.min.css')}}" rel="stylesheet">
@stop


@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="ibox">


                <div class="ibox-content">


                    <div class="px-3 row mb-3">
                        <div class="offset-sm-3 col-sm-2 align-middle">
                            <h3><b>Select course: </b></h3>
                        </div>
                        <div class="col-md-7">
                            <select class="form-control" id="status">
                                <option value="all">All</option>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="deleted">Deleted</option>
                            </select>
                        </div>
                    </div>
                    <hr>


                </div>


            </div>
        </div>
    </div>
@stop


@section('script-files')

    <!-- Select2 -->
    <script src="{{asset('admin/js/plugins/select2/select2.full.min.js')}}"></script>

@stop


@section('javascript')
<script>
    $(document).ready(function() {

    });
</script>
@stop
