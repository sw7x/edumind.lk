@extends('admin-panel.layouts.master')
@section('title','Edit subject')

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
                <div class="ibox-content">
                    <h3>Update Subject</h3>
                    <form class="edit-subject-form" id="edit-subject" action="{{route('admin.subject.update',$subject['id'])}}" method="POST">

                        <div class="form-group  row">
                            <label class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-8"><input type="text" name="name" class="form-control" required="required" value="{{$subject['name']}}"></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row"><label class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <textarea rows="8" class="form-control" placeholder="Enter Description"  name="description" cols="50">{{$subject['description']}}</textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group row"><label class="col-sm-4 col-form-label">Image</label>
                            <div class="col-sm-8">
                                {{--
                                <input type="file" class="form-control" name="image">
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


                        <input type="hidden" value="{{$subject['image']}}"
                               name="hidden_subject_img" data-url="{{$subject['image']}}"/>
                        <input type="hidden" value="{{$subject['image']}}"
                               name="hidden_subject_img_url"/>
                        <input type="hidden" value="1"
                               name="hidden_file_add_count"/>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Submit status</label>
                            <div class="col-sm-8">
                                <div class="i-checks">
                                    <label> <input type="radio" value="draft" name="status" {{$subject['status'] == App\Models\Subject::DRAFT ? 'checked':''}}> <i></i> Draft </label>
                                </div>
                                <div class="i-checks">
                                    <label> <input type="radio" value="published" name="status" {{$subject['status'] == App\Models\Subject::PUBLISHED ? 'checked':''}}> <i></i> Published </label>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>



                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-4">
                                <button class="btn btn-primary btn-sm" type="submit">Update changes</button>
                                <a href="{{route('admin.subject.index')}}" class="btn btn-danger btn-sm" type="reset">Cancel</a>
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



        
        // Select the file input and use create() to turn it into a pond
        const pond = FilePond.create(document.querySelector('.filepond-img'));

        let subjImg = $('form.edit-subject-form input[name="hidden_subject_img"]').val();
        let subjUrl = $('form.edit-subject-form input[name="hidden_subject_img_url"]').val();
        if(subjUrl){
            pond.addFile(subjImg);
        }








	})();





	/*
     $('form.edit-subject-form input[name="hidden_file_add_count"]') is use to track
     user submit form without changing previously uploaded image => then no need invoke image upload
     or
     user submit form by changing previously uploaded image => then need invoke image upload
     */
	$('.filepond-img').on('FilePond:addfile', function(e) {

		let $countElem = $('form.edit-subject-form input[name="hidden_file_add_count"]');
		let count = $countElem.val();
		count--;
		$countElem.val(count);

		if(count<0){
			$('form.edit-subject-form input[name="hidden_subject_img_url"]').val('');
		}
	});

	$('.filepond-img').on('FilePond:removefile', function(e) {


	});

	// Manually add a file using the addfile method
	//var images = '["http://local.edumind.com/storage/subjects/163361394_2888776714783458_3970938951945_611107079850d.jpg"]';
	//var imgObj = JSON.parse(images);
	//var i;

	//		if (images.length!=0){
	//			for (i = 0; i < imgObj.length ; i++) {
	//				console.log(imgObj[i]);
	//				pond.addFile(imgObj[i]);
	//			}
	//		}
</script>
@stop
