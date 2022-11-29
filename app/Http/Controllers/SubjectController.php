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
        $this->authorize('viewAllInSiteFrontend',Subject::class);    
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

            $this->authorize('viewSingleInSiteFrontend',$subjectData);

            if($subjectData){
                if($subjectData->image){
                    $img = URL('/').'/storage/'.$subjectData->image;
                }else{
                    $img = asset('images/default-images/subject.png');
                }

                $bannerColors = ColorUtil::generateBannerColors($img);

                //dd($subjects);
                return view('subject-single')->with([
                    'subjectData'       => $subjectData,
                    'subjectCourses'    => $subjectCourses,
                    'bgColor'           => $bannerColors['bgColor'],
                    'txtColor'          => $bannerColors['txtColor']
                ]);
            }else{
                throw new CustomException('Subject does not exist');
            }
        }catch(CustomException $e){

            return view('subject-single')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(AuthorizationException $e){
            return view('subject-single')->with([
                'message'     => 'You dont have Permissions to access this page !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            return view('subject-single')->with([
                'message'     => 'Subject does not exist!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }












    }


}
