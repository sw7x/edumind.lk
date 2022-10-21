<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');


            //100.00% is stored as 100.00
            $table->decimal('discount_percentage', 5,2);

            $table->integer('count');

            //course - fk
            $table->integer('course_id')->nullable()->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');

            //users (marketer) - fk
            $table->integer('marketer_id')->nullable()->unsigned();
            $table->foreign('marketer_id')->references('id')->on('users');

            //0-disable, 1 - enable
            $table->boolean('is_enabled')->default(1);

            $table->timestamps();
            $table->softDeletes();
            //todo? - current_discount_amount

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
