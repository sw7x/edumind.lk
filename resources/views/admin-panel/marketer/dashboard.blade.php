@extends('admin-panel.layouts.master',['title' => 'Marketer Dashboard'])
@section('title','Dashboard(m)')

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
			
			<div class="row mb-5">
				<div class="col-lg-12">
					<h2>salary</h2>
				</div>
			</div>


			<div class="row mb-4">				
	            <div class="col-lg-3">
	                <div class="widget style1 border-1 border-gray-500">
                        <div class="row">
                            <div class="col-4 text-center">
                                <i class="fa fa-book fa-4x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span class="text-lg">Subjects</span>
                                <h2 class="font-bold">112</h2>
                            </div>
                        </div>
	                </div>
	            </div>
	            <div class="col-lg-3">
	                <div class="widget style1 border-1 border-gray-500">
                        <div class="row">
                            <div class="col-4 text-center">
                                <i class="fa fa-graduation-cap fa-4x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span  class="text-lg">Courses</span>
                                <h2 class="font-bold">232</h2>
                            </div>
                        </div>
	                </div>
	            </div>
	            <div class="col-lg-3">
	                <div class="widget style1 border-1 border-gray-500">
                        <div class="row">
                            <div class="col-4 text-center">
                                <i class="fa fa-user-circle-o fa-4x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span  class="text-lg">Teachers</span>
                                <h2 class="font-bold">21</h2>
                            </div>
                        </div>
	                </div>
	            </div>
	            <div class="col-lg-3">
	                <div class="widget style1 border-1 border-gray-500">
                        <div class="row">
                            <div class="col-4 text-center">
                                <i class="fa fa-user fa-4x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span class="text-lg">Students</span>
                                <h2 class="font-bold">256</h2>
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
                            <h2 class="float-left font-bold my-0 p-0 text-2xl">Coupon codes - Count</h2>
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
		                            <p class="text-center">All</p>
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
		                            <p class="text-center">My</p>
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
					    </div>
                    </div>
                </div>
            </div>

            <div class="row">
				<div class="col-lg-12">
            		<div class="ibox">
                        <div class="ibox-title pt-2">                        	                     		
                        	<i class="float-left fa fa-credit-card fa-2x py-1 w-5 mr-5"></i>                        	
                            <h2 class="float-left font-bold my-0 p-0 text-2xl">Coupon codes - Works for</h2>
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
		                            <p class="text-center">All</p>
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
		                            <p class="text-center">My</p>
		                        </legend>
					            <div class="row">				            	
					            	<div class="col-lg-4">
					                    <div class="widget style1 dark-bg text-white">
					                        <div class="row vertical-align">
					                            <div class="col-8 text-lg">Any course</div>
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
				        	
				        </div>

                    </div>
                </div>
            </div>

			<div class="row">
				<div class="col-lg-12">
            		<div class="ibox">
                        <div class="ibox-title pt-2">                        	                     		
                        	<i class="float-left fa fa-credit-card fa-2x py-1 w-5 mr-5"></i>                        	
                            <h2 class="float-left font-bold my-0 p-0 text-2xl">Coupon codes - Used count</h2>
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
				                            <div class="col-8 text-lg">My</div>
				                            <div class="col-4 text-right">
				                                <h3 class="font-bold">217</h3>
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
                            <h2 class="float-left font-bold my-0 p-0 text-2xl">Coupon codes - Discount amount</h2>
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
		                            <p class="text-center">All</p>
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
					                    <div class="widget style1 navy-bg text-white">
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
				        	
							
							<div class="hr-line-dashed"></div>
							<fieldset class="p-3 border-solid border-1 border-gray-700 mt-2">
		                        <legend class="font-bold rounded col-sm-4 text-xl py-1 border-gray-500 border-1">
		                            <p class="text-center">My</p>
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
        
        </div>
    </div>
    <div class="hr-line-dashed"></div>





@stop




@section('script-files')

@stop


@section('javascript')

@stop

