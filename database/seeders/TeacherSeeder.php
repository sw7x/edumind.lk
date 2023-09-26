<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
                        
            // create users folder          
            $folderPath         = storage_path('app/public/users');
            $teachersfolderPath = storage_path('app/public/users/teachers');
            
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
                $this->command->alert($folderPath.' - Folder created successfully.');
            }
            
            if (!File::exists($teachersfolderPath)) {
                File::makeDirectory($teachersfolderPath, 0755, true);
                $this->command->alert($teachersfolderPath.' - Folder created successfully.');
            }


            $faker = \Faker\Factory::create();

            $teacher = [
                'full_name'          => 'teacher1',
                'email'              => 'teacher1@edumind.lk',
                'password'           =>  env('APP_DEFAULT_USER_PASSWORD', 'Pa$$w0rd!'),
                'phone'              => '-',
                'username'           => 'teacher1',
                'gender'             => 'male',
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
                'status'             =>  1,
                'profile_pic'        => 'users/teachers/' .  $faker->image('public/storage/users/teachers', 630, 820, 'teacher-user', false, true, 'AAA'),
                'dob_year'           => 1970,
                'edu_qualifications' => 'Phd in maths'
            ];

            $user_teacher = Sentinel::registerAndActivate($teacher);
            $role_teacher = Sentinel::findRoleById(4);
            $role_teacher->users()->attach($user_teacher);

        } catch (\Exception $e) {
            $this->command->error('Failed to seed default teacher record (username = teacher1) to database !');
        }


    }
}
