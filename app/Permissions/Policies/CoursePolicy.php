<?php

namespace App\Permissions\Policies;

use App\Models\Course as CourseModel;
use App\Models\User as UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Role as RoleModel;
use App\Common\SharedServices\UserSharedService;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User as UserModel  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(UserModel $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Course as CourseModel  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserModel $user, CourseModel $course)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User as UserModel  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(UserModel $user)
    {
        $userSharedService  = new UserSharedService();
        $allowedRoles       = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER];
        $hasAllowedRole     = $userSharedService->hasAnyRole($user, $allowedRoles);
        return $hasAllowedRole;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Course as CourseModel  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserModel $user, CourseModel $course)
    {
        
        $userSharedService  = new UserSharedService();
        $allowedRoles       = [RoleModel::ADMIN, RoleModel::EDITOR];
        $hasAllowedRole     = $userSharedService->hasAnyRole($user, $allowedRoles);
        
        $isTeacher          = $userSharedService->hasRole($user, RoleModel::TEACHER);
        $isCourseAuthor     = $isTeacher ? $user->isCourseAuthor($course) : false;

        return ($hasAllowedRole || $isCourseAuthor);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Course as CourseModel  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserModel $user, CourseModel $course)
    {
        
        $userSharedService  = new UserSharedService();
        $allowedRoles       = [RoleModel::ADMIN, RoleModel::EDITOR];
        $hasAllowedRole     = $userSharedService->hasAnyRole($user, $allowedRoles);
        
        $isTeacher          = $userSharedService->hasRole($user, RoleModel::TEACHER);
        $isCourseAuthor     = $isTeacher ? $user->isCourseAuthor($course) : false;

        return ($hasAllowedRole || $isCourseAuthor);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Course as CourseModel  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UserModel $user, CourseModel $course)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Course as CourseModel  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(UserModel $user, CourseModel $course)
    {
        //
    }

        
    public function changeStatus(UserModel $user, CourseModel $course)
    {
        $userSharedService  = new UserSharedService();
        $allowedRoles       = [RoleModel::ADMIN, RoleModel::EDITOR];
        $hasAllowedRole     = $userSharedService->hasAnyRole($user, $allowedRoles);
        
        $isTeacher          = $userSharedService->hasRole($user, RoleModel::TEACHER);
        $isCourseAuthor     = $isTeacher ? $user->isCourseAuthor($course) : false;

        return ($hasAllowedRole || $isCourseAuthor);
    }
}
