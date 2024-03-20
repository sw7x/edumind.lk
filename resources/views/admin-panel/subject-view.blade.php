@extends('admin-panel.layouts.master',['title'=> 'Subject single'.($subject['isDelete'] ? ' - Trashed' : '')])
@section('title','View subject')

@section('css-files')
    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">
@stop



@section('content')
    <div class="row" id="">
        <div class="col-lg-12">            

            @if(isset($subject) && isNotEmptyArray($subject))            
                <div class="ibox {{$subject['isDelete'] ? 'bg-gray-300' : ''}}">
                    <div class="ibox-content px-3">                  
                        <form class="edit-subject-form" id="edit-subject" action="{{route('admin.subjects.update',$subject['id'])}}" method="POST">

                            <div class="form-group  row">
                                <label class="col-sm-4 col-form-label">Name</label>
                                <div class="col-sm-8"><label class="col-form-label">{{$subject['name']}}</label></div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row"><label class="col-sm-4 col-form-label">Description</label>
                                <div class="col-sm-8">
                                    <label class="col-form-label">{{$subject['description']}}</label>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row"><label class="col-sm-4 col-form-label">Image</label>
                                <div class="col-sm-8">                                
                                    <img style="max-width:500px" src="{{$subject['image']}}"/>                                
                                    <br>
                                    <small>Image Size should be 300X350</small>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Submit status</label>
                                <div class="col-sm-8">
                                    <div class="i-checks">
                                        <label> <input type="radio" value="draft" name="subject_stat" {{$subject['status'] == App\Models\Subject::DRAFT ? 'checked':''}}> <i></i> Draft </label>
                                    </div>
                                    <div class="i-checks">
                                        <label> <input type="radio" value="published" name="subject_stat" {{$subject['status'] == App\Models\Subject::PUBLISHED ? 'checked':''}}> <i></i> Published </label>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row"><label class="col-sm-4 col-form-label">Trashed</label>
                                <div class="col-sm-8">
                                    <label class="col-form-label">{{$subject['isDelete'] ? 'Yes' : 'No'}}</label>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group row">
                                <div class="col-sm-4 offset-sm-4">
                                    <a href="{{route('admin.subjects.index')}}" class="btn btn-danger btn-sm mr-2" type="reset">Go back</a>
                                    <a class="btn btn-info btn-sm" target="_blank" href="{{route('subjects.show',$subject['slug'])}}" title="">Open subject in new tab</a>
                                </div>
                            </div>
                            {{csrf_field ()}}
                            <input name="_method" type="hidden" value="PUT">
                        </form>                    
                    </div>
                </div>
            @else                
                <x-flash-message 
                    class="flash-danger"  
                    title="Data not available!" 
                    message="Subject data is not available or not in correct format"  
                    message2=""  
                    :canClose="false" />                
            @endif

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
