<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;

use App\Models\Subject as SubjectModel;

use Illuminate\Auth\Access\AuthorizationException;
use Sentinel;
use App\Services\Admin\SubjectService as AdminSubjectService;

use App\View\DataFormatters\Admin\SubjectDataFormatter as AdminSubjectDataFormatter;

/*
use App\Utils\FileUploadUtil;
use App\Utils\UrlUtil;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Cviebrock\EloquentSluggable\Services\SlugService;
*/

class SubjectController extends Controller
{

    private AdminSubjectService $adminSubjectService;

    function __construct(AdminSubjectService $adminSubjectService){
        $this->adminSubjectService = $adminSubjectService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd('f');
        try{
            $this->authorize('viewAny',SubjectModel::class);
            $subjectsData   = $this->adminSubjectService->loadAllDbRecs();

            $filteredDataArr = AdminSubjectDataFormatter::prepareSubjectDataList($subjectsData);

            return view ('admin-panel.subject-list')->withData($filteredDataArr);

        }catch(AuthorizationException $e){
            return redirect(route('admin.dashboard'))->with([
                'message'     => 'You dont have Permissions view all subjects !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            dump($e->getMessage());
            session()->now('message','Failed to view all subjects');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.subject-list');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $this->authorize('create',SubjectModel::class);
            return view('admin-panel.subject-add');

        }catch(AuthorizationException $e){
            return redirect(route('admin.subjects.index'))->with([
                'message'   =>'You dont have Permissions create new subject',
                'cls'       =>'flash-danger',
                'msgTitle'  =>'Permission Denied!'
            ]);

        }catch(\Exception $e){
            session()->now('message',  'Failed to show subject add form');
            session()->now('cls',      'flash-danger');
            session()->now('msgTitle', 'Error!');
            return view('admin-panel.subject-add');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $this->authorize('create',SubjectModel::class);
            if(!$request->get('name'))
                throw new CustomException('Subject name cannot be empty');

            $isSaved = $this->adminSubjectService->saveDbRec($request);
            if (!$isSaved)
                throw new CustomException("Subject create failed");

            return redirect(route('admin.subjects.create'))->with([
                'message' => 'Subject inserted successfully',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){
            return redirect(route('admin.subjects.create'))->with([
                'message'  => $e->getMessage(),
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error !',
            ]);
        }catch(AuthorizationException $e){
            return redirect(route('admin.subjects.create'))->with([
                'message'     => 'You dont have Permissions create new subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            return redirect(route('admin.subjects.create'))->with([
                //'message'  => $e->getMessage(),
                'message'  => 'Subject creation failed!',
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error !',
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $subjectData = $this->adminSubjectService->findDbRec($id);

            if(is_null($subjectData['dbRec']))
                throw new CustomException('Subject does not exist!');

            $this->authorize('view', $subjectData['dbRec']);

            $subjectDataArr = AdminSubjectDataFormatter::prepareViewSubjectData($subjectData['dto']);
            return view('admin-panel.subject-view')->with(['subject'   => $subjectDataArr]);

        }catch(CustomException $e){
            session()->now('message',$e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.subject-view');

        }catch(AuthorizationException $e){
            return redirect(route('admin.subjects.index'))->with([
                'message'     => 'You dont have Permissions to view the subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            //session()->now('message',$e->getMessage());
            session()->now('message','Cannot display subject info!');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.subject-view');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $subjectData = $this->adminSubjectService->findDbRec($id);
            if(is_null($subjectData['dbRec']))
                throw new CustomException('Subject does not exist!');

            $this->authorize('update', $subjectData['dbRec']);

            $subjectDataArr = AdminSubjectDataFormatter::prepareViewSubjectData($subjectData['dto']);
            return view('admin-panel.subject-edit')->with(['subject'   => $subjectDataArr]);

        }catch(CustomException $e){
            session()->now('message', $e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.subject-list');

        }catch(AuthorizationException $e){
            return redirect(route('admin.subjects-list'))->with([
                'message'     => 'You dont have Permissions to update the subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            session()->now('message','Resource not exist');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.subject-list');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            if(!$request->input('name'))
                throw new CustomException('Subject name cannot be empty');

            $subjectData = $this->adminSubjectService->findDbRec($id);
            if(is_null($subjectData['dbRec']))
                throw new CustomException('Subject does not exist!');

            $this->authorize('update', $subjectData['dbRec']);

            $isUpdated = $this->adminSubjectService->updateDbRec($request, $subjectData['dbRec']);
            if (!$isUpdated)
                throw new CustomException("Subject update failed");

            return redirect()->route('admin.subjects.index')->with([
                'message' => 'Subject updated successfully',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){
            return redirect()->route('admin.subjects.edit', $id)->with([
                'message'  => $e->getMessage(),
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error !',
            ]);
        }catch(AuthorizationException $e){
            return redirect()->route('admin.subjects.index')->with([
                //'message'  => $e->getMessage(),
                'message'     => 'You dont have Permissions to update the subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            return redirect()->route('admin.subjects.edit', $id)->with([
                'message'  => $e->getMessage(),
                //'message'   => 'Subject updated failed!',
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error !',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, int $id)
    {
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $subjectData = $this->adminSubjectService->findDbRec($id);
            if(is_null($subjectData['dbRec']))
                throw new CustomException('Subject does not exist!');

            $this->authorize('delete', $subjectData['dbRec']);

            $isDelete = $this->adminSubjectService->deleteDbRec($subjectData['dbRec']);
            if (!$isDelete)
                throw new CustomException("Subject delete failed");

            return redirect()->route('admin.subjects.index')->with([
                'message' => 'Subject deleted successfully',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){
            $exData = $e->getData();
            return redirect()->route('admin.subjects.index')->with([
                'message'     => $e->getMessage(),
                'cls'         => $exData['cls'] ?? "flash-danger",
                'msgTitle'    => $exData['msgTitle']  ?? 'Error !',
            ]);

        }catch(AuthorizationException $e){
            return redirect()->route('admin.subjects.index')->with([
                'message'     => 'You dont have Permissions to delete the subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            return redirect()->route('admin.subjects.index')->with([
                'message'     => $e->getMessage(),
                //'message'   => 'subject delete failed',
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error!',
            ]);
        }

    }

}
