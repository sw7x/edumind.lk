<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Utils\UrlUtil;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subjectName = substr($this->faker->unique()->word,0,24);

        $urlString  = UrlUtil::wordsToUrl($subjectName,15);
        $slug       = UrlUtil::generateSubjectUrl($urlString);

        return [
            //'name' => substr($this->faker->name,0,24),
            'name' => $subjectName,
            'description' => $this->faker->text(),
            'image' => '',
            'status' => $this->faker->randomElement(['published','draft']),
            'slug' => $slug






        ];
    }
}
