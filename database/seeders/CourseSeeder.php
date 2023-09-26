<?php

namespace Database\Seeders;

use App\Models\Course as CourseModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        try {                        
            
            // create courses folder          
            $folderPath = storage_path('app/public/courses');

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
                $this->command->alert($folderPath.' - Folder created successfully.');
            } else {
            //$this->command->info($folderPath.' - Folder already exists.');
            }

            CourseModel::factory()->count(150)->create();

        } catch (\Exception $e) {
            $this->command->error('Failed to seed courses to database !');
        }


 
    }
}
