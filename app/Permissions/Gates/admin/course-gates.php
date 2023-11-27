<?php

use App\Permissions\Abilities\CourseAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;
use Illuminate\Auth\Access\Response;
use App\Common\SharedServices\UserSharedService;
use App\Permissions\Policies\CoursePolicy;
use App\Models\Role as RoleModel;
use App\Models\Course as CourseModel;

/*
*/



/*
    - Admins, editors and teachers can view course list in admin panel.
*/
GateFacade::define(
	CourseAbilities::ADMIN_PANEL_VIEW_COURSE_LIST, function(?UserModel $user) {

	$userSharedService 	= new UserSharedService();
	$allowedRoles 		= [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER];
	$hasAllowedRole 	= $userSharedService->hasAnyRole($user, $allowedRoles);
	
	return ((new CoursePolicy)->viewAny($user) && $hasAllowedRole) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view course list in admin panel !');	
});



/*
    - Admins, editors and teachers can view course in admin panel.
*/
GateFacade::define(
	CourseAbilities::ADMIN_PANEL_VIEW_COURSE, function(?UserModel $user, CourseModel $course) {

	$userSharedService 	= new UserSharedService();
	$allowedRoles 		= [RoleModel::ADMIN, RoleModel::EDITOR];
	$hasAllowedRole 	= $userSharedService->hasAnyRole($user, $allowedRoles);
	
	$isTeacher 		= $userSharedService->hasRole($user, RoleModel::TEACHER);
	$isCourseAuthor = $isTeacher ? $user->isCourseAuthor($course) : false;

	return ((new CoursePolicy)->view($user, $course) && ($hasAllowedRole || $isCourseAuthor)) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view course in admin panel !');	
});



/*
    - Admins, editors and teachers can create course.
*/
GateFacade::define(
	CourseAbilities::CREATE_COURSES, function(?UserModel $user) {

	return (new CoursePolicy)->create($user) ? 
			Response::allow() : 
			Response::deny('You dont have Permissions to create courses !');
});



/*
    - Admins and editors can edit any course.
    - Teachers can edit the courses that they created.
*/
GateFacade::define(
	CourseAbilities::EDIT_COURSE, function(?UserModel $user, CourseModel $course) {
	
	return (new CoursePolicy)->update($user, $course) ?
			Response::allow() : 
			Response::deny('You dont have Permissions to edit courses !');
});



/*
    - Admins and editors can delete any course.
    - Teachers can delete the courses that they created.
*/
GateFacade::define(
	CourseAbilities::DELETE_COURSE, function(?UserModel $user, CourseModel $course) {
	
	return (new CoursePolicy)->delete($user, $course) ?
			Response::allow() : 
			Response::deny('You dont have Permissions to delete courses !');
});




/*
    - Admins and editors can change status of the any course.
    - Teachers can change status of the courses that they created.
*/
GateFacade::define(
	CourseAbilities::CHANGE_COURSE_STATUS, function(?UserModel $user, CourseModel $course) {
	
	return (new CoursePolicy)->changeStatus($user, $course) ?
			Response::allow() : 
			Response::deny('You dont have Permissions to change status of the course !');
});