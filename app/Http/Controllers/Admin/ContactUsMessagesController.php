<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class ContactUsMessagesController extends Controller
{
    public function viewStudentMessages(){        
        
        try{
            $this->authorize('viewAny',ContactUs::class);
            
            $studentComments = ContactUs::select('contact_us.*', 'users.status as userStat')
            ->whereHas('user', function ($query){
                $query->withoutGlobalScope('active')
                ->whereHas('roles', function ($query){
                    $query->where('name', 'student');
                });
            })
            ->join('users', 'contact_us.user_id', '=', 'users.id')
            ->orderBy('contact_us.created_at', 'desc')
            //->toSql();
            ->get();

        }catch(AuthorizationException $e){          
            
            session()->flash('message','You dont have Permissions to view student comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Permission Denied!');
            unset($studentComments);

        }catch(\Exception $e){
            //session()->flash('message',$e->getMessage());
            session()->flash('message','Failed to show all student comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($studentComments);
        }      
        
        return view('admin-panel.admin.contact-us-students')->with([
            'studentComments' => $studentComments??null
        ]);
    }


    public function viewTeacherMessages(){
        $this->authorize('viewAny',ContactUs::class);
        

        $teacherComments = ContactUs::select('contact_us.*', 'users.status as userStat','users.profile_pic as profilePic')
        ->whereHas('user', function ($query){
            $query->withoutGlobalScope('active')
            ->whereHas('roles', function ($query){
                $query->where('name', 'teacher');
            });
        })
        ->join('users', 'contact_us.user_id', '=', 'users.id')
        ->orderBy('contact_us.created_at', 'desc')
        //->toSql();
        ->get(); 
        
        //dd($teacherComments);
        return view('admin-panel.admin.contact-us-teachers')->with(['teacherComments' => $teacherComments]);
    }


    public function viewOtherUserMessages(){
        $this->authorize('viewAny',ContactUs::class);
        
        // comments belongs to marketers and editors
        $otherUserComments = ContactUs::select('contact_us.*', 'users.status as userStat', 'roles.name as roleName')
        ->whereHas('user', function ($query){
            $query->withoutGlobalScope('active')
            ->whereHas('roles', function ($query){
                $query->where('name', 'marketer')
                    ->orWhere('name', 'editor');
            });
        })
        ->join('users', 'contact_us.user_id', '=', 'users.id')
        ->join('role_users', 'users.id', '=', 'role_users.user_id')
        ->join('roles', 'role_users.role_id', '=', 'roles.id')
        ->orderBy('contact_us.created_at', 'desc')
        //->toSql();
        ->get();

        //dd($otherUserComments);
        return view('admin-panel.admin.contact-us-other-users')->with(['otherUserComments' => $otherUserComments]);
    }




    public function viewGuestMessages(){
        $this->authorize('viewAny',ContactUs::class);
        
        $guestMessages = ContactUs::where('user_id', null)
        ->orderBy('contact_us.created_at', 'desc')
        ->get();
        
        return view('admin-panel.admin.contact-us-guests')->with(['guestMessages' => $guestMessages]);
    }


    public function deleteComment(Request $request, $id){

        //dd($id);
        try{
            
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $comment = ContactUs::find($id);
            
            if ($comment) {

                $this->authorize('delete',$comment);

                $comment->delete();
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

                return redirect(route($redirectRoute))
                    ->with([
                        'message'  => 'successfully deleted the comment',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success!',
                    ]);

            } else {

                throw new CustomException('Comment does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);

            }
        }catch(CustomException $e){

            $exData = $e->getData();
            //dd($e->getData());
            return redirect(route($redirectRoute ?? 'admin.dashboard'))->with([            
                'message'     => $e->getMessage(),
                'cls'         => $exData['cls'] ?? "flash-danger",
                'msgTitle'    => $exData['msgTitle']  ?? 'Error!',
            ]);

        }catch(AuthorizationException $e){
            return redirect(route($redirectRoute ?? 'admin.dashboard'))->with([
                'message'     => 'You dont have Permissions to delete the comment !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied!',
            ]);
            //Illuminate\Auth\Access\AuthorizationException
        }catch(\Exception $e){
            //dd($e);
            //dd(get_class($e));
            return redirect(route($redirectRoute ?? 'admin.dashboard'))->with([
                'message'     => 'Comment delete failed!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error!',
            ]);
        }
    }



}



