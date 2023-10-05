@extends('admin-panel.layouts.master')
@section('title','Access Denied')


@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="ibox mb-0">
                <div class="ibox-content">
                    <div class="middle-box text-center animated fadeInDown mt-0 pt-1 mb-0 text-red-500">
                        <h1 class="font-semibold">403</h1>
                        <h3 class="font-bold text-3xl">Access Denied</h3>

                        <div class="error-desc">
                            <div class="text-base">
                                @if(isset($errMsg) && $errMsg)
                                    {{$errMsg}}    
                                @else
                                    It appears you don't have permission to access this page.
                                @endif
                            </div>
                            <br/>
                            <div class="mt-2">    
                                <div>
                                    <a class="btn btn-danger mb-2" href="{{ url()->previous() }}">Go back</a>
                                </div>                                              
                                <div>
                                    <a class="btn btn-primary mr-2" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    <a class="btn btn-info" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                                </div>
                            </div>                        
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

