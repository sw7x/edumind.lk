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

        // create users folder          
        $folderPath = $storagePath = storage_path('app/public/users');
        
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
            $this->command->info($folderPath.' - Folder created successfully.');
        } else {
            //$this->command->info($folderPath.' - Folder already exists.');
        }  



        $faker = \Faker\Factory::create();

        $teacher = [

            'full_name'          => 'teacher1',
            'email'              => 'teacher1@edumind.lk',
            'password'           =>  env('TEACHER_PASS', 'Pa$$w0rd!'),
            'phone'              => '-',
            'username'           => 'teacher1',
            'gender'             => 'male',
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s'),
            'status'             =>  1,
            'profile_pic'        => 'users/' .  $faker->image('public/storage/users', 630, 820, 'users', false, true),
            'dob_year'           => 1970,
            'edu_qualifications' => 'Phd in maths'
        ];

        $user_teacher = Sentinel::registerAndActivate($teacher);
        $role_teacher = Sentinel::findRoleById(4);
        $role_teacher->users()->attach($user_teacher);




    }
}
