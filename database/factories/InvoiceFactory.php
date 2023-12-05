<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $dateTime = $this->faker->dateTimeBetween('-4 week', '-3 week');

        return [
            //'checkout_date'   =>  $this->faker->dateTimeBetween('-4 week', '-3 week'),
            'checkout_date'     =>  $dateTime->format('Y-m-d'),           
            
            'billing_info'      =>  $this->faker->address(),
            'paid_amount'       =>  0,           
        ];
    }
}