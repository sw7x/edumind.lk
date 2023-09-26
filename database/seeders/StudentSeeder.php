<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Sentinel;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
                        
            $student = [
                'full_name'     => 'student1',
                'email'         => 'student1@edumind.lk',
                'password'      =>  env('APP_DEFAULT_USER_PASSWORD', 'Pa$$w0rd!'),
                'phone'         => '-',
                'username'      => 'student1',
                'gender'        => 'male',
                'dob_year'      => 1986,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                'status'        => true,
                'profile_text'  => 'student1-profile-text'
            ];
            
            $user_student = Sentinel::registerAndActivate($student);
            $role_student = Sentinel::findRoleById(5);
            $role_student->users()->attach($user_student);

        } catch (\Exception $e) {
            $this->command->error('Failed to seed default student record (username = student1) to database !');
        }

        
    }
}
