<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {


            $table->increments('id');
            $table->string('uuid')->unique();
            $table->string('name',25);
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->string('slug')->nullable();
            $table->enum('status', ['draft','published'])->default('published');
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
        // Schema::table('courses', function (Blueprint $table) {
        //    $table->dropForeign(['subject_id']);

        // });
        // Schema::table('courses', function (Blueprint $table) {
        //    $table->dropColumn('subject_id');

        // });



        Schema::dropIfExists('subjects');
    }
}