@extends('admin-panel.layouts.master',['title' => 'Approve Teacher'])
@section('title','Approve Teacher')

@section('css-files')
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="{{asset('admin/css/magnific-popup.css')}}">
@stop


@section('content')
    <div class="row" id="">
        <div class="col-lg-12">
approve-account.blade
            @if(Session::has('message'))
                <x-flash-message  
                    :class="Session::get('cls', 'flash-info')"  
                    :title="Session::get('msgTitle') ?? 'Info!'" 
                    :message="Session::get('message') ?? ''"  
                    :message2="Session::get('message2') ?? ''"  
                    :canClose="true" />
            @endif
            
            @if(isset($message))
                <x-flash-message  
                    :class="$cls ?? 'flash-info'"  
                    :title="$msgTitle ?? 'Info!'" 
                    :message="$message ?? ''"  
                    :message2="$message2 ?? ''"  
                    :canClose="true" />
            @endif

            
            <div class="ibox">               
                <div class="ibox-content feedback-container forum-post-container mb-5">
                    @if(isset($userData))
                        @if(isset($userData['fullName']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Name <span class="text-red-500 text-sm font-bold">*</span></label>
                                <label class="col-sm-9 col-form-label">{{$userData['fullName']}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData['userType']))
                        <div class="form-group  row">
                            <label class="col-sm-3 col-form-label">User type</label>
                            <label class="col-sm-9 col-form-label">{{$userData['userType']}}</label>
                        </div>
                        <div class="hr-line-dashed"></div>
                        @endif

                        @if(isset($userData['username']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Username</label>
                                <label class="col-sm-9 col-form-label">{{$userData['username']}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData['email']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Email <span class="text-red-500 text-sm font-bold">*</span></label>
                                <label class="col-sm-9 col-form-label">{{$userData['email']}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData['phone']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Phone <span class="text-red-500 text-sm font-bold">*</span></label>
                                <label class="col-sm-9 col-form-label">{{$userData['phone']}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData['dobYear']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Year of birth</label>
                                <label class="col-sm-9 col-form-label">{{$userData['dobYear']}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData['eduQualifications']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Education qualifications</label>
                                <div class="col-sm-9 col-form-label">{!! $userData['eduQualifications'] !!}</div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif

                        @if(isset($userData['profileText']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Student details</label>
                                <div class="col-sm-9 col-form-label">{!! $userData['profileText'] !!}</div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData['profilePic']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Profile image</label>
                                <label class="col-sm-9 col-form-label">
                                    <a class="no-clickable popup-img effect" href="{{$userData['profilePic']}}" data-effect="mfp-zoom-in">
                                        <img src="{{$userData['profilePic']}}" width="200px" alt="">
                                    </a>
                                </label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData['gender']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Gender <span class="text-red-500 text-sm font-bold">*</span></label>
                                <label class="col-sm-9 col-form-label">{{$userData['gender']}}</label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif

                        <div class="form-group  row">
                            <label class="col-sm-3 col-form-label">Account (Enable /Disable)<br> by admin</label>
                            <label class="col-sm-9 col-form-label">
                                @if($userData['status'] === true)
                                    <span class="label label-primary">Enabled</span>
                                @else
                                    <span class="label label-warning">Disabled</span>
                                @endif
                            </label>
                        </div>
                        <div class="hr-line-dashed"></div>

                        @if(array_key_exists("isActivated",$userData))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Activation status</label>
                                <label class="col-sm-9 col-form-label">
                                    @if($userData['isActivated'] === true)
                                        <span class="label label-primary">Activated</span>
                                    @else
                                        <span class="label label-warning">Not Activated</span>
                                    @endif
                                </label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif


                        @if(isset($userData['lastLogin']))
                            <div class="form-group  row">
                                <label class="col-sm-3 col-form-label">Last login</label>
                                <label class="col-sm-9 col-form-label">{{$userData['lastLogin']}} <small>({{$userData['getLastLoginTime']}})</small></label>
                            </div>
                            <div class="hr-line-dashed"></div>
                        @endif

                        <div class="form-group row">                        
                            <div class="col-sm-4 offset-sm-3 mt-5">
                                <button class="btn btn-primary btn-sm mr-2" style="min-width: 100px" type="submit">Approve</button>
                                <a class="btn btn-danger btn-sm font-semibold"  type="submit" href="{{route('admin.users.index')}}">Go back</a>
                            </div>
                        </div>              
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
