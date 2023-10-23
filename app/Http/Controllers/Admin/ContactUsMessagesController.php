<?php
namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\ContactUs as ContactUsModel;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\Admin\ContactUsService as AdminContactUsService;
use App\View\DataFormatters\Admin\ContactUsDataFormatter as AdminContactUsDataFormatter;
use App\Common\Utils\AlertDataUtil;


class ContactUsMessagesController extends Controller
{
    private AdminContactUsService $adminContactUsService;

    function __construct(AdminContactUsService $adminContactUsService){
        $this->adminContactUsService = $adminContactUsService;
    }

    public function viewStudentMessages(){
        $this->authorize('viewAny',ContactUsModel::class);

        $studentCommentsDtoArr  = $this->adminContactUsService->loadStudentMessages();
        $studentCommentsArr     = AdminContactUsDataFormatter::prepareData($studentCommentsDtoArr);

        return view('admin-panel.admin.contact-us-students')->with([
            'studentComments' => $studentCommentsArr ?? null
        ]);
    }

    public function viewTeacherMessages(){
        $this->authorize('viewAny',ContactUsModel::class);

        $teacherCommentsDtoArr  = $this->adminContactUsService->loadTeacherMessages();
        $teacherCommentsArr     = AdminContactUsDataFormatter::prepareData($teacherCommentsDtoArr);

        return view('admin-panel.admin.contact-us-teachers')->with([
            'teacherComments' => $teacherCommentsArr ?? null
        ]);
    }

    public function viewOtherUserMessages(){
        $this->authorize('viewAny',ContactUsModel::class);

        $otherUserCommentsDtoArr  = $this->adminContactUsService->loadOtherUserMessages();
        $otherUserCommentsArr     = AdminContactUsDataFormatter::prepareData($otherUserCommentsDtoArr);

        return view('admin-panel.admin.contact-us-other-users')->with([
            'otherUserComments' => $otherUserCommentsArr ?? null
        ]);

    }

    public function viewGuestMessages(){
        $this->authorize('viewAny',ContactUsModel::class);

        $guestCommentsDtoArr  = $this->adminContactUsService->loadGuestMessages();
        $guestCommentsArr     = AdminContactUsDataFormatter::prepareData($guestCommentsDtoArr);

        return view('admin-panel.admin.contact-us-guests')->with([
            'guestMessages' => $guestCommentsArr ?? null
        ]);

    }

    public function deleteComment(Request $request, int $id){

        try{
            $userType = isset($request->userType) ? $request->userType : null;
            switch ($userType) {
                case "teacher":
                    $redirectRoute  = 'admin.feedbacks.teacher';
                    break;
                case "student":
                    $redirectRoute  = 'admin.feedbacks.student';
                    break;
                case "other":
                    $redirectRoute  = 'admin.feedbacks.other-user';
                    break;
                case "guest":
                    $redirectRoute  = 'admin.feedbacks.guest';
                    break;
                default:
                    $redirectRoute  = 'admin.dashboard';
            }

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $commentRec  = $this->adminContactUsService->findContactUsMessageRec($id);
            if (is_null($commentRec))
                abort(404, 'Comment does not exist!');

            $this->authorize('delete', $commentRec);

            $isDelete  = $this->adminContactUsService->deleteContactUsMessage($id);
            if(!$isDelete)
                abort(500, "Failed to delete comment due to server error !");

            return  redirect(route($redirectRoute))
                        ->with(AlertDataUtil::success('successfully deleted the comment !'));

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Comment delete failed !';
            return redirect()->back()->with(AlertDataUtil::error($msg,[/*'message' => $e->getMessage()*/]));
        }
    }

}
