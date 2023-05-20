<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

        

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create subjects folder          
        $folderPath = $storagePath = storage_path('app/public/subjects');
        
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
            $this->command->info($folderPath.' - Folder created successfully.');
        } else {
            //$this->command->info($folderPath.' - Folder already exists.');
        }

        Subject::factory()->count(12)->create();
    }
}
