<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Sentinel;
use App\Models\Role as RoleModel;
use App\Exceptions\InvalidUserTypeException;
//use Illuminate\Http\Request;


class MarketerController extends Controller
{


    public function viewMyCommissions(){
        //need login
        //need valid role
        // marketer role only

        if(!Sentinel::check())
            abort(401);

        $user = Sentinel::getUser();
        if(!(new UserSharedService)->isHaveValidRole($user))
            throw new InvalidUserTypeException("");
            
        // redirect users that have TEACHER, STUDENT roles        
        if(!(new UserSharedService)->hasRole($user, RoleModel::MARKETER))
            abort(404);

        return view('admin-panel.marketer.my-commissions');
    }

}
