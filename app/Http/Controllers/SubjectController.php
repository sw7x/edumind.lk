<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Services\SubjectService;
use App\View\DataFormatters\SubjectDataFormatter;

//use Illuminate\Auth\Access\AuthorizationException;
//use App\Common\Utils\ColorUtil;
//use Illuminate\Http\Request;


class SubjectController extends Controller
{
    private SubjectService $SubjectService;

    function __construct(SubjectService $SubjectService){
        $this->SubjectService = $SubjectService;
    }



    public function index(){
        $subjectDtoArr  = $this->SubjectService->loadAllSubjects();
        $subjectArr     = SubjectDataFormatter::prepareSubjectDataList($subjectDtoArr);
        return view ('subject-list')->with(['subjects' => $subjectArr]);
    }


    public function show($slug=null){
        if(!$slug)
            throw new CustomException('Subject id not provided');

        $subjectData    = $this->SubjectService->loadSubjectDataByUrl($slug);
        //$this->authorize('viewSingleInSiteFrontend',$subjectData['dbRec']);

        $subjectDataArr = SubjectDataFormatter::prepareViewSubjectData($subjectData);

        return view('subject-single')->with([
            'subjectData'       => $subjectDataArr['subject'],
            'subjectCourses'    => $subjectDataArr['subjectCourses'],
            'bgColor'           => $subjectDataArr['bgColor'],
            'txtColor'          => $subjectDataArr['txtColor']
        ]);
    }


}
