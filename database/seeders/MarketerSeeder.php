<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Sentinel;

class MarketerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        try {
                        
            $marketer = [
                'full_name' => 'marketer1',
                'email'     => 'marketer1@edumind.lk',
                'password'  =>  env('APP_DEFAULT_USER_PASSWORD', 'Pa$$w0rd!'),
                'phone'     => '-',
                'username'  => 'marketer1',
                'gender'    => 'male',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'status'    =>  1
            ];

            $user_marketer = Sentinel::registerAndActivate($marketer);
            $role_marketer = Sentinel::findRoleById(3);
            $role_marketer->users()->attach($user_marketer);

        } catch (\Exception $e) {
            $this->command->error('Failed to seed default marketer record (username = marketer1) to database !');
        }


        
    }
}
