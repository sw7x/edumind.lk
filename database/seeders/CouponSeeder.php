<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        try {                        
            Coupon::factory()->count(100)->create();
        } catch (\Exception $e) {
            $this->command->error('Failed to seed coupon to database !');
        }
    }
}
