@extends('layouts.master')
@section('title','billing information')




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">

            <form class="bill-info">
                <div class="bg-white grid grid-cols-2 gap-3 lg:p-6 p-4 wrapper">
                    <div class="col-span-2">
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Billing details Page</h2>
                        <hr class="mb-5">
                    </div>

                    <div>
                        <label for="first-name">First name <span class="text-red-500 text-lg">*</span></label>
                        <input type="text" placeholder="" id="first-name" class="shadow-none with-border">
                    </div>

                    <div class="">
                        <label for="lname">Last name <span class="text-red-500 text-lg">*</span></label>
                        <input id="lname" name="lname" type="text" class="form-control shadow-none with-border">
                    </div>

                    <div class="">
                        <label for="country">Country / Region  <span class="text-red-500 text-lg">*</span></label>
                        <div>
                            <select id="country" name="country" class="selectpicker">
                                <option value="rabbit">Rabbit</option>
                                <option value="duck">Duck</option>
                                <option value="fish">Fish</option>
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <label for="city">Town / City  <span class="text-red-500 text-lg">*</span></label>
                        <input id="city" name="city" type="text" class="form-control shadow-none with-border">
                    </div>

                    <div class="col-span-2">
                        <label for="street_address">Street Address  <span class="text-red-500 text-lg">*</span></label>
                        <input id="street_address" name="street_address" type="text" class="form-control shadow-none with-border">
                    </div>

                    <div class="form-group">
                        <label for="postal_code">Postcode / ZIP  <span class="text-red-500 text-lg">*</span></label>
                        <input id="postal_code" name="postal_code" type="text" class="form-control shadow-none with-border">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone  <span class="text-red-500 text-lg">*</span></label>
                        <input id="phone" name="phone" type="text" class="form-control shadow-none with-border">
                    </div>

                    <div class="col-span-2">
                        <label for="email">Email address  <span class="text-red-500 text-lg">*</span></label>
                        <input id="email" name="email" type="text" class="form-control shadow-none with-border">
                    </div>

                    <div class="col-span-2">
                        <label for="additional_info">Additional information (optional)</label>
                        <textarea id="additional_info" name="additional_info" cols="40" rows="5" class="form-control shadow-none with-border"></textarea>
                    </div>

                    <div class="col-span-2">
                        <button name="submit" type="submit" class="btn-w-m bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Place Order</button>
                        <button name="clear" type="reset" class="btn-w-m bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded min-w-min">Clear</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
@stop

@section('script-files')

@stop

