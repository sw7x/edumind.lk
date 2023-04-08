<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Utils\UrlUtil;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Role;
use Sentinel;

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
            'name'          => $subjectName,
            'description'   => $this->faker->text(),
            
            //'image'         => $this->faker->imageUrl($width = 200, $height = 200),
            //'image'         => '',
            'image'         => 'subjects/' . $this->faker->image('public/storage/subjects', 200, 200, 'subject', false, true),
            
            //'status'        => $this->faker->randomElement(['published','draft']),
            'status'        => $this->faker->randomElement([
                $this->model::PUBLISHED, 
                $this->model::DRAFT, 
                $this->model::PUBLISHED
            ]),
            'slug'          => $slug,
            'author_id'     => function () {
                $teacherIdArr   = Sentinel::findRoleBySlug(Role::TEACHER)->users()->with('roles')->pluck('id')->toArray();
                $adminIdArr     = Sentinel::findRoleBySlug(Role::ADMIN)->users()->with('roles')->pluck('id')->toArray();
                $editorIdArr    = Sentinel::findRoleBySlug(Role::EDITOR)->users()->with('roles')->pluck('id')->toArray();
                
                $userArr = array_merge($teacherIdArr,$adminIdArr,$editorIdArr);        
                shuffle($userArr);
                return $userArr[0];
            },
            





        ];
    }
}
