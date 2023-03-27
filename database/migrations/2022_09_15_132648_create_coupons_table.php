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
            
            $table->string('code', 6)->primary();

            //100.00% is stored as 100.00
            $table->decimal('discount_percentage', 5,2)->default(10.00);
            $table->decimal('beneficiary_commision_percentage_from_discount', 5,2)->default(100.00);

            $table->integer('total_count');
            $table->integer('used_count');          

            $table->boolean('is_enabled')->default(True);

            //course - fk
            $table->integer('course_id')->nullable()->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');

            //users (marketer,teacher) - fk
            $table->integer('beneficiary_id')->nullable()->unsigned();
            $table->foreign('beneficiary_id')->references('id')->on('users');

            
            


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
        Schema::dropIfExists('coupons');
    }
}
