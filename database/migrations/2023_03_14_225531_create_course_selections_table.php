<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSelectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_selections', function (Blueprint $table) {
            
            $table->id();
            $table->timestamp("cart_added_date")->nullable();
            $table->boolean('is_checkout')->default(False);

            
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');
            //$table->foreignId('course_id')->constrained();

            
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('users');

            $table->unique(['course_id','student_id']);





            $table->decimal('edumind_amount',10,2)->nullable();//
            $table->decimal('author_amount',10,2)->nullable();//
            
            $table->string('used_coupon_code')->nullable();/////
            $table->foreign('used_coupon_code')->references('code')->on('coupons');/////
            //->onDelete('cascade');
            
            $table->decimal('discount_amount',10,2)->nullable();////
            $table->decimal('revised_price',10,2)->nullable();  /////         
            
            $table->decimal('edumind_lose_amount',10,2)->nullable();   //       
            $table->decimal('benificiary_earn_amount',10,2)->nullable();////















            //$table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_selections');
    }
}
