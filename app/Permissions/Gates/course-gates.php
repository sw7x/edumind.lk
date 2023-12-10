<?php

use App\Permissions\Abilities\CourseAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;
use App\Models\Course as CourseModel;
use App\Models\Role as RoleModel;
//use App\Permissions\Policies\CoursePolicy;
use Illuminate\Auth\Access\Response;
use App\Common\SharedServices\UserSharedService;
use App\Repositories\CourseRepository;



/*
    - Students can enrolled courses.
    - Guests can click enroll to courses then system will redirect user.
*/
GateFacade::define(
	CourseAbilities::ENROLL_TO_COURSE, function(?UserModel $user) {	
	
	$isGuest = is_null($user);
	
	$userSharedService 	= new UserSharedService();
	$isStudent 			= $userSharedService->hasRole($user, RoleModel::STUDENT);	
	
	return ($isGuest || $isStudent) ?
		Response::allow() : 
		Response::deny('You dont have Permissions to enroll the course !');
});



/*
    - Admins and editors can watch any course.
    - Teachers and (editors) can watch courses(paid) they have created.
    - Students can watch their enrolled courses(paid).
    - anyone can watch Free courses.
*/
GateFacade::define(
	CourseAbilities::WATCH_COURSE, function(?UserModel $user, CourseModel $course) {	
	$userSharedService = new UserSharedService();

	$hasAllowedRole = $userSharedService->hasAnyRole($user, [RoleModel::ADMIN, RoleModel::EDITOR]);
	
	$isFreeCourse 	= $course->price == 0;
	
	$isTeacher 		= $userSharedService->hasRole($user, RoleModel::TEACHER);	
	$isCourseAuthor = $isTeacher ? $user->isCourseAuthor($course) : false;
	
	
	$isStudent = $userSharedService->hasRole($user, RoleModel::STUDENT);	
	if ($isStudent) {
		$enrolledCourses 	= (new CourseRepository())->getEnrolledCoursesByStudent($user);
		$isEnrolledCourse 	= $enrolledCourses->contains('id', $course->id);	
	} else {
		$isEnrolledCourse 	= false;
	}	

   	return ($hasAllowedRole || $isCourseAuthor || $isEnrolledCourse || $isFreeCourse) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to watch the course materials !');
});





//student enrolled courses only
GateFacade::define(
	CourseAbilities::MARK_COMPLETE, function(?UserModel $user, CourseModel $course) {

	$isStudent = (new UserSharedService)->hasRole($user, RoleModel::STUDENT);
	if ($isStudent) {
		$enrolledCourses 	= (new CourseRepository())->getEnrolledCoursesByStudent($user);
		$isEnrolledCourse 	= $enrolledCourses->contains('id', $course->id);	
	} else {
		$isEnrolledCourse 	= false;
	}	

   	return $isEnrolledCourse ? 
   		Response::allow() :
   		Response::deny('You dont have Permissions to mark this course as completed by yourself !');
});