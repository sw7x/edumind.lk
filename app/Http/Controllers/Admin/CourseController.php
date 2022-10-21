<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Services\TeacherService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //todo - Enrolled, Completed, Rating

        //dd(cleanUsernameString('WW.e rr..rt gg...ppp A1aasas _asas  gg"jj / ss h/h__oo s\de dd2!!@@#@DD 6&&& && jjjj$/$  f gg  hh   ii    k'));
        //'ww.e rr..rt gg...ppp aasas _asas ss hh_oo sde dd2!!@@#@DD 6&&& && jjjj$/$  f gg  hh   ii    k'));
        //"ww.e rr..rt gg...ppp aasas _asas ss hh_oo sde dd2!!@@#@DD 6&&& && jjjj$/$ f gg hh ii k"
        //"ww.e.rr..rt.gg...ppp.aasas._asas.ss.hh_oo.sde.dd2!!@@#@DD.6&&&.&&.jjjj$/$.f.gg.hh.ii.k"
        //"ww.e.rr.rt.gg.ppp.aasas._asas.ss.hh_oo.sde.dd2DD.6.jjjj.f.gg.hh.ii.k"



        //"ww.err..rtgg...pppaasas_asassshh_oosdedd2DD6jjjjfgghhiik"
        //"ww.err.rtgg.pppaasas_asassshh_oosdedd2DD6jjjjfgghhiik"

        //"ww.err..rtgg...pppaasas_asassshh_oosdedd2DD6jjjjfgghhiik"
        //"ww.err.rtgg.pppaasas_asassshh_oosdedd2DD6jjjjfgghhiik"
        $us = new UserService();

        //if($us->checkUsernameExists('ggg'))
        //dd($us->generateUniqueUsername('wxaluma'));




        $data = Course::orderBy('id')->get();
//        $data->each(function($item, $key) {
//            var_dump($item->id);
//
//            var_dump($item->subject->name);
//            var_dump($item->teacher->full_name);
//
//
//
//
//        });
        //dd($data);

        return view('admin-panel.course-list')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $subjectsDataSet =  Subject::all ('id','name')->toArray();
        //dd($subjects);


        $teacherService = new TeacherService();
        $allTeachers = $teacherService->getAllTeachers();
        $teachersDataSet = $allTeachers->map(function ($teacher) {
        return collect($teacher->toArray())
            ->only(['id', 'full_name', 'email'])
            ->all();
        });

        //dd($teachersDataSet);

        return view('admin-panel.course-add')->with([
            'teachers'       => $teachersDataSet,
            //'teachers'       => [],
            'subjects'       => $subjectsDataSet,
        ]);


        //return view('admin-panel.course-add');
        //return view('admin-panel.course-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $course = Course::find($id);
            //var_dump($course->content);
            //dd();
            if($course != null){
                return view('admin-panel.course-view')->with(['course' => $course]);
            }else{
                throw new ModelNotFoundException;
            }
        }catch(CustomException $e){

            return view('admin-panel.course-view')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
            return view('admin-panel.course-view')->with([
                'message'     => 'Course does not exist!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }

        return view('admin-panel.course-view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin-panel.course-edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $course = Course::find($id);
            if ($course) {

                $course->delete();

                return redirect(route('admin.course.index'))
                    ->with([
                        'message'  => 'successfully deleted the course',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success!',
                    ]);

            } else {

                throw new CustomException('Course does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);

            }
        }catch(CustomException $e){

            $exData = $e->getData();
            //dd($e->getData());
            return view('admin-panel.user-view')->with([
                'message'     => $e->getMessage(),
                'cls'         => $exData['cls'] ?? "flash-danger",
                'msgTitle'    => $exData['msgTitle']  ?? 'Error !',
            ]);

        }catch(\Exception $e){
            return view('admin-panel.user-view')->with([
                'message'     => 'Course delete failed!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }
    }

    public function checkEmpty(Request $request)
    {
        try{

            if(!filter_var($request->courseId, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid Course id');
            }

            $course = Course::find($request->courseId);
            if ($course) {

                $status = $course->isEmpty();

                return response()->json([
                    'message'  => $status,
                    'status' => 'success',
                ]);

            } else {
                return response()->json([
                    'message'  => 'Course does not exist!',
                    'status' => 'error',
                ]);
            }

        }catch(CustomException $e){
            return response()->json([
                'message'  => $e->getMessage(),
                'status' => 'error',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'message'  => 'Course status check failed!',
                'status' => 'error',
            ]);
        }
    }



    public function courseContent()
    {
        return view('admin-panel.course-content');
    }


    public function addCourseCopy()
    {
        return view('admin-panel.course-add-copy');
    }


    public function changeStatus(Request $request){

        try{

            if(!filter_var($request->courseId, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id - User status update failed');
            }

            $course = Course::find($request->courseId);
            if ($course) {
                $status = $request->status;


                $teacherUpdateInfo = ['status'=> $status];
                Course::where('id',$request->courseId)->update($teacherUpdateInfo);

                return response()->json([
                    'message'  => 'User status update success',
                    'status' => 'success',
                ]);

            } else {
                return response()->json([
                    'message'  => 'User does not exist!',
                    'status' => 'error',
                ]);
            }

        }catch(CustomException $e){
            return response()->json([
                'message'  => $e->getMessage(),
                'status' => 'error',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'message'  => 'User status update failed!',
                'status' => 'error',
            ]);
        }

    }





}
