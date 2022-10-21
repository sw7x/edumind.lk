<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();




            $table->timestamp("cart_add_date")->nullable();
            $table->timestamp("enroll_date")->nullable();
            $table->timestamp("complete_date")->nullable();

            $table->decimal('discount_amount',10,2)->nullable();

            $table->integer('rating')->nullable();



            //course - fk
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');

            //student - fk
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('users');


            $table->integer('comment_id')->nullable(); //todo fk link to enrollment_comments table

            $table->enum('status', ['cart_added','enrolled','completed'])->default('cart_added');

            $table->timestamps();
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
        Schema::dropIfExists('enrollments');
    }
}
