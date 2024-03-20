@extends('admin-panel.layouts.master')
@section('title','Teacher feedback')

@section('css-files')
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
            
            @if(isset($teacherComments) && isNotEmptyArray($teacherComments)) 
                <div class="ibox ">                
                    <div class="ibox-content relative forum-post-container" id="ibox-content">
                        
                        <div class="text-center p-2 absolute top-1 right-1">
                            <span> Change the orientation : </span>
                            <a href="#" class="min-size ml-3 btn btn-xs btn-info" id="change-view">Left</a>
                        </div>
        

                        <div id="vertical-timeline" class="mt-5 __vertical-container dark-timeline center-orientation">
                            @foreach($teacherComments as $comment)
                                @php
                                    //var_dump($comment->user->id);
                                    //dump($comment['id']);
                                    //dump($comment->user()->withoutGlobalScope('active')->get());
                                    //dump('===');
                                @endphp
                                                    
                                <div class="vertical-timeline-block teacher-block">
                                    <div class="vertical-timeline-icon p-1 {{ ($loop->index%2 == 0) ? 'blue-bg' : 'lazur-bg'}}">
                                        @if($comment['profilePic'] != null)
                                            <img src="{{$comment['profilePic']}}" class="w-full h-full rounded-full" alt="image">
                                        @endif
                                    </div>

                                    <div class="vertical-timeline-content rounded-lg">
                                        <h2>{{$comment['subject']}}</h2>
                                        <p>{{$comment['message']}}</p>                                  
                                        
                                        <div class="text-xs">
                                            <strong>Name : </strong>    {{$comment['fullName']}} 
                                            @isset($comment['userArr']['isTrashed'])
                                                - <span class="text-red">{{$comment['userArr']['isTrashed'] ? '(Trashed)' : ''}}</span>
                                            @endisset
                                            
                                            @if(!$comment['userStat']) <span class="text-red">[Disabled]</span> @endif
                                        </div>
                                        <div class="text-xs"><strong>Email : </strong>   {{$comment['email']}}</div>
                                        <div class="text-xs"><strong>Phone : </strong>   {{$comment['phone']}}</div>

                                        @if($comment['createdAt'])
                                            <span class="vertical-date">
                                                <strong>{{$comment['createdAtAgo']}}</strong><br/>
                                                <small>{{$comment['createdAt']}}</small>
                                            </span>
                                        @endif

                                        <a href="#" data-id="{{$comment['id']}}" class="absolute top-0.5 right-1 rounded text-danger text-lg delete-feedback">
                                            <i class="text-3xl fa fa-times-circle-o"></i>
                                        </a>
                                        <form class="comment-destroy" action="{{ route('admin.feedbacks.delete-comment', $comment['id']) }}" method="POST">
                                            @method('DELETE')
                                            <input name="commentId" type="hidden" value="{{$comment['id']}}">
                                            <input name="userType" type="hidden" value="teacher">
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
            @else                
                <x-flash-message 
                    class="flash-danger"  
                    title="Data not available!" 
                    message="Teachers messages are not available or not in correct format"  
                    message2=""  
                    :canClose="false" />                
            @endif
            
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
