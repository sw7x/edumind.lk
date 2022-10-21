<?php

namespace Database\Factories;

use App\Models\User;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


use Faker\Generator as Faker;



class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        //var_dump($this->state(['susa']));


//        $rr = $this->state(function (array $attributes) {
//            return $attributes['zzz'];
//
////            return [
////                'account_status' => 'suspended',
////            ];
//        });

        //var_dump($rr);

//        return [
//            'full_name' => $this->faker->name(),
//            'email' => $this->faker->unique()->safeEmail(),
//            'email_verified_at' => now(),
//
//            //'remember_token' => Str::random(10),  //
//
//            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
//            'dob_year' => 1987,
//            'status' => $this->faker->randomElement([1,0]),
//            'password' => bcrypt('Pa$$w0rd!'),
//            'phone' => $this->faker->phoneNumber,
//
//            'edu_qualifications'=> $this->faker->text(),
//            'profile_text'=> $this->faker->text(),
//            'username' => $this->faker->userName,
//            'created_at'=> now(),
//            'updated_at'=> now(),
//        ];


        $roleId = $this->faker->randomElement([2,3,4,5]);
        //var_dump ($roleId);
        $user =  [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            //'email_verified_at' => now(),

            //'remember_token' => Str::random(10),  //

            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'dob_year' => 1987,
            'status' => $this->faker->randomElement([1,0]),
            'password' => bcrypt('Pa$$w0rd!'),
            'phone' => $this->faker->phoneNumber(),



            'username' => substr($this->faker->userName(), 0, 24),
            'created_at'=> now(),
            'updated_at'=> now(),
        ];



        //array_merge($user,array('qq'=> '666'));
        //return array('user'=>$user,'roleId' => $roleId);

        var_dump ($user);

       return $user;


        //$user = User->registerAndActivate($user);
        //$user_admin->makeRoot();
        //$role = User::findRoleById($roleId);
        //$role->users()->attach($user);






    }












    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
