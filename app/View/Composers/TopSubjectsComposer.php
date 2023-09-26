<?php


namespace App\View\Composers;


use App\Models\Subject as SubjectModel;
//use App\Models\Enrollment as EnrollmentModel;

use Illuminate\View\View;

class TopSubjectsComposer
{
    public function compose(View $view)
    {

        $subjects = SubjectModel::withCount('courses')->orderBy('courses_count', 'desc')->skip(0)->take(8)->get();
        $arr = array();
        $arr = $subjects->map(function($subject) use ($arr){
            return array(
                'name'  => $subject->name,
                'url'   => $subject->slug,
                'image' => $subject->image
            );
        });

        $view->with('subject_info',$subjects);
        //dd($subjects);
    }
}









