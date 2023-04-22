<?php


namespace Database\Factories;

use App\Models\Contact_us;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactUsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact_us::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $randUser = User::withoutGlobalScope('active')->get()->random();

        //var_dump($randUser->id);
        //var_dump($randUser->full_name);
        //var_dump($randUser->email);
        //var_dump($randUser->phone);

        //dd($randUser->id);

        $user1 =    [
            'full_name' => $randUser->full_name,
            'email'     => $randUser->email,
            'phone'     => $randUser->phone,
            'user_id'   => $randUser->id,
        ];

        $user2 =    [
            'full_name' => $this->faker->name(),
            'email'     => $this->faker->email(),
            'phone'     => $this->faker->phoneNumber(),
            'user_id'   => null,
        ];

        $user3 =    [
            'full_name' => $randUser->full_name,
            'email'     => $randUser->email,
            'phone'     => $randUser->phone,
            'user_id'   => $randUser->id,
        ];

        $user = $this->faker->randomElement([$user1, $user2, $user3]);



        $randomNumber = $this->faker->numberBetween(1, 10);

        return [
            'full_name' => $user['full_name'],//50    ////////////
            'email'     => $user['email'], //////////////
            'phone'     => $user['phone'], //20////////
            'subject'   => $this->faker->sentence($nbWords = $randomNumber, $variableNbWords = true),
            'message'   => $this->faker->text(),

            'user_id'   => $user['user_id'],////////////////
        ];

        /*
        return [
            'full_name' => $this->faker->name(),//50    ////////////
            'email'     => $this->faker->email()(), //////////////
            'phone'     => $this->faker->phoneNumber(), //20////////
            'subject'   => $this->faker->sentence($nbWords = $randomNumber, $variableNbWords = true),
            'message'   => $this->faker->text(),
            'user_id'   => '',////////////////
        ];
        */











        //$table->integer('user_id')->nullable()->unsigned();
        //$table->foreign('user_id')->references('id')->on('users');




    }
}
