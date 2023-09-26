<?php

namespace Database\Seeders;

use App\Models\ContactUs as ContactUsModel;
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
            ContactUsModel::factory()->count(200)->create();
        } catch (\Exception $e) {
            $this->command->error('Failed to seed contact us messages(user feedbacks) to database !');
        }
    }
}
