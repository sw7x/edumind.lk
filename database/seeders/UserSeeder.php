<?php

namespace Database\Seeders;

use App\Models\User;
use Sentinel;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::factory()->count(100)->make()->each(function ($userItem){
            $faker = \Faker\Factory::create();
            $roleId = $faker->randomElement([2,3,4,5]);

            
            $user = $userItem->toArray();
            $user['password'] = 'Pa$$w0rd!';

                        
            //TEACHERS
            if($roleId == 4){

                $user = array_merge($user,array('edu_qualifications'=> $faker->text())); 

                $profilePicSrc = ('users/' . $faker->image('public/storage/users', 630, 820, 'users', false, true));
                $profilePic    = $faker->randomElement([$profilePicSrc, $profilePicSrc, null]);
                $user = array_merge($user,array('profile_pic'=> $profilePic));            
            }else{

                $user = array_merge($user,array('profile_pic'=> null));
            }


            //STUDENTS
            if($roleId == 5){
                $user = array_merge($user,array('profile_text'=> $faker->text()));
            }

            
            $user = Sentinel::registerAndActivate($user);
            $role = Sentinel::findRoleById($roleId);
            $role->users()->attach($user);

        });

    }
}
