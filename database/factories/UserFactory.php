<?php

namespace Database\Factories;

use App\Models\User as UserModel;
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
    protected $model = UserModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user =  [
            'full_name' => $this->faker->name(),
            'email'     => $this->faker->unique()->safeEmail(),

            'gender'    => $this->faker->randomElement([
                                $this->model::GENDER_MALE,
                                $this->model::GENDER_FEMALE,
                                $this->model::GENDER_OTHER,
                                $this->model::GENDER_MALE,
                                $this->model::GENDER_FEMALE
                           ]),
            //'profile_pic'   => $profilePic,

            'dob_year'  => 1987,
            'status'    => $this->faker->randomElement([1,1,0]),
            'password'  => bcrypt('Pa$$w0rd!'),
            'phone'     => $this->faker->phoneNumber(),
            'username'  => substr($this->faker->userName(), 0, 24),
            'created_at'=> now(),
            'updated_at'=> now(),
        ];

        return $user;

        //$user = User->registerAndActivate($user);
        //$user_admin->makeRoot();
        //$role = UserModel::findRoleById($roleId);
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
