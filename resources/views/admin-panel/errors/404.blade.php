@extends('admin-panel.layouts.master')
@section('title','404')


@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
            <div class="ibox mb-0">
                <div class="ibox-content">


                    <div class="middle-box text-center animated fadeInDown mt-0 pt-1 mb-3">
                        <h1>404</h1>
                        <h3 class="font-bold">Page Not Found</h3>

                        <div class="error-desc">
                            Sorry, but the page you are looking for has note been found. Try checking the URL for error, then hit the refresh button on your browser or try found something else in our app.
                        </div>
                        <a href="{{ url()->previous() }}">Go back</a><br>
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
						<a href="{{ route('admin.dashboard') }}">Admin Panel</a>



                    </div>

                </div>
            </div>
        </div>
    </div>
@stop



