<div {{ $attributes->merge(['class'=>'flash-msg'])}}>
    
	@if($canClose === true)
    	<a href="#" class="close">×</a>
    @endif
    
    <div class="text-lg"><strong>{{ $title ?? 'Info!'}}</strong></div>

    <p class="text-base">{{ $message ?? '' }}</p>
    
    @isset($message2)
    	<div class="text-sm">{!! $message2 ?? '' !!}</div>
    @endif

    @isset($insideContent)
    	{{$insideContent}}
    @endisset



</div>



