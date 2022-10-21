@extends('admin-panel.layouts.master')
@section('title','Edit subject')

@section('css-files')
    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
@stop



@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            <!-- content -->
            <div class="ibox ">
                <div class="ibox-content px-3">
                    <h3>View Subject</h3>

                    @if(Session::has('message'))
                        <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                            <a href="#" class="close">×</a>
                            <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                            <p>{{ Session::get('message') ?? 'Info!' }}</p>
                            <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                        </div>
                    @endif

                    <form class="edit-subject-form" id="edit-subject" action="{{route('admin.subject.update',$subject->id)}}" method="POST">

                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8"><label class="col-form-label">{{$subject->name}}</label></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row"><label class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <label class="col-form-label">{{$subject->description}}</label>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row"><label class="col-sm-4 col-form-label">Image</label>
                            <div class="col-sm-8">
                                @if($subject->image)
                                    <img style="max-width:500px" src="{{URL('/')}}/storage/{{$subject->image}}"/>
                                @else
                                    <p>no image</p>
                                @endif
                                <br>
                                <small>Image Size should be 300X350</small>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Submit status</label>
                            <div class="col-sm-8">
                                <div class="i-checks">
                                    <label> <input type="radio" value="draft" name="subject_stat" {{$subject->status == 'draft'? 'checked':''}}> <i></i> Draft </label>
                                </div>
                                <div class="i-checks">
                                    <label> <input type="radio" value="published" name="subject_stat" {{$subject->status == 'published'? 'checked':''}}> <i></i> Published </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-4">
                                <a href="{{route('admin.subject.index')}}" class="btn btn-danger btn-sm" type="reset">Go back</a>
                            </div>
                        </div>
                        {{csrf_field ()}}
                        <input name="_method" type="hidden" value="PUT">
                    </form>

                </div>
            </div>


        </div>
    </div>
@stop



@section('script-files')
    <!-- iCheck -->
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>
@stop


@section('javascript')
<script>
</script>
@stop
