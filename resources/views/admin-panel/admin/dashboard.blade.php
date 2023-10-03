@extends('admin-panel.layouts.master',['title' => 'Dashboard'])
@section('title','Dashboard(A)')

@section('css-files')
@stop




@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                @if(Session::has('message'))
                    <x-flash-message  
                        :class="Session::get('cls', 'flash-info')"  
                        :title="Session::get('msgTitle') ?? 'Info!'" 
                        :message="Session::get('message') ?? ''"  
                        :message2="Session::get('message2') ?? ''"  
                        :canClose="true" />
                @endif                
            </div>
        </div>
    </div>




    <div class="row" id="_sortable-view">
        <div class="col-lg-12">

            {{route('admin.404')}}<br />
            {{route('admin.500')}}<br />
            
			<h1 class="font-bold my-1">editor dashboard</h1>
            <h2 class="font-bold my-1">Total users</h2>
			[{{Sentinel::check()}}]
        </div>
    </div><div class="hr-line-dashed"></div>



    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title pt-2">                                                       
                    <i class="float-left fa fa-book fa-2x py-1 w-5 mr-5"></i>                           
                    <h2 class="float-left font-bold my-0 p-0 text-2xl">SUBJECTS</h2>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="">                         
                    
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Status</p>
                        </legend>

                        <div class="row">                            
                            <div class="col-lg-4">
                                <div class="widget style1 dark-bg">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-2xl">Total</div>
                                        <div class="col-4 text-right">
                                            <h2 class="font-bold">217</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="widget style1 navy-bg">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-2xl">Published</div>
                                        <div class="col-4 text-right">
                                            <h2 class="font-bold">200</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="widget style1 yellow-bg">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-2xl">Draft</div>
                                        <div class="col-4 text-right">
                                            <h2 class="font-bold">17</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>                    

                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title pt-2">                                                       
                    <i class="float-left fa fa-user-circle-o fa-2x py-1 w-5 mr-5"></i>                          
                    <h2 class="float-left font-bold my-0 p-0 text-2xl">Users</h2>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="">                         
                    
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">User types</p>
                        </legend>                            
                    
                        <div class="row">                               
                            <div class="col-lg-3">
                                <div class="widget style1 dark-bg">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Students</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="widget style1 dark-bg">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Teachers</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="widget style1 dark-bg">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Marketers</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">217</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="widget style1 dark-bg">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Editors</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">217</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                                                 
                    <div class="hr-line-dashed"></div>
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">New registrations <small>(today)</small></p>
                        </legend>                            
                        
                        <div class="row">                               
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Students</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Teachers</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">17</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>


                    <div class="hr-line-dashed"></div>
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Teacher requests</p>
                        </legend>                           
                        
                        <div class="row">                               
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Account approve</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">profile changes</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">17</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="hr-line-dashed"></div>
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Student requests</p>
                        </legend>                           
                        
                        <div class="row">                               
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Account approve</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">profile changes</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">17</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                </div>
            </div>
        </div>        
    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title pt-2">                                                       
                    <i class="float-left fa fa-graduation-cap fa-2x py-1 w-5 mr-5"></i>                         
                    <h2 class="float-left font-bold my-0 p-0 text-2xl">COURSES</h2>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                
                <div class="ibox-content">                      
                    
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Status</p>
                        </legend>                            
                        
                        <div class="row">                               
                            <div class="col-lg-4">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-2xl">Total</div>
                                        <div class="col-4 text-right">
                                            <h2 class="font-bold">217</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="widget style1 navy-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-2xl">Published</div>
                                        <div class="col-4 text-right">
                                            <h2 class="font-bold">200</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="widget style1 yellow-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-2xl">Draft</div>
                                        <div class="col-4 text-right">
                                            <h2 class="font-bold">17</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>


                    <div class="hr-line-dashed"></div>
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Actions</p>
                        </legend>                            
                        
                        <div class="row">                               
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Enrollements</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Completions</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">17</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>




                    <div class="hr-line-dashed"></div>
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Recent actions</p>
                        </legend>                            
                        
                        <div class="row">                               
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Enrollements <small>(today)</small></div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Completions <small>(today)</small></div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">17</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>


                    <div class="hr-line-dashed"></div>
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Course requests</p>
                        </legend>                            
                        
                        <div class="row">                               
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Publish requests</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Chnage requests</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">17</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                </div>

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title pt-2">                                                       
                    <i class="float-left fa fa-book fa-2x py-1 w-5 mr-5"></i>                           
                    <h2 class="float-left font-bold my-0 p-0 text-2xl">Earnings</h2>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="">                        
                    <div class="row">                            
                        <div class="col-lg-6">
                            <div class="widget style1 dark-bg">
                                <div class="row vertical-align">
                                    <div class="col-8 text-2xl">Total amount</div>
                                    <div class="col-4 text-right">
                                        <h2 class="font-bold">217</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="widget style1 dark-bg">
                                <div class="row vertical-align">
                                    <div class="col-8 text-2xl">Today amount</div>
                                    <div class="col-4 text-right">
                                        <h2 class="font-bold">200</h2>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>                
                </div>
            </div>
        </div>
    </div>









    

    

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title pt-2">                                                       
                    <i class="float-left fa fa-credit-card fa-2x py-1 w-5 mr-5"></i>                            
                    <h2 class="float-left font-bold my-0 p-0 text-2xl">Coupon codes</h2>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>                                
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                
                <div class="ibox-content">

                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Status count</p>
                        </legend>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-xl">Total</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">217</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="widget style1 navy-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-xl">Published</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="widget style1 yellow-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-xl">Draft</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">17</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>


                    <div class="hr-line-dashed"></div>                          
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Works for</p>
                        </legend>    
                        <div class="row">                               
                            <div class="col-lg-4">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Any Courses</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">217</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="widget style1 navy-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Multiple Courses</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="widget style1 yellow-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Single Course</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">17</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div class="hr-line-dashed"></div>
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Used count</p>
                        </legend>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">All</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">217</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Today</div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">217</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div class="hr-line-dashed"></div>
                    <fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
                            <p class="text-center">Discount amount</p>
                        </legend>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Total <small>(Amount)</small></div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">217</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="widget style1 dark-bg text-white">
                                    <div class="row vertical-align">
                                        <div class="col-8 text-lg">Today <small>(Amount)</small></div>
                                        <div class="col-4 text-right">
                                            <h3 class="font-bold">200</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>       
                        </div>
                    </fieldset>
                    
                </div>

            </div>
        </div>
    </div>

    

    
    







    





    
@stop




@section('script-files')

@stop


@section('javascript')

@stop

