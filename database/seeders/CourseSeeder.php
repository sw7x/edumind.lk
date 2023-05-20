<?php

namespace Database\Seeders;

use App\Models\Course;
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
        // create courses folder          
        $folderPath = $storagePath = storage_path('app/public/courses');
        
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
            $this->command->info($folderPath.' - Folder created successfully.');
        } else {
            //$this->command->info($folderPath.' - Folder already exists.');
        }
        
        Course::factory()->count(150)->create();
    }
}
