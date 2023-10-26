<?php  
    use App\Models\Role as RoleModel;
    use App\Data\RoleEnum;
    use App\Permissions\Abilities\CartAbilities;
?>



{{-- [page - {{$page}}] --}}

@if(Sentinel::check())
    @if($currentUserRole == RoleEnum::STUDENT)

        @if($data_arr['price'] != 0)                                 
            @if ($enroll_status == 'FRESH')
                
                @can(CartAbilities::ADD_TO_CART)
                    <form action="{{route('course.addToCart')}}" method="post" class='course-enroll-form'>
                        {{csrf_field ()}}
                        <div class="mt-4">
                            <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white">Add to Cart</button>
                        </div>
                        <input name="courseId" type="hidden" value="{{$data_arr['id']}}">
                    </form>
                @endcan

            @elseif ($enroll_status =='ADDED_TO_CART')                                    
                
                @can(CartAbilities::VIEW_CART)
                    <div class="mt-4">
                        <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white"
                                onclick='window.location=`{{ route("view-cart")}}`'>View Cart</button>
                    </div>  
                @endcan

            @else                                       
            @endif
        @else
            @if($enroll_status =='FRESH')
                <form action="{{route('courses.free-enroll')}}" method="post" class='course-enroll-form'>
                    {{csrf_field ()}}
                    <div class="mt-4">
                        <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white">Enroll Now</button>
                    </div>
                    <input name="courseId" type="hidden" value="{{$data_arr['id']}}">
                </form>
            @endif
        @endif 

        
        @if($enroll_status =='ENROLLED')
            <form action="{{route('courses.complete')}}" method="post" class='course-complete-form'>
                {{csrf_field ()}}
                <div class="mt-4">
                    <button type="submit" class="w-full h-9 px-6 rounded-md bg-green-600 hover:bg-green-400 hover:text-white text-white">Complete course</button>
                </div>
                <input name="courseId" type="hidden" value="{{$data_arr['id']}}">
            </form>
        @endif

        @if($enroll_status =='COMPLETED')
            <div class="mt-2">
                <div class="flex items-center justify-center h-24 px-6 rounded-md bg-green-100 text-green-600 border-2 border-green-600 font-semibold">This course has been completed by you</div>
            </div>
        @endif


    @endif
@else
    @if($data_arr['price'] != 0)                               
        
        @can(CartAbilities::ADD_TO_CART)
            <form action="{{route('courses.guest-enroll')}}" method="get" class='course-enroll-form'>
                {{csrf_field ()}}
                <div class="mt-4">
                    <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white">Add to Cart</button>
                </div>
            </form>
        @endcan

    @else                                
        <form action="{{route('courses.guest-enroll')}}" method="get" class='course-enroll-form'>
            {{csrf_field ()}}
            <div class="mt-4">
                <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white">Enroll Now</button>
            </div>
        </form>                                                               
    @endif
@endif

