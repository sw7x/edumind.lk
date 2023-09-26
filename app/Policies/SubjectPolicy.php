<?php

namespace App\Policies;

use App\Models\Subject as SubjectModel;
use App\Models\User as UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Role as RoleModel;


class SubjectPolicy
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
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER]);
        //return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Subject as SubjectModel  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserModel $user, SubjectModel $subject)
    {
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER]);
        //return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]);
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
        //return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Subject as SubjectModel  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserModel $user, SubjectModel $subject)
    {
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]) || 
                ($userRole == RoleModel::TEACHER && $user->isSubjectCreator($subject));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Subject as SubjectModel  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserModel $user, SubjectModel $subject)
    {
        $userRole = $user->roles()->first()->slug;   
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR]) || 
                ($userRole == RoleModel::TEACHER && $user->isSubjectCreator($subject));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Subject as SubjectModel  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UserModel $user, SubjectModel $subject)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\Subject as SubjectModel  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(UserModel $user, SubjectModel $subject)
    {
        //
    }



    public function viewAllInSiteFrontend(UserModel $user)
    {
        return true;
    }

    
    public function viewSingleInSiteFrontend(UserModel $user, SubjectModel $subject)
    {
        return true;
    }


    public function test(UserModel $user){
        dd("ggggg");
    }





}