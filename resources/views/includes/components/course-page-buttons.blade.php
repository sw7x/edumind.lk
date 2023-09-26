
<?php  
    //dump(Sentinel::check());
   // dump(Sentinel::getUser()->roles()->first()->slug);
   // dump($data_arr);
   // dump($data_arr->price);
   // dump($enroll_status);
   
    //dd();
?>



[{{$page}}]

@if(Sentinel::check())
    @if(Sentinel::getUser()->roles()->first()->slug == App\Models\Role::STUDENT)

        @if($data_arr->price != 0)                                 
            @if ($enroll_status == 'FRESH')
                <form action="{{route('course.addToCart')}}" method="post" class='course-enroll-form'>
                    {{csrf_field ()}}
                    <div class="mt-4">
                        <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white">Add to Cart</button>
                    </div>
                    <input name="courseId" type="hidden" value="{{$data_arr->id}}">
                </form>
            @elseif ($enroll_status =='ADDED_TO_CART')                                    
                <div class="mt-4">
                    <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white"
                            onclick='window.location=`{{ route("view-cart")}}`'>View Cart</button>
                </div>                                       
            @else                                       
            @endif
        @else
            @if($enroll_status =='FRESH')
                <form action="{{route('course.free-enroll')}}" method="post" class='course-enroll-form'>
                    {{csrf_field ()}}
                    <div class="mt-4">
                        <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white">Enroll Now</button>
                    </div>
                    <input name="courseId" type="hidden" value="{{$data_arr->id}}">
                </form>
            @endif
        @endif 

        
        @if($enroll_status =='ENROLLED')
            <form action="{{route('course.complete')}}" method="post" class='course-complete-form'>
                {{csrf_field ()}}
                <div class="mt-4">
                    <button type="submit" class="w-full h-9 px-6 rounded-md bg-green-600 hover:bg-green-400 hover:text-white text-white">Complete course</button>
                </div>
                <input name="courseId" type="hidden" value="{{$data_arr->id}}">
            </form>
        @endif

        @if($enroll_status =='COMPLETED')
            <div class="mt-2">
                <div class="flex items-center justify-center h-24 px-6 rounded-md bg-green-100 text-green-600 border-2 border-green-600 font-semibold">This course has been completed by you</div>
            </div>
        @endif


    @endif
@else
    @if($data_arr->price != 0)                               
        <form action="{{route('course-guest-enroll')}}" method="get" class='course-enroll-form'>
            {{csrf_field ()}}
            <div class="mt-4">
                <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white">Add to Cart</button>
            </div>
        </form>
    @else                                
        <form action="{{route('course-guest-enroll')}}" method="get" class='course-enroll-form'>
            {{csrf_field ()}}
            <div class="mt-4">
                <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white">Enroll Now</button>
            </div>
        </form>                                                               
    @endif
@endif

