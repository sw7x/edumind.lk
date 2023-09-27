@extends('admin-panel.layouts.master')
@section('title','Add subject')

@section('css-files')
    <link href="{{asset('admin/css/plugins/iCheck/custom.css')}}" rel="stylesheet">

    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond-plugin-image-preview.min.css')}}">
    <link rel='stylesheet' href="{{asset('admin/plugins/filepond/css/filepond.min.css')}}">

@stop




@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            @if(Session::has('message'))
                <x-flash-message  
                    :class="Session::get('cls', 'flash-info')"  
                    :title="Session::get('msgTitle') ?? 'Info!'" 
                    :message="Session::get('message') ?? ''"  
                    :message2="Session::get('message2') ?? ''"  
                    :canClose="true" />
            @endif            


            <!-- content -->
            <div class="ibox ">
                <div class="ibox-content px-3">                    
                    <h3>Add New Subject</h3>
                    <form class="edit-user-form" id="add-subject" action="{{route('admin.subject.store')}}" method="POST" enctype='multipart/form-data'>
                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8"><input type="text" name="name" class="form-control" required="required"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row"><label class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <textarea rows="3" class="form-control" placeholder="Enter Description"  name="description" cols="50"></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row"><label class="col-sm-4 col-form-label">Image</label>
                            <div class="col-sm-8">
                                {{--                                        
                                    <input type="file" class="form-control" name="subject_image">
                                --}}
                                <input type="file"
                                       class="filepond-img"
                                       name="image"
                                       accept="image/webp, image/png, image/jpeg, image/gif"
                                       data-max-file-size="1MB"/>
                                <p>Image Size 300X350</p>
                            </div>

                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Submit status</label>
                            <div class="col-sm-8">
                                <div class="i-checks">
                                    <label> <input type="radio" value="draft" name="status"> <i></i> Draft </label>
                                </div>
                                <div class="i-checks">
                                    <label> <input type="radio" checked="" value="published" name="status"> <i></i> Published </label>
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
                        {{csrf_field ()}}
                    </form>
                </div>
            </div>




        </div>
    </div>
@stop



@section('script-files')
    <!-- iCheck -->
    <script src="{{asset('admin/js/plugins/iCheck/icheck.min.js')}}"></script>



    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-encode.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-size.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-exif-orientation.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-image-preview.min.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond-plugin-file-validate-type.js')}}"></script>
    <script src="{{asset('admin/plugins/filepond/js/filepond.min.js')}}"></script>
@stop


@section('javascript')
<script>

	(function () {
		/* We want to preview images, so we need to register the Image Preview plugin  */
		FilePond.registerPlugin(

			// encodes the file as base64 data
			FilePondPluginFileEncode,

			// validates the size of the file
			FilePondPluginFileValidateSize,

			// corrects mobile image orientation
			FilePondPluginImageExifOrientation,

			// previews dropped images
			FilePondPluginImagePreview,

			FilePondPluginFileValidateType
		);
	})();

	// Select the file input and use create() to turn it into a pond
	const pond = FilePond.create(document.querySelector('.filepond-img'));

</script>
@stop
