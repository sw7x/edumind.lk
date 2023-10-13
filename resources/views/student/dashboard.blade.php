@extends('layouts.master')
@section('title','Student dashboard')




@section('content')
    <div class="main-container container">
        <div class="max-w-full  md:p-2 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">

                <div style="flex:1">

                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Dashboard</h2>
                    <hr class="mb-5">
                    <!-- <h4 class="font-semibold mb-2 text-base"> Description </h4>    -->
                    
                    <?php $studentData = array(1,2,3);?>
                    @if(isset($studentData) && isNotEmptyArray($studentData))    
                        <section class="tabs-section">
                            <div class="_container">
                                <div class="row">

                                <div class="col-md-3 col-lg-3 nav-section">
                                    @include('includes.student-profile-menu')
                                </div>

                                <div class="col-md-9 col-lg-9 content-section">
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="tab-1">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <div class="tube-card p-3 lg:p-6">
                                                        <div class="text-blue-900 text-sm mb-7 mt-2">

                                                            <table class="smitty-table table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Attribute</th>
                                                                            <th scope="col">Value</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Total courses</td>
                                                                            <td>19</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Published courses</td>
                                                                            <td>12</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Draft courses</td>
                                                                            <td>7</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Enrolled students</td>
                                                                            <td>32</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Course complete students</td>
                                                                            <td>13</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Total eraning</td>
                                                                            <td>Rs 20,000</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                </div>
                            </div>
                        </section>
                    @else
                        <x-flash-message 
                            class="flash-danger"  
                            title="Data not available!" 
                            message="Dashboard data is not available or not in correct format"  
                            message2=""  
                            :canClose="false" />
                    @endif
                    
                </div>

            </div>
        </div>
    </div>
@stop
