<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_salaries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->text('image')->nullable();
            $table->decimal('paid_amount',10,2)->nullable();
            $table->timestamp("paid_date")->nullable();
            $table->string('remarks')->nullable();
            $table->date('from_date');
            $table->date('to_date');           
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
        Schema::dropIfExists('author_salaries');
    }
}



