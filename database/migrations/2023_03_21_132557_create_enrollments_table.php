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

            //course_selections - fk
            $table->unsignedBigInteger('course_selection_id');
            $table->foreign('course_selection_id')->references('id')->on('course_selections');
            

            //$table->timestamp("enroll_date")->nullable();                       
            $table->boolean('is_complete')->default(False);
            $table->timestamp("complete_date")->nullable();
            $table->integer('rating')->nullable();
            


            
       

            $table->decimal('edumind_amount',10,2)->nullable();
            $table->decimal('author_amount',10,2)->nullable();
            
            //invoices - fk
            $table->integer('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoices');


            //salaries - fk
            $table->integer('salary_id')->nullable()->unsigned();
            $table->foreign('salary_id')->references('id')->on('salaries');



            $table->string('used_cupon_code')->nullable();
            $table->foreign('used_cupon_code')->references('code')->on('coupons');
            //->onDelete('cascade');
            
            $table->decimal('discount_amount',10,2)->nullable();
            $table->decimal('price_afeter_discouunt',10,2)->nullable();           
            
            $table->decimal('edumind_lose_amount',10,2)->nullable();          
            $table->decimal('benificiary_earn_amount',10,2)->nullable();

            //commissions - fk
            $table->integer('commission_id')->nullable()->unsigned();
            $table->foreign('commission_id')->references('id')->on('commissions');


        

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
