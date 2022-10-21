<?php

namespace Database\Seeders;

use App\Models\Contact_us;
use Illuminate\Database\Seeder;

class Contact_usSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact_us::factory()->count(200)->create();
    }
}
