<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Sentinel;
use App\Models\Role as RoleModel;

//use Illuminate\Http\Request;

class MarketerController extends Controller
{


    public function viewMyCommissions(){
        if(!Sentinel::check())
            abort(403);

        $user            = Sentinel::getUser();
        $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
        $currentUserRole = optional($user->roles()->first())->name;
        if(!in_array($currentUserRole, $allRoles))
            abort(403);


        // redirect users that have TEACHER, STUDENT roles
        $allowedRoles   =   [RoleModel::MARKETER];
        if(!in_array($currentUserRole, $allowedRoles))
            abort(404);


        return view('admin-panel.marketer.my-commissions');
    }

}
