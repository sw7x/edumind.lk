<?php

namespace App\Permissions\Policies;

use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Common\SharedServices\UserSharedService;
        

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
        $allowedRoles = [RoleModel::ADMIN, RoleModel::EDITOR];
        return (new UserSharedService)->hasAnyRole($user, $allowedRoles);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserModel $user, UserModel $givenUserModel)
    {
        $userSharedService  = new UserSharedService();
                
        $isAdmin            = $userSharedService->hasRole($user, RoleModel::ADMIN);        
        $isEditor           = $userSharedService->hasRole($user, RoleModel::EDITOR);

        $isGivenTeacher     = $userSharedService->hasRole($givenUserModel, RoleModel::TEACHER);

        return ($isAdmin || ($isEditor && $isGivenTeacher));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);
        //return (new UserSharedService)->hasAnyRole($user, [RoleModel::TEACHER,RoleModel::EDITOR]);

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);
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


    public function viewTeachers(UserModel $user)
    {
        return (new UserSharedService)->hasAnyRole($user, [RoleModel::ADMIN, RoleModel::EDITOR]);        
    }

    public function viewStudents(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);        
    }

    public function viewEditors(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);       
    }
    
    public function viewMarketers(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);        
    }    


    public function createTeachers(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);        
    }

    public function createStudents(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);        
    }

    public function createEditors(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);       
    }
    
    public function createMarketers(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);        
    }


    public function updateTeachers(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN); 
    }

    public function updateStudents(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);        
    }

    public function updateEditors(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);        
    }
    
    public function updateMarketers(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);        
    }


    public function changeUserStatus(UserModel $user)
    {
        return (new UserSharedService)->hasRole($user, RoleModel::ADMIN);
    }
    
}