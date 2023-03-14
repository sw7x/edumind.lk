<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Sentinel;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = [

            'full_name' => 'admin',
            'email'     => 'admin@edumind.lk',
            'password'  =>  env('ADMIN_PASS', 'abc123'),
            'phone'     => '',
            'username'  => 'admin',
            'gender'    => 'male',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status'    =>  1
        ];
        
        $user_admin = Sentinel::registerAndActivate($admin);
        //$user_admin->makeRoot();
        $role_admin = Sentinel::findRoleById(1);
        $role_admin->users()->attach($user_admin);



        /*
        $id = DB::table('users')->insertGetId([
            'full_name' => 'admin',
            'email'     => 'admin@edumind.com',
            'password'  =>  bcrypt(env('ADMIN_PASS', 'abc123')),
            'phone'     => '',
            'username'  => 'admin',
            'gender'    => 'male',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('role_users')->insert([
            'user_id'    => $id,
            'role_id'    => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);


        DB::table('activations')->insert([
            'user_id'       => $id,
            'code'          => '',
            'completed'     => 1,
            'completed_at'  => date('Y-m-d H:i:s'),
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
        */








    }
}
