<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Sentinel;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $teacher = [

            'full_name' => 'teacher1',
            'email'     => 'teacher1@edumind.lk',
            'password'  =>  env('TEACHER_PASS', 'Pa$$w0rd!'),
            'phone'     => '',
            'username'  => 'teacher1',
            'gender'    => 'male',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status'    =>  1
        ];

        $user_teacher = Sentinel::registerAndActivate($teacher);
        $role_teacher = Sentinel::findRoleById(4);
        $role_teacher->users()->attach($user_teacher);
    }
}