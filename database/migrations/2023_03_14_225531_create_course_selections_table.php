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
            $table->timestamp("cart_add_date")->nullable();
            $table->boolean('is_checkout')->default(False);

            
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');
            //$table->foreignId('course_id')->constrained();

            
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('users');

            $table->softDeletes();
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
