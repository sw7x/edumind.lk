<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Role;


class SubjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [Role::ADMIN, Role::EDITOR, Role::TEACHER]);
        //return in_array($userRole, [Role::ADMIN, Role::EDITOR]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Subject $subject)
    {
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [Role::ADMIN, Role::EDITOR, Role::TEACHER]);
        //return in_array($userRole, [Role::ADMIN, Role::EDITOR]);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [Role::ADMIN, Role::EDITOR, Role::TEACHER]);
        //return in_array($userRole, [Role::ADMIN, Role::EDITOR]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Subject $subject)
    {
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [Role::ADMIN, Role::EDITOR]) || 
                ($userRole == Role::TEACHER && $user->isSubjectCreator($subject));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Subject $subject)
    {
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [Role::ADMIN, Role::EDITOR]) || 
                ($userRole == Role::TEACHER && $user->isSubjectCreator($subject));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Subject $subject)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Subject $subject)
    {
        //
    }



    public function viewAllInSiteFrontend(User $user)
    {
        return true;
    }

    
    public function viewSingleInSiteFrontend(User $user, Subject $subject)
    {
        return true;
    }


    public function test(User $user){
        dd("ggggg");
    }





}