<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\Contact_us;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class ContactUsMessagesController extends Controller
{
    public function students(){      

        try{
            $this->authorize('viewAny',Contact_us::class);
            $studentComments    = Contact_us::whereHas('user', function($query){
                //$query->where('subject', 'ww');
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'student');
                });
            })->orderBy('created_at', 'desc')->get();

        }catch(AuthorizationException $e){          
            session()->flash('message','You dont have Permissions to view student comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Permission Denied!');
            unset($studentComments);

        }catch(\Exception $e){
            session()->flash('message','Failed to show all student comments!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($studentComments);

        }      
        
        return view('admin-panel.admin.contact-us-students')->with([
            'studentComments' => $studentComments??null
        ]);
    }


    public function teachers(){
        $this->authorize('viewAny',Contact_us::class);
        $teacherComments    = Contact_us::whereHas('user', function($query){
            //$query->where('subject', 'ww');
            $query->whereHas('roles', function ($query) {
                $query->where('name', 'teacher');
            });
        })->orderBy('created_at', 'desc')->get();

        return view('admin-panel.admin.contact-us-teachers')->with(['teacherComments' => $teacherComments]);
    }


    public function otherUsers(){
        $this->authorize('viewAny',Contact_us::class);
        // comments belongs to marketers and editors
        $otherUserComments    = Contact_us::whereHas('user', function($query){
            //$query->where('subject', 'ww');
            $query->whereHas('roles', function ($query) {
                $query->where('name', 'marketer')
                    ->orWhere('name', 'editor');
            });
        })->orderBy('created_at', 'desc')->get();

        return view('admin-panel.admin.contact-us-other-users')->with(['otherUserComments' => $otherUserComments]);
    }




    public function guests(){
        $this->authorize('viewAny',Contact_us::class);
        $guestMessages = Contact_us::where('user_id', null)->get();

        $guestMessages->each(function($item, $key) {
           // var_dump ($item->id);
        });

        //dd();



        return view('admin-panel.admin.contact-us-guests')->with(['guestMessages' => $guestMessages]);
    }


    public function delete_comment(Request $request, $id){

        //dd($id);
        try{
            
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $comment = Contact_us::find($id);
            
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
