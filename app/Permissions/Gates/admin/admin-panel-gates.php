<?php
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;
use App\Permissions\Abilities\AdminPanelAbilities;
use Illuminate\Auth\Access\Response;
use App\Models\Role as RoleModel;
use App\Common\SharedServices\UserSharedService;

    


GateFacade::define(
    AdminPanelAbilities::ACCESS, function(UserModel $user) {

    $allowedRoles   =   [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER];
    $response       =   (new UserSharedService)->hasAnyRole($user, $allowedRoles) ? 
                            Response::allow() : 
                            Response::deny('You dont have Permissions to access admin panel. !'); 
    return $response;
});