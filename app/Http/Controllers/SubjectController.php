<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Subject;
use App\Utils\ColorUtil;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;



class SubjectController extends Controller
{
    public function ViewAll(){
        //$this->authorize('viewAllInSiteFrontend',Subject::class);    
        $subjects = Subject::orderBy('created_at', 'desc')->get();
        //dd($subjects);
        return view('subject-list')->with(['subjects' => $subjects]);
    }


    public function ViewTopic($slug=null){

        try{
            if(!$slug){
                throw new CustomException('Subject id not provided');
            }
            $subjectData    = Subject::where('slug', $slug)->first();
            $subjectCourses = Subject::where('slug', $slug)->first()->courses;
            //dd($subjectData);
            //dd();

            //$this->authorize('viewSingleInSiteFrontend',$subjectData);

            if($subjectData){                

                $bannerColors = ColorUtil::generateBannerColors($subjectData->image);

                //dd($subjects);
                return view('subject-single')->with([
                    'subjectData'       => $subjectData,
                    'subjectCourses'    => $subjectCourses,
                    'bgColor'           => $bannerColors['bgColor'],
                    'txtColor'          => $bannerColors['txtColor']
                ]);
            }else{
                throw new CustomException('Subject does not exist or disabled');
            }
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('subject-single');

        }catch(AuthorizationException $e){
            session()->flash('message', 'You dont have Permissions to access this subject');            
            abort(403);

        }catch(\Exception $e){
            session()->flash('message', 'Failed to load the subject');
            //session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('subject-single');
        }

    }


}
