@extends('admin-panel.layouts.master',['title' => 'Approve Teacher'])
@section('title','Approve Teacher')

@section('css-files')
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">
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
                <div class="ibox-content feedback-container forum-post-container mb-5">
                    @if(isset($userData))
                        @if(isset($userData->full_name))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                <label class="col-sm-9 col-form-label">{{$userData->full_name}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userType))
                        <div class="form-group  row">
                            <label class="col-sm-3 col-form-label">User type</label>
                            <label class="col-sm-9 col-form-label">{{$userType}}</label>
                        </div>
                        <div class="hr-line-dashed"></div>
                        @endif

                        @if(isset($userData->username))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Username</label>
                                <label class="col-sm-9 col-form-label">{{$userData->username}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData->email))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                <label class="col-sm-9 col-form-label">{{$userData->email}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData->phone))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                <label class="col-sm-9 col-form-label">{{$userData->phone}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData->dob_year))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Year of birth</label>
                                <label class="col-sm-9 col-form-label">{{$userData->dob_year}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData->edu_qualifications))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Education qualifications</label>
                                <div class="col-sm-9 col-form-label">{!! $userData->edu_qualifications !!}</div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif

                        @if(isset($userData->profile_text))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Student details</label>
                                <div class="col-sm-9 col-form-label">{!! $userData->profile_text !!}</div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData->profile_pic))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Profile image</label>
                                <label class="col-sm-9 col-form-label">
                                    <a class="no-clickable popup-img effect" href="{{URL('/')}}/storage/{{$userData->profile_pic}}" data-effect="mfp-zoom-in">
                                        <img src="{{URL('/')}}/storage/{{$userData->profile_pic}}" width="200px" alt="">
                                    </a>
                                </label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData->gender))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                <label class="col-sm-9 col-form-label">{{$userData->gender}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif

                        <div class="form-group  row">
                            <label class="col-sm-3 col-form-label">Account (Enable /Disable)<br> by admin</label>
                            <label class="col-sm-9 col-form-label">
                                @if($userData->status === 1)
                                    <span class="label label-primary">Enabled</span>
                                @else
                                    <span class="label label-warning">Disabled</span>
                                @endif
                            </label>
                        </div>
                        <div class="hr-line-dashed"></div>

                        @if(isset($userData))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Activation status</label>
                                <label class="col-sm-9 col-form-label">
                                    @if($userData->isactivated() === true)
                                        <span class="label label-primary">Activated</span>
                                    @elseif($userData->isactivated() === false)
                                        <span class="label label-warning">Not Activated</span>
                                    @else
                                        <span class="label">error</span>
                                    @endif
                                </label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData->last_login))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Last login</label>
                                <label class="col-sm-9 col-form-label">{{$userData->last_login}} <small>({{$userData->getLastLoginTime()}})</small></label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif

                        <div class="form-group row">                        
                            <div class="col-sm-4 offset-sm-3 mt-5">
                                <button class="btn btn-primary btn-sm mr-2" style="min-width: 100px" type="submit">Approve</button>
                                <a class="btn btn-danger btn-sm font-semibold"  type="submit" href="{{route('admin.user.index')}}">Go back</a>
                            </div>
                        </div>              
                    @else
                        @if($view_user_message)
                            <div class="flash-msg {{ $view_user_cls ?? 'flash-info'}}">
                                <a href="#" class="close">×</a>
                                <div class="text-lg"><strong>{{ $view_user_msgTitle ?? 'Info!'}}</strong></div>
                                <p class="mb-1">{{ $view_user_message ?? 'Info!' }}</p>
                                <a class="font-semibold" href="{{route('admin.user.index')}}">Go back</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            

        </div>
    </div>
@stop




@section('script-files')
    <!-- Magnific Popup core JS file -->
    <script src="{{asset('admin/js/jquery.magnific-popup.min.js')}}"></script>
@stop


@section('javascript')
<script>
	$(document).ready(function() {
		$('a.popup-img').magnificPopup({
			type: 'image',
			closeBtnInside: true,
			closeOnContentClick: true,
			tLoading: '', // remove text from preloader
			fixedContentPos: false,
			/* don't add this part, it's just to disable cache on image and test loading indicator */
			callbacks: {
				beforeChange: function () {
					this.items[0].src = this.items[0].src + '?=' + Math.random();
				},
				beforeOpen: function () {
					this.st.mainClass = this.st.el.attr('data-effect');
				},
				open: function () {
					jQuery('body').addClass('noscroll');
				},
				close: function () {
					jQuery('body').removeClass('noscroll');
				}
			},
			//removalDelay: 500, //delay removal by X to allow out-animation
			mainClass: 'mfp-with-fade',
		});
	});

</script>
@stop
