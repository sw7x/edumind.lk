<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'uuid'=> str_replace('-', '', Uuid::uuid4()->toString()),
                'slug' => 'admin',
                'name' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'uuid'=> str_replace('-', '', Uuid::uuid4()->toString()),
                'slug' => 'editor',
                'name' => 'editor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'uuid'=> str_replace('-', '', Uuid::uuid4()->toString()),
                'slug' => 'marketer',
                'name' => 'marketer',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'uuid'=> str_replace('-', '', Uuid::uuid4()->toString()),
                'slug' => 'teacher',
                'name' => 'teacher',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'uuid'=> str_replace('-', '', Uuid::uuid4()->toString()),
                'slug' => 'student',
                'name' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]

        ]);
    }
}
