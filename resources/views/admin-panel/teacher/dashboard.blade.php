@extends('admin-panel.layouts.master',['title' => 'Teacher Dashboard'])
@section('title','Dashboard(t)')



@section('css-files')
@stop




@section('content')
	
	<div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                @if(Session::has('message'))
                <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                    <p>{{ Session::get('message') ?? 'Info!' }}</p>
                    <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                </div>
                @endif                
            </div>
        </div>
    </div>
    

    <div class="row" id="_sortable-view">        
    	<div class="col-lg-12">
			
			<div class="row">
				<div class="col-lg-12">
					<h2 class="font-bold my-1">salary</h2>
                	<h2 class="font-bold my-1">earnings</h2>
                	<h2 class="font-bold my-1">cupon code</h2>
                </div>
            </div>
               

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
				            <div class="row">				            	
				            	<div class="col-lg-6">
				                    <div class="widget style1 dark-bg">
				                        <div class="row vertical-align">
				                            <div class="col-8 text-2xl">Students</div>
				                            <div class="col-4 text-right">
				                                <h2 class="font-bold">200</h2>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="col-lg-6">
				                    <div class="widget style1 dark-bg">
				                        <div class="row vertical-align">
				                            <div class="col-8 text-2xl">Teachers</div>
				                            <div class="col-4 text-right">
				                                <h2 class="font-bold">217</h2>
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
		                            <p class="text-center">All courses</p>
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
		                            <p class="text-center">My courses</p>
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


					            <div class="row">				            	
					            	<div class="col-lg-6">
					                    <div class="widget style1 dark-bg opacity-85 text-white">
					                        <div class="row vertical-align">
					                            <div class="col-8 text-2xl">Enrollements</div>
					                            <div class="col-4 text-right">
					                                <h2 class="font-bold">217</h2>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					                <div class="col-lg-6">
					                    <div class="widget style1 dark-bg opacity-85 text-white	">
					                        <div class="row vertical-align">
					                            <div class="col-8 text-2xl">Completions</div>
					                            <div class="col-4 text-right">
					                                <h2 class="font-bold">217</h2>
					                            </div>
					                        </div>
					                    </div>
					                </div>				                
					            </div>
					        </fieldset>
					        

							
							<div class="hr-line-dashed"></div> 
							<fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
		                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
		                            <p class="text-center">Recent</p>
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
				        	



                        </div>

                    </div>
                </div>
            </div>

            
        </div>
    </div>
    <div class="hr-line-dashed"></div>





@stop




@section('script-files')

@stop


@section('javascript')

@stop

