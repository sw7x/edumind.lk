<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\Models\Role as RoleModel;
use App\Exceptions\CustomException;
use App\Exceptions\InvalidUserTypeException;

use App\View\DataFormatters\ProfileDataFormatter;
use App\Services\UserService;
use App\Common\SharedServices\UserSharedService;

/*
use Illuminate\Support\Facades\Session;
use App\Builders\UserBuilder;
use App\Repositories\UserRepository;
*/
class PageController extends Controller
{

    private UserService $userService;
    private UserSharedService $userSharedService;


    function __construct(UserService $userService, UserSharedService $userSharedService){
        $this->userService          = $userService;
        $this->userSharedService    = $userSharedService;
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



    public function viewProfileEdit(Request $request){
        $user               = Sentinel::getUser();
        $userSharedService  = new UserSharedService();

        if($userSharedService->hasRole($user, RoleModel::STUDENT))
            return view('student.profile-edit');

        if($userSharedService->hasRole($user, RoleModel::TEACHER))
            return redirect()->route('admin.profile-edit', []);

        abort(404,'This page is not available for your user role');

        //$userData   =   $this->userService->findDbRec($user->id);
        //$userArr    = ProfileDataFormatter::prepareUserData($userData);
        //return view('student.my-profile')->with(['userData' => $userArr]);
    }


    public function viewProfile(Request $request){
        $user = Sentinel::getUser();

        // redirect ADMIN, EDITOR, MARKETER, TEACHER users to profile page in admin panel
        if(!$this->userSharedService->hasRole($user, RoleModel::STUDENT))
            return redirect()->route('admin.profile', []);

        $userData   = $this->userService->findDbRec($user->id);
        $userArr    = ProfileDataFormatter::prepareUserData($userData);
        return view('student.my-profile')->with(['userData' => $userArr]);
    }


    public function viewHelp(Request $request){
        return view('help');
    }


    public function viewDashboard(Request $request){
        $user = Sentinel::getUser();
                        
        // redirect ADMIN, EDITOR, MARKETER, TEACHER users to dashboard of admin panel
        if(!$this->userSharedService->hasRole($user, RoleModel::STUDENT))
            return redirect()->route('admin.dashboard', []);

        //$userData   =   $this->userService->findDbRec($user->id);
        //$userArr    =   ProfileDataFormatter::prepareUserData($userData);
        //return view('student.my-profile')->with(['userData' => $userArr]);
        return view('student.dashboard');
    }


    public function viewComingSoon(Request $request){
        return view('coming-soon');
    }

    public function viewAboutUs(Request $request){
        return view('about-us');
    }

    public function viewWhyChooseUs(Request $request){
        return view('why-edumind');
    }

    public function viewTermsAndServices(Request $request){
        return view('terms-and-services');
    }

}
