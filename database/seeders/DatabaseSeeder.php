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
        $this->call(Contact_usSeeder::class);        
        $this->call(SubjectSeeder::class);
        $this->call(CourseSeeder::class);
        

        $this->call(InvoiceSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(CourseSelectionSeeder::class);
        
        $this->call(EnrollmentSeeder::class);
        
        /*
            fill invalid cart items for student1
            run these seeders at last
        */
        $this->call(InvCartItems_FreeCourses::class);
        $this->call(InvCartItems_InvalidCc::class);
        $this->call(InvCartItems_ValidMultipleCc::class);
        
        
    }
}
