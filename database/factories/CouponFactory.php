<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use Sentinel;




class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $totalCount   = $this->faker->numberBetween(10, 20);
        $usedCount    = $totalCount - $this->faker->numberBetween(0, 9);


        $teachers       = Sentinel::findRoleBySlug('teacher')->users()->with('roles')->get();
        $marketers      = Sentinel::findRoleBySlug('marketer')->users()->with('roles')->get();
        $beneficiaries  = collect([null])->merge($teachers)->merge($marketers)->merge([null,null])->shuffle();

        

        return [
            
            //$table->string('code', 6)->primary();
            'code'                                              => $this->faker->unique()->regexify('[A-Z0-9]{6}'),
            'discount_percentage'                               => $this->faker->randomFloat(2, 5, 20),
            'beneficiary_commision_percentage_from_discount'    => $this->faker->randomFloat(2, 0, 100),
            'total_count'                                       => $totalCount,
            'used_count'                                        => $usedCount,
            'is_enabled'                                        => $this->faker->randomElement([true,false,true,true,true]),
            'course_id'                                         => $this->faker->randomElement([
                                                                        Course::inRandomOrder()->first()->id,
                                                                        Course::inRandomOrder()->first()->id,
                                                                        null
                                                                    ]),
            'beneficiary_id'                                    => $beneficiaries->first(),////     
        ];
    }
}
