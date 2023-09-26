<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use Illuminate\Auth\Access\AuthorizationException;

use App\Services\SubjectService;
use App\View\DataTransformers\SubjectDataTransformer;


use App\Models\Subject;
use App\Utils\ColorUtil;
use Illuminate\Http\Request;
class SubjectController extends Controller
{
    private SubjectService $SubjectService;

    function __construct(SubjectService $SubjectService){
        $this->SubjectService = $SubjectService;
    }



    public function ViewAll(){

        try{
            $subjectDtoArr  = $this->SubjectService->loadAllSubjects();
            $subjectArr     = SubjectDataTransformer::prepareSubjectDataList($subjectDtoArr);
            return view ('subject-list')->with(['subjects' => $subjectArr]);

        }catch(CustomException $e){
            return view ('subject-list')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }catch(\Exception $e){
            return view ('subject-list')->with([
                'message'     => $e->getMessage(),
                //'message'     => 'Failed to view all subjects',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }

    }


    public function ViewSubject($slug=null){

        try{
            //$this->authorize('viewSingleInSiteFrontend',$subjectData);
            if(!$slug)
                throw new CustomException('Subject id not provided');

            $subjectData    = $this->SubjectService->loadSubjectDataByUrl($slug);
            $subjectDataArr = SubjectDataTransformer::prepareViewSubjectData($subjectData);

            return view('subject-single')->with([
                'subjectData'       => $subjectDataArr['subject'],
                'subjectCourses'    => $subjectDataArr['subjectCourses'],
                'bgColor'           => $subjectDataArr['bgColor'],
                'txtColor'          => $subjectDataArr['txtColor']
            ]);

        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('subject-single');

        }catch(AuthorizationException $e){
            session()->flash('message', 'You dont have Permissions to access this subject');
            abort(403);

        }catch(\Exception $e){
            //session()->flash('message', 'Failed to load the subject');
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('subject-single');
        }

    }


}
