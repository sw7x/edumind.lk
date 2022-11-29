<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return ($userRole == Role::ADMIN || $userRole== Role::EDITOR);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        return true;
        $currentUserRole   = $user->roles()->first()->slug;
        $givenUserRole     = $model->roles()->first()->slug;

        if($currentUserRole == Role::ADMIN){       
            return true;

        }elseif($currentUserRole == Role::EDITOR){        
            return ($givenUserRole == Role::TEACHER);

        }elseif($currentUserRole == Role::TEACHER){        
            return false;

        }elseif($currentUserRole == Role::STUDENT){        
            return false;

        }elseif($currentUserRole == Role::MARKETER){        
            return false;

        }else{
            return false;

        }
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
        return ($userRole == Role::ADMIN);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        $userRole = $user->roles()->first()->slug;
        return ($userRole == Role::ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }


    
    public function createTeachers(User $user)
    {
        $userRole = $user->roles()->first()->slug;
        return ($userRole == Role::ADMIN);        
    }

    public function createStudents(User $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }

    public function createEditors(User $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }
    
    public function createMarketers(User $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }





    
    public function updateTeachers(User $user, User $model)
    {
        return false;$userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }

    public function updateStudents(User $user, User $model)
    {
        return false;$userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }

    public function updateEditors(User $user, User $model)
    {
        return false;$userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }
    
    public function updateMarketers(User $user, User $model)
    {
        return false;$userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }

    


    public function changeUserStatus(User $user, User $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }



    /*
    public function viewTeachers(User $user, User $model)
    {
        $currentUserRole   = $user->roles()->first()->slug;
        $givenUserRole     = $model->roles()->first()->slug;
           
        return  ($currentUserRole == Role::ADMIN) || 
                ($currentUserRole == Role::EDITOR && $givenUserRole == Role::TEACHER);        
    }

    public function viewStudents(User $user, User $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }

    public function viewEditors(User $user, User $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }
    
    public function viewMarketers(User $user, User $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == Role::ADMIN);        
    }
    */

    
}
