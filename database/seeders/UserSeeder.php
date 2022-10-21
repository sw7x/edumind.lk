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

            $user = $userItem->toArray();
            $user['password'] = 'Pa$$w0rd!';

            $faker = \Faker\Factory::create();
            $roleId = $faker->randomElement([2,3,4,5]);

            if($roleId == 4){
                $user = array_merge($user,array('edu_qualifications'=> $faker->text()));
            }
            if($roleId == 5){
                $user = array_merge($user,array('profile_text'=> $faker->text()));
            }

            $faker = \Faker\Factory::create();
            $role_Id = $faker->randomElement([2,3,4,5]);


            $user = Sentinel::registerAndActivate($user);
            $role = Sentinel::findRoleById($roleId);
            $role->users()->attach($user);

            /*
            factory(Question::class, 1)
                ->create()
                ->each(function ($question)
                {
                    factory(Option::class, rand(2,3))->create();
                });
            */
        });

    }
}
