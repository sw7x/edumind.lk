@extends('admin-panel.layouts.master')
@section('title','Approve teacher changes')

@section('css-files')
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
                    <div class="tabs-container">

                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-teacher-updates">Approve teacher account changes <span class="label label-warning">23</span></a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-student-updates">Approve student account changes <span class="label label-warning">21</span></a></li>
                        </ul>

                        <div class="tab-content mb-3">

                            <div role="tabpanel" id="tab-teacher-updates" class="tab-pane active">
                                <div class="panel-body">

                                    <h3>Add new teacher</h3>

                                </div>
                            </div>

                            <div role="tabpanel" id="tab-student-updates" class="tab-pane">
                                <div class="panel-body">

                                    <h3>Add new student</h3>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>




        </div>
    </div>
@stop


@section('script-files')

@stop


@section('javascript')
<script>
    $(document).ready(function() {

    });
</script>
@stop
