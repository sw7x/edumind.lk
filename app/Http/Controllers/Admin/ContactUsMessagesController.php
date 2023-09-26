<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\Admin\ContactUsService as AdminContactUsService;
use App\View\DataTransformers\Admin\ContactUsDataTransformer as AdminContactUsDataTransformer;

//use App\Models\User;
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
            $this->authorize('viewAny',ContactUs::class);

            $studentCommentsDtoArr  = $this->adminContactUsService->loadStudentMessages();
            $studentCommentsArr     = AdminContactUsDataTransformer::prepareData($studentCommentsDtoArr);

        }catch(AuthorizationException $e){
            session()->flash('message','You dont have Permissions to view student comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Permission Denied!');
            unset($studentCommentsArr);

        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($studentCommentsArr);

        }catch(\Exception $e){
            session()->flash('message',$e->getMessage());
            //session()->flash('message','Failed to show all student comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($studentCommentsArr);
        }

        return view('admin-panel.admin.contact-us-students')->with([
            'studentComments' => $studentCommentsArr ?? null
        ]);
    }


    public function viewTeacherMessages(){

        try{
            $this->authorize('viewAny',ContactUs::class);

            $teacherCommentsDtoArr  = $this->adminContactUsService->loadTeacherMessages();
            $teacherCommentsArr     = AdminContactUsDataTransformer::prepareData($teacherCommentsDtoArr);

        }catch(AuthorizationException $e){
            session()->flash('message','You dont have Permissions to view teacher comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Permission Denied!');
            unset($teacherCommentsArr);

        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($teacherCommentsArr);

        }catch(\Exception $e){
            session()->flash('message',$e->getMessage());
            //session()->flash('message','Failed to show all teacher comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($teacherCommentsArr);
        }

        return view('admin-panel.admin.contact-us-teachers')->with([
            'teacherComments' => $teacherCommentsArr ?? null
        ]);
    }


    public function viewOtherUserMessages(){
        try{
            $this->authorize('viewAny',ContactUs::class);

            $otherUserCommentsDtoArr  = $this->adminContactUsService->loadOtherUserMessages();
            $otherUserCommentsArr     = AdminContactUsDataTransformer::prepareData($otherUserCommentsDtoArr);

        }catch(AuthorizationException $e){
            session()->flash('message','You dont have Permissions to view otherUser comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Permission Denied!');
            unset($otherUserCommentsArr);

        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($otherUserCommentsArr);

        }catch(\Exception $e){
            session()->flash('message',$e->getMessage());
            //session()->flash('message','Failed to show all otherUser comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($otherUserCommentsArr);
        }

        return view('admin-panel.admin.contact-us-other-users')->with([
            'otherUserComments' => $otherUserCommentsArr ?? null
        ]);

    }


    public function viewGuestMessages(){
        try{
            $this->authorize('viewAny',ContactUs::class);

            $guestCommentsDtoArr  = $this->adminContactUsService->loadGuestMessages();
            $guestCommentsArr     = AdminContactUsDataTransformer::prepareData($guestCommentsDtoArr);

        }catch(AuthorizationException $e){
            session()->flash('message','You dont have Permissions to view guest comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Permission Denied!');
            unset($guestCommentsArr);

        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($guestCommentsArr);

        }catch(\Exception $e){
            session()->flash('message',$e->getMessage());
            //session()->flash('message','Failed to show all guest comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
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
                    $redirectRoute = 'admin.feedback.teachers';
                    break;
                case "student":
                    $redirectRoute = 'admin.feedback.students';
                    break;
                case "other":
                    $redirectRoute = 'admin.feedback.other-users';
                    break;
                case "guest":
                    $redirectRoute = 'admin.feedback.guests';
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

            return redirect(route($redirectRoute))->with([
                'message'  => 'successfully deleted the comment',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success!',
            ]);


        }catch(CustomException $e){
            $exData = $e->getData();
            return redirect()->back()->with([
            //return redirect(route($redirectRoute ?? 'admin.dashboard'))->with([
                'message'     => $e->getMessage(),
                'cls'         => $exData['cls'] ?? "flash-danger",
                'msgTitle'    => $exData['msgTitle']  ?? 'Error!',
            ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.dashboard'))->with([
                'message'     => 'You dont have Permissions to delete the comment !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied!',
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with([
                //'message'     => $e->getMessage(),
                'message'     => 'Comment delete failed!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error!',
            ]);
        }
    }



}



