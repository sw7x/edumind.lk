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

use App\Permissions\PermissionChecker;
use App\Permissions\Abilities\SubjectAbilities;
       

class SubjectController extends Controller
{

    private AdminSubjectService $adminSubjectService;

    function __construct(AdminSubjectService $adminSubjectService){
        $this->adminSubjectService = $adminSubjectService;
    }

    public function index(){
        PermissionChecker::authorize(SubjectAbilities::VIEW_ADMIN_PANEL_SUBJECT_LIST);
        
        $subjectsData    = $this->adminSubjectService->loadAllDbRecs();
        $filteredDataArr = AdminSubjectDataFormatter::prepareSubjectDataList($subjectsData);
        return view ('admin-panel.subject-list')->withData($filteredDataArr);
    }

    public function create(){
        PermissionChecker::authorize(SubjectAbilities::CREATE);

        $this->authorize('create',SubjectModel::class);
        return view('admin-panel.subject-add');
    }

    public function store(Request $request){
        PermissionChecker::authorize(SubjectAbilities::CREATE);
        
        try{
            
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
        PermissionChecker::authorize(SubjectAbilities::VIEW_ADMIN_PANEL_SUBJECT);        

        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $subjectData = $this->adminSubjectService->findDbRec($id);

        if(is_null($subjectData['dbRec']))
            abort(404,'Subject does not exist!');
        
        $subjectDataArr = AdminSubjectDataFormatter::prepareViewSubjectData($subjectData['dto']);
        return view('admin-panel.subject-view')->with(['subject' => $subjectDataArr]);
    }

    public function edit(int $id){
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $subjectData = $this->adminSubjectService->findDbRec($id);
        if(is_null($subjectData['dbRec']))
            abort(404,'Subject does not exist!');

        PermissionChecker::authorize(SubjectAbilities::EDIT, $subjectData['dbRec']);

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

            PermissionChecker::authorize(SubjectAbilities::EDIT, $subjectData['dbRec']);

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

        PermissionChecker::authorize(SubjectAbilities::DELETE, $subjectData['dbRec']);

        $isDelete = $this->adminSubjectService->deleteDbRec($subjectData['dbRec']);
        if (!$isDelete)
            abort(500, "Subject delete failed due to server error !");

        return redirect()->route('admin.subjects.index')
            ->with(AlertDataUtil::success('Subject inserted successfully'));
    }

}
