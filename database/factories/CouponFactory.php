<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course as CourseModel;
use Sentinel;
use App\Models\Role as RoleModel;



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
        $usedCount    = $totalCount - $this->faker->numberBetween(0, 15);

        // to make some available count exceed coupon codes
        if ($usedCount < 0)
            $usedCount = $totalCount;

        $teachers       = Sentinel::findRoleBySlug(RoleModel::TEACHER)->users()->with('roles')->get();
        $marketers      = Sentinel::findRoleBySlug(RoleModel::MARKETER)->users()->with('roles')->get();
        $beneficiaries  = collect([null])->merge($teachers)->merge($marketers)->merge([null,null])->shuffle();

        return [

            //$table->string('code', 6)->primary();
            'code'                                              =>  $this->faker->unique()->regexify('[A-Z0-9]{6}'),
            'discount_percentage'                               =>  $this->faker->randomFloat(2, 5, 20),
            'beneficiary_commision_percentage_from_discount'    =>  $this->faker->randomFloat(2, 0, 100),
            'total_count'                                       =>  $totalCount,
            'used_count'                                        =>  $usedCount,
            'is_enabled'                                        =>  $this->faker->randomElement([true,false,true]),
            'cc_course_id'                                      =>  $this->faker->randomElement([
                                                                        CourseModel::inRandomOrder()->first()->id,
                                                                        CourseModel::inRandomOrder()->first()->id,
                                                                        null
                                                                    ]),
            'beneficiary_id'                                    =>  $beneficiaries->first(),////
        ];
    }
}
