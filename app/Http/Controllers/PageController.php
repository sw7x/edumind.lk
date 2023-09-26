<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Sentinel;
use App\Models\Role as RoleModel;
use App\Exceptions\CustomException;
use App\Builders\UserBuilder;
use App\Repositories\UserRepository;
use App\View\DataTransformers\ProfileDataTransformer;

use App\Services\UserService;

class PageController extends Controller
{
    
    private UserService $userService;


    function __construct(UserService $userService){
        $this->userService  = $userService;
    }


    public function page404(Request $request){

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([], 404);
        }else{

            if(Sentinel::check()){
                if(Sentinel::getUser()->roles()->first()->slug == 'student'){
                    $view = 'errors.404' ;
                }else{
                    $view = $request->is('admin/*') ? 'admin-panel.errors.404' : 'errors.404' ;
                }

            }else{
                $view = 'errors.404' ;
            }

            return response()->view($view, [], 404);
        }
    }



    public function pageNoPermission(Request $request){

        //dump($request->input('susa'));
        //dd(Session::get('susa'));

        return view('form-submit-page');

        /*return view('form-submit-page')->with([
            //'message'     => 'You dont have permission to access this page',
            'message'     => $request->get('susa'),
            'cls'         => "flash-warning",
            'msgTitle'    => 'Warning !',
        ]);*/
    }
    
    public function viewProfile(Request $request){
        
        //dump('viewProfile');
        
        try{

            $user = Sentinel::getUser();
            if(is_null($user))
                throw new CustomException('Access denied');
            
            $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
            $currentUserRole = optional($user->roles()->first())->name;        
            if(!in_array($currentUserRole, $allRoles))
                throw new CustomException('Invalid user type');

            
            // redirect users that have ADMIN, EDITOR, MARKETER roles
            $allowedRoles = [RoleModel::TEACHER, RoleModel::STUDENT];
            if(!in_array($currentUserRole, $allowedRoles))
                return redirect()->route('admin.profile', []);


            $viewFile   =   ($currentUserRole == RoleModel::TEACHER) ? 
                                'teacher.teacher-my-profile-full-width' : 
                                'student.student-my-profile-full-width';            
            /*
            $viewFile   =   ($currentUserRole == RoleModel::TEACHER) ? 
                                'teacher.teacher-my-profile' : 
                                'student.student-my-profile';
            */

            $userData   =   $this->userService->findDbRec($user->id);
            $userArr    = ProfileDataTransformer::prepareUserData($userData);
            return view($viewFile)->with(['userData' => $userArr]);
                 
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher.teacher-my-profile'); 

        }catch(\Exception $e){
            session()->flash('message', $e->getMessage());
            //session()->flash('message', 'Failed to load your profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('teacher.teacher-my-profile');  
        }
    }

}
