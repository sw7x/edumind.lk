@extends('admin-panel.layouts.master')
@section('title','Guest feedback')

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

            <div class="ibox ">                
                <div class="ibox-content relative forum-post-container" id="ibox-content">
                    
                    <div class="text-center p-2 absolute top-1 right-1">
                        <span> Change the orientation : </span>
                        <a href="#" class="min-size ml-3 btn btn-xs btn-info" id="change-view">Left</a>
                    </div>
    

                    <div id="vertical-timeline" class="mt-5 __vertical-container dark-timeline center-orientation">
                        @foreach($otherUserComments as $comment)
                            @php
                                //var_dump($comment->user->id);
                                //var_dump($comment->id);
                                $userRole = $comment->user->roles[0]->name;                    
                            @endphp
                                                   
                            <div class="vertical-timeline-block other-user-block">
                                <div class="vertical-timeline-icon p-1 grey-bg">
                                    @if($userRole == 'editor')
                                        <img src="{{asset('admin/img/default-images/editor.png')}}" class="rounded-full" alt="image">
                                    @elseif($userRole == 'marketer')
                                        <img src="{{asset('admin/img/default-images/marketer.png')}}" class="rounded-full" alt="image">
                                    @else
                                        <img src="{{asset('admin/img/default-images/user.png')}}" class="rounded-full" alt="image">
                                    @endif
                                </div>

                                <div class="vertical-timeline-content rounded-lg">
                                    <h2>{{$comment->subject}}</h2>
                                    <p>{{$comment->message}}</p>                                  
                                    
                                    <div class="text-xs"><strong>Name : </strong>    {{$comment->full_name}}</div>
                                    <div class="text-xs"><strong>Email : </strong>   {{$comment->email}}</div>
                                    <div class="text-xs"><strong>Phone : </strong>   {{$comment->phone}}</div>

                                    @if($comment->created_at)
                                        <span class="vertical-date">
                                            <strong>{{$comment->created_at->diffForHumans()}}</strong><br/>
                                            <small>{{$comment->created_at}}</small><br/>
                                            <span class="text-sm text-green-600 font-semibold">{{$userRole}}</span>
                                        </span>
                                    @endif

                                    <a href="#" data-id="{{$comment->id}}" class="absolute top-0.5 right-1 rounded text-danger text-lg delete-feedback">
                                        <i class="text-3xl fa fa-times-circle-o"></i>
                                    </a>
                                    <form class="comment-destroy" action="{{ route('admin.feedback.delete_comment', $comment->id) }}" method="POST">
                                        @method('DELETE')
                                        <input name="commentId" type="hidden" value="{{$comment->id}}">
                                        <input name="userType" type="hidden" value="other">
                                        @csrf
                                    </form>
                                    
                                </div>
                            </div>
                        @endforeach                        
                    </div>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>


                </div>
            </div>









            <div class="ibox-content feedback-container forum-post-container mb-5">



                @if(Session::has('message'))
                    <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                        <a href="#" class="close">×</a>
                        <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                        <p>{{ Session::get('message') ?? 'Info!' }}</p>
                        <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                    </div>
                @endif


                @foreach($otherUserComments as $comment)
                    @php
                        //var_dump($comment->user->id);
                        //var_dump($comment->id);
                        //var_dump($comment->user->roles[0]->name);
                        $userRole = $comment->user->roles[0]->name;
                    @endphp
                    <div class="media">

                        <a class="forum-avatar" href="#">
                            @if($userRole == 'editor')
                                <img src="{{asset('admin/img/default-images/editor.png')}}" class="rounded-full" alt="image">
                            @elseif($userRole == 'marketer')
                                <img src="{{asset('admin/img/default-images/marketer.png')}}" class="rounded-full" alt="image">
                            @else
                                <img src="{{asset('admin/img/default-images/user.png')}}" class="rounded-full" alt="image">
                            @endif
                            <div class="author-info text-lg">
                                <strong>{{$userRole}}</strong>
                            </div>
                        </a>

                        <div class="media-body">
                            <h4 class="media-heading">{{$comment->subject}}</h4>
                            <div class="mb-2 text-sm">{{$comment->message}}</div>

                            <div class="text-xs"><strong>Name : </strong>    {{$comment->full_name}}</div>
                            <div class="text-xs"><strong>Email : </strong>   {{$comment->email}}</div>
                            <div class="text-xs"><strong>Phone : </strong>   {{$comment->phone}}</div>
                            <div class="text-xs"><strong>Posted : </strong>   {{$comment->created_at}} <b>({{$comment->created_at->diffForHumans()}})</b></div>

                            <br/>
                        </div>
                        <a href="#" data-id="{{$comment->id}}" class="text-danger text-lg delete-feedback">
                            <i class="fa fa-window-close"></i>
                        </a>
                        <form class="comment-destroy" action="{{ route('admin.feedback.delete_comment', $comment->id) }}" method="POST">
                            @method('DELETE')
                            <input name="commentId" type="hidden" value="{{$comment->id}}">
                            <input name="userType" type="hidden" value="other">
                            @csrf
                        </form>
                    </div>
                @endforeach

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>


        </div>
    </div>
@stop


@section('script-files')

@stop


@section('javascript')
    <script>
		$(document).ready(function() {
			$('.delete-feedback').click(function(event){
				$(this).parent().find('form.comment-destroy').submit();
				event.preventDefault();
			});

            $('#change-view').click(function(event) {
                event.preventDefault();                
                var $el = $('#vertical-timeline').toggleClass('center-orientation');
                if ($el.hasClass('center-orientation')) {
                    $(this).text('Left');
                    $(this).addClass('btn-info');
                    $(this).removeClass('btn-primary');                    
                }else{
                    $(this).text('Center')
                    $(this).addClass('btn-primary');
                    $(this).removeClass('btn-info');
                }                
            });
		});
    </script>
@stop

