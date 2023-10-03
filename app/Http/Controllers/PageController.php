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
    
    public function viewInstruction(){
        return view('instruction');
    }

    public function page404(Request $request){

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([], 404);
        }else{

            if(Sentinel::check()){
                if(Sentinel::getUser()->roles()->first()->slug == RoleModel::STUDENT){
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
    
    public function viewProfileEditPage(Request $request){
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
                abort(403);

            if($currentUserRole == RoleModel::STUDENT)
                return view('student.student-profile-edit');

            
            if($currentUserRole == RoleModel::TEACHER)
                return redirect()->route('admin.profile-edit', []);

            
            

            //$userData   =   $this->userService->findDbRec($user->id);
            //$userArr    = ProfileDataTransformer::prepareUserData($userData);
            //return view('student.student-my-profile')->with(['userData' => $userArr]);
                             
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-profile'); 

        }catch(\Exception $e){
            //dd($e->getMessage());
            session()->flash('message', $e->getMessage());
            //session()->flash('message', 'Failed to load your profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-profile');  
        }
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
            $allowedRoles = [RoleModel::STUDENT];
            if(!in_array($currentUserRole, $allowedRoles))
                return redirect()->route('admin.profile', []);
            

            $userData   =   $this->userService->findDbRec($user->id);
            $userArr    = ProfileDataTransformer::prepareUserData($userData);
            return view('student.student-my-profile')->with(['userData' => $userArr]);
                             
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-profile'); 

        }catch(\Exception $e){
            session()->flash('message', $e->getMessage());
            //session()->flash('message', 'Failed to load your profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-my-profile');  
        }
    }

    public function viewHelpPage(Request $request){
        return view('help');        
    }

    public function viewDashboardPage(Request $request){
        
        //dump('viewDashboardPage');
        
        try{
            $user = Sentinel::getUser();
            if(is_null($user))
                throw new CustomException('Access denied');
            
            $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
            $currentUserRole = optional($user->roles()->first())->name;        
            if(!in_array($currentUserRole, $allRoles))
                throw new CustomException('Invalid user type');

            
            // redirect users that have ADMIN, EDITOR, MARKETER roles
            $allowedRoles = [RoleModel::STUDENT];
            if(!in_array($currentUserRole, $allowedRoles))
                return redirect()->route('admin.dashboard', []);
            

            //$userData   =   $this->userService->findDbRec($user->id);
            //$userArr    =   ProfileDataTransformer::prepareUserData($userData);
            //return view('student.student-my-profile')->with(['userData' => $userArr]);
            return view('student.student-profile-dashboard');
                             
        }catch(CustomException $e){
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-profile-dashboard'); 

        }catch(\Exception $e){
            session()->flash('message', $e->getMessage());
            //session()->flash('message', 'Failed to load your profile');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('student.student-profile-dashboard');  
        }
    }


    public function viewComingSoonPage(Request $request){
        return view('coming-soon');
    }

    public function viewAboutUsPage(Request $request){
        return view('about-us');
    }

    public function viewWhyChooseUsPage(Request $request){
        return view('why-edumind');
    }

    public function viewTermsAndServicesPage(Request $request){
        return view('terms-and-services');
    }

}
