<?php

namespace Database\Factories;

use App\Models\Course as CourseModel;
use App\Models\Subject as SubjectModel;
use App\Common\Utils\UrlUtil;
use Illuminate\Database\Eloquent\Factories\Factory;
use Sentinel;
use App\Models\Role as RoleModel;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomNumber   = $this->faker->numberBetween(1, 4);
        $courseName     = $this->faker->sentence($nbWords = $randomNumber, $variableNbWords = true);

        $urlString  = UrlUtil::wordsToUrl($courseName,15);
        $slug       = UrlUtil::generateSubjectUrl($urlString);

        $topics  = json_decode('["Introduction","NPM","VALID (RFC 8259)","JSONP","JavaScript"]');
        $content = json_decode('{"Introduction":[{"inputText":"React, Strapi bbb","inputUrl":"https:\/\/www.youtube.com\/embed\/xBDGgovA1LI","linkParam":"17m","isFree":true,"type":"video"}],"NPM":[{"inputText":"node package manager a.js","inputUrl":"https:\/\/www.youtube.com\/embed\/5Mh3o886qpg","linkParam":"17m","isFree":true,"type":"video"}],"VALID (RFC 8259)":[{"inputText":" Complete E-Commerce App with React, Strapi, Stripe | Shopping App Tutorial for Beginners ","inputUrl":"https:\/\/www.youtube.com\/embed\/OrgnQCXwmQQ","linkParam":"17m","isFree":false,"type":"video"},{"inputText":"Stripe | Shopping App Tutorial for Beginners ","inputUrl":"https:\/\/jsonformatter.curiousconcept.com\/","linkParam":"5MB","isFree":false,"type":"other"},{"inputText":"App Tutorial for Beginners","inputUrl":"http:\/\/json.org","linkParam":"17MB","isFree":false,"type":"download"}],"JSONP":[],"JavaScript":[{"inputText":"React for Beginners ","inputUrl":"http:\/\/json.org","linkParam":"17MB","isFree":true,"type":"download"}]}');

        $hours     = $this->faker->randomElement([$this->faker->numberBetween(0, 30),0,1,2]);
        $minutes   = $this->faker->randomElement([$this->faker->numberBetween(1, 59),0,1,15,30,45]);

        $duration  = (!$hours)?'0 Hours : ':(($hours ==1)?'1 Hour : ':$hours.' Hours : ');
        $duration .= (!$minutes)?'0 Minutes':(($minutes ==1)?'1 Minute':$minutes.' Minutes');

        $haveImage = $this->faker->randomElement([true, true, false]);

        return [
            'name'          =>  $courseName,
            'description'   =>  $this->faker->text(),
            'status'        =>  $this->faker->randomElement([
                                    $this->model::PUBLISHED,
                                    $this->model::DRAFT,
                                    $this->model::PUBLISHED
                                ]),

            'subject_id'    =>  SubjectModel::inRandomOrder()->first()->id ?? null,
            //'subject_id'  =>  $this->faker->randomElement([1,2,3,4]),

            //fill only teacher account user id's
            'teacher_id'    => function () {
                $teacherIdArr = Sentinel::findRoleBySlug(RoleModel::TEACHER)->users()->with('roles')->pluck('id')->toArray();
                shuffle($teacherIdArr);
                return $teacherIdArr[0];
            },
            'slug'          => $slug,

            'image'         => function () use ($haveImage){
                $imgSrc =   ($haveImage) ?
                                $this->faker->image(public_path('storage/courses'), 800, 600, 'Course', false, true) :
                                null;

                // fix for sometimes faker not generate image
                return $imgSrc ? 'courses/' . $imgSrc : null;
            },

            'topics'        =>  $topics,
            'content'       =>  $content,

            'heading_text'  =>  $this->faker->paragraph(),
            'price'         =>  $this->faker->randomElement([
                                    0,
                                    $this->faker->numberBetween($min = 1000, $max = 5000),
                                    $this->faker->numberBetween($min = 5000, $max = 100000),
                                ]),

            'video_count'	=> $this->faker->numberBetween(1, 120),
            'duration'      => $duration,

            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
