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
        $user = Sentinel::getUser();
        if(is_null($user))
            abort(401, 'Authentication is required To access this page');

        if(!$this->userSharedService->checkUserHaveValidRole($user))
            throw new InvalidUserTypeException('Your user role is not valid for access this page.');

        if(!$this->userSharedService->isAllowed($user, [RoleModel::TEACHER, RoleModel::STUDENT]))
            abort(403);

        $currentUserRole = $this->userSharedService->getRoleByUser($user);
        
        if($currentUserRole == RoleModel::STUDENT)
            return view('student.profile-edit');

        if($currentUserRole == RoleModel::TEACHER)
            return redirect()->route('admin.profile-edit', []);

        //$userData   =   $this->userService->findDbRec($user->id);
        //$userArr    = ProfileDataFormatter::prepareUserData($userData);
        //return view('student.my-profile')->with(['userData' => $userArr]);

    }


    public function viewProfile(Request $request){
        $user = Sentinel::getUser();
        if(is_null($user))
            abort(401, 'Authentication is required To access this page');

        if(!$this->userSharedService->checkUserHaveValidRole($user))
            throw new InvalidUserTypeException('Your user role is not valid for access this page.');
        
        // redirect ADMIN, EDITOR, MARKETER, TEACHER users to profile page in admin panel
        if(!$this->userSharedService->isAllowed($user, [RoleModel::STUDENT]))
            return redirect()->route('admin.profile', []);

        $userData   =   $this->userService->findDbRec($user->id);
        $userArr    = ProfileDataFormatter::prepareUserData($userData);
        return view('student.my-profile')->with(['userData' => $userArr]);
       
    }


    public function viewHelpPage(Request $request){
        return view('help');
    }


    public function viewDashboardPage(Request $request){

        $user = Sentinel::getUser();
        if(is_null($user)) 
            abort(401, 'Authentication is required To access this page');
                    
        if(!$this->userSharedService->checkUserHaveValidRole($user))
            throw new InvalidUserTypeException('Your user role is not valid for access this page.');
                
        // redirect ADMIN, EDITOR, MARKETER, TEACHER users to dashboard of admin panel
        if(!$this->userSharedService->isAllowed($user, [RoleModel::STUDENT]))
            return redirect()->route('admin.dashboard', []);

        //$userData   =   $this->userService->findDbRec($user->id);
        //$userArr    =   ProfileDataFormatter::prepareUserData($userData);
        //return view('student.my-profile')->with(['userData' => $userArr]);
        return view('student.dashboard');

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
