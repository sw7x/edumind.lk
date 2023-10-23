<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;

use App\Models\Subject as SubjectModel;

use Illuminate\Auth\Access\AuthorizationException;
use Sentinel;
use App\Services\Admin\SubjectService as AdminSubjectService;
use App\Common\Utils\AlertDataUtil;
use App\View\DataFormatters\Admin\SubjectDataFormatter as AdminSubjectDataFormatter;


class SubjectController extends Controller
{

    private AdminSubjectService $adminSubjectService;

    function __construct(AdminSubjectService $adminSubjectService){
        $this->adminSubjectService = $adminSubjectService;
    }

    public function index(){
        //You dont have Permissions view all subjects !
        $this->authorize('viewAny',SubjectModel::class);
        $subjectsData = $this->adminSubjectService->loadAllDbRecs();

        $filteredDataArr = AdminSubjectDataFormatter::prepareSubjectDataList($subjectsData);
        return view ('admin-panel.subject-list')->withData($filteredDataArr);
    }

    public function create(){
        //You dont have Permissions create new subject !
        $this->authorize('create',SubjectModel::class);
        return view('admin-panel.subject-add');
    }

    public function store(Request $request){
        try{
            //You dont have Permissions create new subject
            $this->authorize('create',SubjectModel::class);
            
            if(!$request->get('name'))
                throw new CustomException('Subject name cannot be empty');

            $isSaved = $this->adminSubjectService->saveDbRec($request);
            if (!$isSaved)
                abort(500, "Subject create failed due to server error !");

            return redirect(route('admin.subjects.create'))
                ->with(AlertDataUtil::success('Subject inserted successfully'));

        }catch(CustomException $e){
            return redirect(route('admin.subjects.create'))->with(AlertDataUtil::error($e->getMessage()));
        }
    }

    public function show(int $id){
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $subjectData = $this->adminSubjectService->findDbRec($id);

        if(is_null($subjectData['dbRec']))
            abort(404,'Subject does not exist!');

        // You dont have Permissions to view the subject !
        $this->authorize('view', $subjectData['dbRec']);

        $subjectDataArr = AdminSubjectDataFormatter::prepareViewSubjectData($subjectData['dto']);
        return view('admin-panel.subject-view')->with(['subject' => $subjectDataArr]);
    }

    public function edit(int $id){
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $subjectData = $this->adminSubjectService->findDbRec($id);
        if(is_null($subjectData['dbRec']))
            abort(404,'Subject does not exist!');

        //You dont have Permissions to update the subject !
        //$this->authorize('update', $subjectData['dbRec']);

        $subjectDataArr = AdminSubjectDataFormatter::prepareViewSubjectData($subjectData['dto']);
        return view('admin-panel.subject-edit')->with(['subject' => $subjectDataArr]);
    }

    public function update(Request $request, int $id){
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            if(!$request->input('name'))
                throw new CustomException('Subject name cannot be empty');

            $subjectData = $this->adminSubjectService->findDbRec($id);
            if(is_null($subjectData['dbRec']))
                abort(404,'Subject does not exist!');

            //You dont have Permissions to update the subject !
            $this->authorize('update', $subjectData['dbRec']);

            $isUpdated = $this->adminSubjectService->updateDbRec($request, $subjectData['dbRec']);
            if (!$isUpdated)
                abort(500, "Subject update failed due to server error !");

            return redirect()->route('admin.subjects.index')
                ->with(AlertDataUtil::success('Subject inserted successfully'));

        }catch(CustomException $e){
            return redirect()->route('admin.subjects.edit', $id)->with(AlertDataUtil::error($e->getMessage()));

        }

    }

    public function destroy(Request $request, int $id){
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $subjectData = $this->adminSubjectService->findDbRec($id);
        if(is_null($subjectData['dbRec']))
            throw new CustomException('Subject does not exist!');

        //You dont have Permissions to delete the subject !
        $this->authorize('delete', $subjectData['dbRec']);

        $isDelete = $this->adminSubjectService->deleteDbRec($subjectData['dbRec']);
        if (!$isDelete)
            abort(500, "Subject delete failed due to server error !");

        return redirect()->route('admin.subjects.index')
            ->with(AlertDataUtil::success('Subject inserted successfully'));
    }

}
