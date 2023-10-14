<?php

namespace Database\Factories;

use App\Models\Subject as SubjectModel;
use App\Common\Utils\UrlUtil;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role as RoleModel;
use Sentinel;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubjectModel::class;

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

        $imgSrc     = 'subjects/' . $this->faker->image('public/storage/subjects', 200, 200, 'subject', false, true);


        return [
            //'name' => substr($this->faker->name,0,24),

            'name'          => $subjectName,
            'description'   => $this->faker->text(),

            //'image'         => $this->faker->imageUrl($width = 200, $height = 200),
            //'image'         => '',
            'image'           => $this->faker->randomElement([$imgSrc,$imgSrc,$imgSrc,null]),

            //'status'        => $this->faker->randomElement(['published','draft']),
            'status'        => $this->faker->randomElement([
                $this->model::PUBLISHED,
                $this->model::DRAFT,
                $this->model::PUBLISHED
            ]),
            'slug'          => $slug,
            'author_id'     => function () {
                $teacherIdArr   = Sentinel::findRoleBySlug(RoleModel::TEACHER)->users()->with('roles')->pluck('id')->toArray();
                $adminIdArr     = Sentinel::findRoleBySlug(RoleModel::ADMIN)->users()->with('roles')->pluck('id')->toArray();
                $editorIdArr    = Sentinel::findRoleBySlug(RoleModel::EDITOR)->users()->with('roles')->pluck('id')->toArray();

                $userArr = array_merge($teacherIdArr,$adminIdArr,$editorIdArr);
                shuffle($userArr);
                return $userArr[0];
            },






        ];
    }
}
