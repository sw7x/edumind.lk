<?php

namespace App\Permissions\Policies;

use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
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
    public function viewAny(UserModel $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN || $userRole== RoleModel::EDITOR);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserModel $user, UserModel $model)
    {
        $currentUserRole   = $user->roles()->first()->slug;
        $givenUserRole     = $model->roles()->first() ? $model->roles()->first()->slug : null;

        if($currentUserRole == RoleModel::ADMIN){       
            return true;

        }elseif($currentUserRole == RoleModel::EDITOR){        
            return ($givenUserRole == RoleModel::TEACHER);

        }elseif($currentUserRole == RoleModel::TEACHER){        
            return false;

        }elseif($currentUserRole == RoleModel::STUDENT){        
            return false;

        }elseif($currentUserRole == RoleModel::MARKETER){        
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
    public function create(UserModel $user)
    {
        $userRole = $user->roles()->first()->slug;
        return ($userRole == RoleModel::ADMIN);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;
        return ($userRole == RoleModel::ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UserModel $user, UserModel $model)
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
    public function forceDelete(UserModel $user, UserModel $model)
    {
        //
    }


    
    public function createTeachers(UserModel $user)
    {
        $userRole = $user->roles()->first()->slug;
        return ($userRole == RoleModel::ADMIN);        
    }

    public function createStudents(UserModel $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }

    public function createEditors(UserModel $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }
    
    public function createMarketers(UserModel $user)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }





    
    public function updateTeachers(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }

    public function updateStudents(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }

    public function updateEditors(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }
    
    public function updateMarketers(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }

    


    public function changeUserStatus(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }



    /*
    public function viewTeachers(UserModel $user, UserModel $model)
    {
        $currentUserRole   = $user->roles()->first()->slug;
        $givenUserRole     = $model->roles()->first()->slug;
           
        return  ($currentUserRole == RoleModel::ADMIN) || 
                ($currentUserRole == RoleModel::EDITOR && $givenUserRole == RoleModel::TEACHER);        
    }

    public function viewStudents(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }

    public function viewEditors(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }
    
    public function viewMarketers(UserModel $user, UserModel $model)
    {
        $userRole = $user->roles()->first()->slug;   
        return ($userRole == RoleModel::ADMIN);        
    }
    */

    
}
