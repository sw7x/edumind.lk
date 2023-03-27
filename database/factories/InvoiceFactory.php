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
        return [
            'checkout_date'     =>  $this->faker->dateTimeBetween('-4 week', '-3 week'),            
            'billing_info'      =>  $this->faker->address()            
        ];
    }
}
