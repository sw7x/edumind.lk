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
        
        try {                        
            

            //$this->command->alert('Failed to seed subjects to database !');
            //$this->command->warn('Failed to seed subjects to database !');
            //$this->command->info('Failed to seed subjects to database !');
            //$this->command->bulletList(['Failed to seed subjects to database !','kkk','gg']);
            //dd('kk');

            // create subjects folder          
            $folderPath = storage_path('app\public\subjects');
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
                $this->command->alert($folderPath.' - Folder created successfully.');
            } else {
                //$this->command->info($folderPath.' - Folder already exists.');
            }
            
            Subject::factory()->count(12)->create();        
        } catch (\Exception $e) {
            $this->command->error('Failed to seed subjects to database !');
        }


    }
}
