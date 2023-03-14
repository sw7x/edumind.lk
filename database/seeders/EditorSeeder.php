<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Sentinel;

class EditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $editor = [

            'full_name' => 'editor1',
            'email'     => 'editor1@edumind.lk',
            'password'  =>  env('EDITOR_PASS', 'Pa$$w0rd!'),
            'phone'     => '',
            'username'  => 'editor1',
            'gender'    => 'male',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status'    =>  1
        ];

        $user_editor = Sentinel::registerAndActivate($editor);
        $role_editor = Sentinel::findRoleById(2);
        $role_editor->users()->attach($user_editor);
    }
}
