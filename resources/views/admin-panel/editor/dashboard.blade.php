@extends('admin-panel.layouts.master',['title' => 'Editor Dashboard'])
@section('title','Dashboard(e)')

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
				            	<div class="col-lg-3">
				            		<div class="widget style1 p-0">			                
				                        <div class="row">
				                            <div class="col-4 text-center">
				                                <i class="fa fa-book fa-5x"></i>
				                            </div>
				                            <div class="col-8 text-right">
				                            	{{--<span> Today income </span>--}}
				                                <h3 class="font-bold">Subjects</h3>
				                            </div>
				                        </div>
				                    </div>		                
					            </div>
				                <div class="col-lg-3">
				                    <div class="widget style1 dark-bg">
				                        <div class="row vertical-align">
				                            <div class="col-8 text-2xl">Total</div>
				                            <div class="col-4 text-right">
				                                <h2 class="font-bold">217</h2>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="col-lg-3">
				                    <div class="widget style1 navy-bg">
				                        <div class="row vertical-align">
				                            <div class="col-8 text-2xl">Published</div>
				                            <div class="col-4 text-right">
				                                <h2 class="font-bold">200</h2>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="col-lg-3">
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
				            	<div class="col-lg-3">
				            		<div class="widget style1 p-0">			                
				                        <div class="row">
				                            <div class="col-4 text-center">
				                                <i class="fa fa-user-circle-o fa-5x"></i>
				                            </div>
				                            <div class="col-8 text-right">
				                                <h3 class="font-bold">Users</h3>
				                            </div>
				                        </div>
				                    </div>		                
					            </div>
				                <div class="col-lg-5">
				                    <div class="widget style1 dark-bg">
				                        <div class="row vertical-align">
				                            <div class="col-8 text-2xl">Students</div>
				                            <div class="col-4 text-right">
				                                <h2 class="font-bold">200</h2>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="col-lg-4">
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
                            <h2 class="float-left font-bold my-0 p-0 text-2xl">Course</h2>
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
				            	<div class="col-lg-3">
				            		<div class="widget style1 p-0">			                
				                        <div class="row">
				                            <div class="col-4 text-center">
				                                <i class="fa fa-graduation-cap fa-5x"></i>
				                            </div>
				                            <div class="col-8 text-right">
				                                <h3 class="font-bold">Subjects</h3>
				                            </div>
				                        </div>
				                    </div>		                
					            </div>
				                <div class="col-lg-3">
				                    <div class="widget style1 dark-bg">
				                        <div class="row vertical-align">
				                            <div class="col-8 text-2xl">Total</div>
				                            <div class="col-4 text-right">
				                                <h2 class="font-bold">217</h2>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="col-lg-3">
				                    <div class="widget style1 navy-bg">
				                        <div class="row vertical-align">
				                            <div class="col-8 text-2xl">Published</div>
				                            <div class="col-4 text-right">
				                                <h2 class="font-bold">200</h2>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <div class="col-lg-3">
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
                        	<i class="float-left fa fa-check-circle fa-2x py-1 w-5 mr-5"></i>                        	
                            <h2 class="float-left font-bold my-0 p-0 text-2xl">Pending Approvals</h2>
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
		                            <p class="text-center">Subject</p>
		                        </legend>

					            <div class="row">				            	
					            	<div class="col-lg-12">
					                    <div class="widget style1 dark-bg text-white">
					                        <div class="row vertical-align">
					                            <div class="col-8 text-2xl">Need to approve</div>
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
		                            <p class="text-center">Courses</p>
		                        </legend>
					            <div class="row">				            	
					            	<div class="col-lg-6">
					                    <div class="widget style1 dark-bg text-white">
					                        <div class="row vertical-align">
					                            <div class="col-8 text-2xl">New</div>
					                            <div class="col-4 text-right">
					                                <h2 class="font-bold">217</h2>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					                <div class="col-lg-6">
					                    <div class="widget style1 dark-bg text-white">
					                        <div class="row vertical-align">
					                            <div class="col-8 text-2xl">Changes</div>
					                            <div class="col-4 text-right">
					                                <h2 class="font-bold">200</h2>
					                            </div>
					                        </div>
					                    </div>
					                </div>					                
					            </div>
					        </fieldset>					            
					        
							
							<div class="hr-line-dashed"></div> 
							<fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
		                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
		                            <p class="text-center">Teacher</p>
		                        </legend>
					            <div class="row">				            	
					            	<div class="col-lg-6">
					                    <div class="widget style1 dark-bg text-white">
					                        <div class="row vertical-align">
					                            <div class="col-8 text-2xl">Registrations</div>
					                            <div class="col-4 text-right">
					                                <h3 class="font-bold">200</h3>
					                            </div>
					                        </div>
					                    </div>
					                </div>
					                <div class="col-lg-6">
					                    <div class="widget style1 dark-bg text-white">
					                        <div class="row vertical-align">
					                            <div class="col-8 text-2xl">Account changes</div>
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

