<div {{ $attributes->merge(['class'=>'flash-msg'])}}>
    
	@if($canClose === true)
    	<a href="#" class="close">×</a>
    @endif
    
    <div class="text-lg"><strong>{{ $title ?? 'Info!'}}</strong></div>

    <p>{{ $message ?? 'Info!' }}</p>
    
    @isset($message2)
    	<div class="text-base">{!! $message2 ?? '' !!}</div>
    @endif

    @isset($insideContent)
    	{{$insideContent}}
    @endisset



</div>



