<?php

namespace App\Permissions\Policies;

use App\Models\Course as CourseModel;
use App\Models\User as UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Role as RoleModel;

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
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER, RoleModel::MARKETER]);
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
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER, RoleModel::MARKETER]);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User as UserModel  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(UserModel $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER]);
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
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]) || 
                ($userRole == RoleModel::TEACHER && $user->isCourseAuthor($course));
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
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]) || 
                ($userRole == RoleModel::TEACHER && $user->isCourseAuthor($course));
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

    public function watch(UserModel $user, CourseModel $course)
    {
        /*

        $userRole = $user->roles()->first()->slug;
        if(in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]))

        if($userRole == RoleModel::TEACHER)    
        if user student and student enrolled 
        

        if($userRole == RoleModel::TEACHER)    
    
        if user teacher and teacher owned 

        admin/editor
        */


        $userRole = $user->roles()->first()->slug;   
        return  
            in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]) || 
            ($userRole == RoleModel::TEACHER && $user->isCourseAuthor($course));
            ($userRole == RoleModel::STUDENT && $user->isCourseAuthor($course));





        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER, RoleModel::MARKETER]);
    }

    
    public function changeStatus(UserModel $user, CourseModel $course)
    {
        $userRole = $user->roles()->first()->slug;
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]) || 
                ($userRole == RoleModel::TEACHER && $user->isCourseAuthor($course));        
    }
}
