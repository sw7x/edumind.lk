<?php

use App\Permissions\Abilities\SubjectAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;
use App\Models\Subject as SubjectModel;
use App\Models\Role as RoleModel;
use App\Permissions\Policies\SubjectPolicy;
use Illuminate\Auth\Access\Response;
use App\Common\SharedServices\UserSharedService;




GateFacade::define(
	SubjectAbilities::ADMIN_PANEL_VIEW_SUBJECT_LIST, function(?UserModel $user) {
	
	$allowedRoles 	= 	[RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER];
    $response       =   (new UserSharedService)->hasAnyRole($user, $allowedRoles) ? 
                            Response::allow() : 
                            Response::deny('You dont have Permissions to view all subjects in admin panel !'); 
    return  $response;                   
});


GateFacade::define(
	SubjectAbilities::ADMIN_PANEL_VIEW_SUBJECTS, function(?UserModel $user) {
	
	$allowedRoles 	= 	[RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER];
    $response       =   (new UserSharedService)->hasAnyRole($user, $allowedRoles) ? 
                            Response::allow() : 
                            Response::deny('You dont have Permissions to view subjects in admin panel !'); 
    return  $response;	
});





GateFacade::define(
	SubjectAbilities::CREATE_SUBJECTS, function(?UserModel $user) {
	
	return (new SubjectPolicy)->create($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to create new subjects !');
});



GateFacade::define(
	SubjectAbilities::EDIT_SUBJECTS, function(?UserModel $user, SubjectModel $subject) {
	
	//dd((new SubjectPolicy)->update($user, $subject));
	return (new SubjectPolicy)->update($user, $subject) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to edit the subject !');
});

GateFacade::define(
	SubjectAbilities::DELETE_SUBJECTS, function(?UserModel $user, SubjectModel $subject) {
	
	return (new SubjectPolicy)->delete($user, $subject) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to delete the subject !');
});
