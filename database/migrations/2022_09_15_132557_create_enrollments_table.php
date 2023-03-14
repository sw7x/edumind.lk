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
            $table->timestamp("enroll_date")->nullable();                       
            $table->boolean('is_complete')->default(False);
            $table->timestamp("complete_date")->nullable();


            $table->integer('rating')->nullable();
            $table->decimal('discount_amount',10,2)->nullable();
            $table->decimal('price_afeter_discouunt',10,2)->nullable();
            
       

            $table->decimal('edumind_amount',10,2)->nullable();
            $table->decimal('author_amount',10,2)->nullable();
            $table->decimal('edumind_lose_amount',10,2)->nullable();          
            $table->decimal('benificiary_earn_amount',10,2)->nullable();


            //orders - fk
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            //invoices - fk
            $table->integer('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoices');

            //salaries - fk
            $table->integer('salary_id')->unsigned();
            $table->foreign('salary_id')->references('id')->on('salaries');

            $table->string('cupon_code');
            $table->foreign('cupon_code')->references('code')->on('coupons');
              //->onDelete('cascade');



        

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
