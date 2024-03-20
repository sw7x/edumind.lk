<?php

use App\Permissions\Abilities\UserManageAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;
use App\Permissions\Policies\UserPolicy;
use Illuminate\Auth\Access\Response;

//use App\Common\SharedServices\UserSharedService;
//use App\Models\Role as RoleModel;



GateFacade::define(
	UserManageAbilities::ADMIN_PANEL_VIEW_USER_LIST, function(?UserModel $user) {
	
	return (new UserPolicy)->viewAny($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view user list in admin panel !');	                   
});


/*
    - Admins can view any user.
    - Editors can only view Teacher users.
*/
GateFacade::define(
	UserManageAbilities::ADMIN_PANEL_VIEW_USER, function(?UserModel $currentUser, UserModel $selectedUserModel) {
	
	return (new UserPolicy)->view($currentUser, $selectedUserModel) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view the requested user account in admin panel !');	                   
});

GateFacade::define(
	UserManageAbilities::VIEW_TEACHERS, function(?UserModel $user) {
	
	return (new UserPolicy)->viewTeachers($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view teachers !');	                   
});

GateFacade::define(
	UserManageAbilities::VIEW_STUDENTS, function(?UserModel $user) {
	
	return (new UserPolicy)->viewStudents($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view students !');	                   
});

GateFacade::define(
	UserManageAbilities::VIEW_EDITORS, function(?UserModel $user) {
	
	return (new UserPolicy)->viewEditors($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view editors !');	                   
});

GateFacade::define(
	UserManageAbilities::VIEW_MARKETERS, function(?UserModel $user) {
	
	return (new UserPolicy)->viewMarketers($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view marketers !');	                   
});





GateFacade::define(
	UserManageAbilities::VIEW_CREATE_PAGE, function(?UserModel $user) {
	
	return (new UserPolicy)->create($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view create user page !');	                   
});


GateFacade::define(
	UserManageAbilities::CREATE_TEACHERS, function(?UserModel $user) {
	
	return (new UserPolicy)->createTeachers($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to create teacher user accounts !');	                   
});

GateFacade::define(
	UserManageAbilities::CREATE_STUDENTS, function(?UserModel $user) {
	
	return (new UserPolicy)->createStudents($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to create student user accounts !');	                   
});

GateFacade::define(
	UserManageAbilities::CREATE_MARKETERS, function(?UserModel $user) {
	
	return (new UserPolicy)->createMarketers($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to create marketer user accounts !');	                   
});

GateFacade::define(
	UserManageAbilities::CREATE_EDITORS, function(?UserModel $user) {
	
	return (new UserPolicy)->createEditors($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to create editor user accounts !');	                   
});







GateFacade::define(
	UserManageAbilities::VIEW_EDIT_PAGE, function(?UserModel $currentUser) {
	
	return (new UserPolicy)->update($currentUser) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view edit user page !');	                   
});

GateFacade::define(
	UserManageAbilities::EDIT_TEACHERS, function(?UserModel $currentUser) {
	
	return (new UserPolicy)->updateTeachers($currentUser) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to update teacher user accounts !');	                   
});

GateFacade::define(
	UserManageAbilities::EDIT_STUDENTS, function(?UserModel $currentUser) {
	
	return (new UserPolicy)->updateStudents($currentUser) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to update student user accounts !');	                   
});

GateFacade::define(
	UserManageAbilities::EDIT_MARKETERS, function(?UserModel $currentUser) {
	
	return (new UserPolicy)->updateMarketers($currentUser) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to update marketer user accounts !');	                   
});

GateFacade::define(
	UserManageAbilities::EDIT_EDITORS, function(?UserModel $currentUser) {
	
	return (new UserPolicy)->updateEditors($currentUser) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to update editor user accounts !');	                   
});










GateFacade::define(
	UserManageAbilities::DELETE_USERS, 
	function(?UserModel $currentUser) {
	
	return (new UserPolicy)->delete($currentUser) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to delete user accounts !');                 
});

GateFacade::define(
	UserManageAbilities::CHANGE_USERS_STATUS, function(?UserModel $currentUser) {
	
	return (new UserPolicy)->changeUserStatus($currentUser) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to update the status of user accounts !');	                   
});