@extends('layouts.master')
@section('title','Student profile')




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
                      
            @if(isset($userData) && is_array($userData))
                <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                    <div id="announcement" class="tube-card p-5 lg:p-8">
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">{{$userData['fullName']}} profile</h2>
                        <hr class="mb-5">

                        <div class="flex items-center gap-x-4 mb-5">
                            <img src="{{asset('images/default-images/student.png')}}" alt="" class="rounded-full shadow w-20 h-20">
                            <div>
                                <h4 class="mb-0 text-base">{{$userData['fullName']}}</h4>
                                <span class="text-sm"> Student<br>
                                    @if(isset($userData['createdAtAgo']))
                                        <span class="text-gray-500">Registed : {{$userData['createdAtAgo']}}</span>
                                    @endif
                                </span>
                            </div>
                        </div>


                        <p class="text-blue-900 text-sm mb-7 mt-2">{!! $userData['profileText'] !!}</p>

                        <div class="text-blue-900 text-sm mb-7 mt-2">
                            <table class="text-blue-900 text-sm smitty-table table table-striped left-align-cells">
                                <tbody>
                                    <tr>
                                        <td class="text-left">Email</td>
                                        <td class="text-left">{{$userData['email']}}</td>
                                    </tr>
                                   <tr>
                                        <td>Phone</td>
                                        <td>{{$userData['phone']}}</td>
                                    </tr>
                                   <tr>
                                        <td>Profile ID</td>
                                        <td>{{$userData['username']}}</td>
                                    </tr>
                                   <tr>
                                        <td>Gender</td>
                                        <td>{{$userData['gender']}}</td>
                                    </tr>
                                   <tr>
                                        <td>Birth year</td>
                                        <td>{{$userData['dobYear'] }}</td>
                                    </tr>
                                   <tr>
                                        <td>Account status</td>
                                        <td>{{($userData['status'] == 1) ? 'Enable' : 'Disable'}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            @else
                <x-flash-message
                    class="flash-danger"  
                    title="Error!" 
                    message="Profile data is not available or not in correct format"  
                    message2=""  
                    :canClose="false" />
            @endif           

        </div>
    </div>
@stop
