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

        $student = [

            'full_name' => 'student1',
            'email'     => 'student1@edumind.lk',
            'password'  =>  env('STUDENT_PASS', 'Pa$$w0rd!'),
            'phone'     => '',
            'username'  => 'student1',
            'gender'    => 'male',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status'    =>  1
        ];
        
        $user_student = Sentinel::registerAndActivate($student);
        $role_student = Sentinel::findRoleById(5);
        $role_student->users()->attach($user_student);
    }
}
