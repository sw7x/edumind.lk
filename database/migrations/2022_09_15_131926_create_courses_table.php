<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::dropIfExists('courses');
        Schema::create('courses', function (Blueprint $table) {

            $table->increments('id');
            $table->string('uuid')->unique();
            $table->text('name'); // course name
            
            $table->text('heading_text')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->enum('status', ['draft','published'])->default('published');

            $table->text('topics')->nullable();
            $table->text('content')->nullable();

            //$table->string('slug')->unique()->nullable();
            $table->string('slug')->nullable();

            //subject -fk
            //$table->foreign('other_table_id')->nullable()
                //->references('id')->on('other_table');

            $table->integer('subject_id')->nullable()->unsigned();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');


            //teacher - fk
            $table->integer('teacher_id')->nullable()->unsigned();
            $table->foreign('teacher_id')->references('id')->on('users');


            $table->decimal('author_share_percentage', 4, 2)->default (60.00);




            $table->decimal('price',10,2)->nullable();
            $table->integer('video_count')->nullable();
            $table->string('duration')->nullable();

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
        //<table_name>_<column_name>_foreign

        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['teacher_id']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('subject_id');
            $table->dropColumn('teacher_id');
        });

        Schema::dropIfExists('courses');
    }
}
