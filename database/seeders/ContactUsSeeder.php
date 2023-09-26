<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {                        
            ContactUs::factory()->count(200)->create();
        } catch (\Exception $e) {
            $this->command->error('Failed to seed contact us messages(user feedbacks) to database !');
        }
    }
}
