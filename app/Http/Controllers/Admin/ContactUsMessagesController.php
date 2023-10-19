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

//use App\Repositories\ContactUsRepository;

class ContactUsMessagesController extends Controller
{
    /*private $subjectService;

    function __construct(SubjectService $subjectService){
        $this->subjectService = $subjectService;
    }*/

    private AdminContactUsService $adminContactUsService;

    function __construct(AdminContactUsService $adminContactUsService){
        $this->adminContactUsService = $adminContactUsService;
    }

    public function viewStudentMessages(){

        try{
            $this->authorize('viewAny',ContactUsModel::class);

            $studentCommentsDtoArr  = $this->adminContactUsService->loadStudentMessages();
            $studentCommentsArr     = AdminContactUsDataFormatter::prepareData($studentCommentsDtoArr);

        }catch(AuthorizationException $e){
            session()->now('message','You dont have Permissions to view student comments!');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Permission Denied!');
            unset($studentCommentsArr);

        }catch(CustomException $e){
            session()->now('message',$e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            unset($studentCommentsArr);

        }catch(\Exception $e){
            session()->now('message',$e->getMessage());
            //session()->now('message','Failed to show all student comments!');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            unset($studentCommentsArr);
        }

        return view('admin-panel.admin.contact-us-students')->with([
            'studentComments' => $studentCommentsArr ?? null
        ]);
    }


    public function viewTeacherMessages(){

        try{
            $this->authorize('viewAny',ContactUsModel::class);

            $teacherCommentsDtoArr  = $this->adminContactUsService->loadTeacherMessages();
            $teacherCommentsArr     = AdminContactUsDataFormatter::prepareData($teacherCommentsDtoArr);

        }catch(AuthorizationException $e){
            session()->now('message','You dont have Permissions to view teacher comments!');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Permission Denied!');
            unset($teacherCommentsArr);

        }catch(CustomException $e){
            session()->now('message',$e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            unset($teacherCommentsArr);

        }catch(\Exception $e){
            session()->now('message',$e->getMessage());
            //session()->now('message','Failed to show all teacher comments!');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            unset($teacherCommentsArr);
        }

        return view('admin-panel.admin.contact-us-teachers')->with([
            'teacherComments' => $teacherCommentsArr ?? null
        ]);
    }


    public function viewOtherUserMessages(){
        try{
            $this->authorize('viewAny',ContactUsModel::class);

            $otherUserCommentsDtoArr  = $this->adminContactUsService->loadOtherUserMessages();
            $otherUserCommentsArr     = AdminContactUsDataFormatter::prepareData($otherUserCommentsDtoArr);

        }catch(AuthorizationException $e){
            session()->now('message','You dont have Permissions to view otherUser comments!');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Permission Denied!');
            unset($otherUserCommentsArr);

        }catch(CustomException $e){
            session()->now('message',$e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            unset($otherUserCommentsArr);

        }catch(\Exception $e){
            session()->now('message',$e->getMessage());
            //session()->now('message','Failed to show all otherUser comments!');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            unset($otherUserCommentsArr);
        }

        return view('admin-panel.admin.contact-us-other-users')->with([
            'otherUserComments' => $otherUserCommentsArr ?? null
        ]);

    }


    public function viewGuestMessages(){
        try{
            $this->authorize('viewAny',ContactUsModel::class);

            $guestCommentsDtoArr  = $this->adminContactUsService->loadGuestMessages();
            $guestCommentsArr     = AdminContactUsDataFormatter::prepareData($guestCommentsDtoArr);

        }catch(AuthorizationException $e){
            session()->now('message','You dont have Permissions to view guest comments!');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Permission Denied!');
            unset($guestCommentsArr);

        }catch(CustomException $e){
            session()->now('message',$e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            unset($guestCommentsArr);

        }catch(\Exception $e){
            session()->now('message',$e->getMessage());
            //session()->now('message','Failed to show all guest comments!');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            unset($guestCommentsArr);
        }

        return view('admin-panel.admin.contact-us-guests')->with([
            'guestMessages' => $guestCommentsArr ?? null
        ]);

    }






    public function deleteComment(Request $request, int $id){

        //dd($id);
        try{

            $userType = (isset($request->userType)?$request->userType:null);
            switch ($userType) {
                case "teacher":
                    $redirectRoute = 'admin.feedbacks.teacher';
                    break;
                case "student":
                    $redirectRoute = 'admin.feedbacks.student';
                    break;
                case "other":
                    $redirectRoute = 'admin.feedbacks.other-user';
                    break;
                case "guest":
                    $redirectRoute = 'admin.feedbacks.guest';
                    break;
                default:
                    $redirectRoute = 'admin.dashboard';
            }

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $commentRec  = $this->adminContactUsService->findContactUsMessageRec($id);
            if (is_null($commentRec))
                throw new CustomException('Comment does not exist!');

            $this->authorize('delete', $commentRec);

            $isDelete  = $this->adminContactUsService->deleteContactUsMessage($id);
            if(!$isDelete)
                throw new CustomException("Failed to delete comment !");
            
            return redirect(route($redirectRoute))->with(
                AlertDataUtil::success('successfully deleted the comment !')
            );


        }catch(CustomException $e){
            $exData = $e->getData();
            return redirect()->back()->with(
                AlertDataUtil::error($e->getMessage(),[
                    'cls'         => $exData['cls'] ?? "flash-danger",
                    'msgTitle'    => $exData['msgTitle']  ?? 'Error!',
                ])
            );

        }catch(AuthorizationException $e){
            return redirect(route('admin.dashboard'))->with(
                AlertDataUtil::error('You dont have Permissions to view guest comments!',[
                    'msgTitle' => 'Permission Denied!'
                ])
            );

        }catch(\Exception $e){
            return redirect()->back()->with(
                AlertDataUtil::error('Comment delete failed !',[
                    //'message' => $e->getMessage()
                ])
            );
        }
    }



}



