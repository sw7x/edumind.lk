<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        
        
        $this->call(AdminSeeder::class);
        $this->call(EditorSeeder::class);
        $this->call(MarketerSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(StudentSeeder::class);

        $this->call(UserSeeder::class);


        $this->call(CourseSeeder::class);
        $this->call(Contact_usSeeder::class);

    }
}
