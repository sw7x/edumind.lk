<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Utils\UrlUtil;
use Illuminate\Database\Eloquent\Factories\Factory;
use Sentinel;


class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

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
        
       
        $hours      = $this->faker->randomElement([$this->faker->numberBetween(0, 30),0,1,2]);
        $minutes    = $this->faker->randomElement([$this->faker->numberBetween(1, 59),0,1,15,30,45]);

        $duration  = (!$hours)?'0 Hours : ':(($hours ==1)?'1 Hour : ':$hours.' Hours : ');
        $duration .= (!$minutes)?'0 Minutes':(($minutes ==1)?'1 Minute':$minutes.' Minutes');

        return [
            'name'          => $courseName,
            'description'   => $this->faker->text(),
            
            'status'        => $this->faker->randomElement([
                $this->model::PUBLISHED, 
                $this->model::DRAFT, 
                $this->model::PUBLISHED
            ]),

            'subject_id'    => Subject::inRandomOrder()->first()->id,

            //fill only teacher account user id's
            'teacher_id'    => function () {
                $teacherIdArr = Sentinel::findRoleBySlug('teacher')->users()->with('roles')->pluck('id')->toArray();
                shuffle($teacherIdArr);
                return $teacherIdArr[0];
            },
            'slug' => $slug,
            
            //'image'         => $this->faker->imageUrl($width = 200, $height = 200),
            //'image'         =>  $this->faker->image('public/storage/courses',640,480, null, false),
            'image'         => 'courses/' . $this->faker->image('public/storage/courses', 800, 600, 'Course', false, true),

            //'image'         => '',


            'topics'    =>  $topics,
            'content'   =>  $content,


            'heading_text'  => $this->faker->paragraph(),
            'price'         => $this->faker->randomElement([
                0,
                $this->faker->numberBetween($min = 1000, $max = 5000),
                $this->faker->numberBetween($min = 5000, $max = 100000),
            ]),
            'video_count'	=> $this->faker->numberBetween(1, 120),
            'duration'      => $duration,

            //'enrollment_id' =>  $this->faker->numberBetween(1, 30),
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
