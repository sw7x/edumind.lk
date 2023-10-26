<?php

namespace App\Permissions\Policies;

use App\Models\Subject as SubjectModel;
use App\Models\User as UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Role as RoleModel;
use Illuminate\Auth\Access\Response;


use App\Exceptions\InvalidUserTypeException;
use App\Common\SharedServices\UserSharedService;
use Illuminate\Auth\Access\AuthorizationException;




use Illuminate\Auth\AuthenticationException;//401 Unauthorized:
use Illuminate\Database\Eloquent\ModelNotFoundException;//404 Not Found:
use Illuminate\Database\QueryException;//500 Internal Server Error:
use Illuminate\Session\TokenMismatchException;//419 Forbidden:




class SubjectPolicy
{
    use HandlesAuthorization;

    
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
     * @param  \App\Models\Subject as SubjectModel  $subject
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserModel $user, SubjectModel $subject)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User as UserModel  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(?UserModel $user)
    {
        $allowedRoles = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::TEACHER];
        return (new UserSharedService)->hasAnyRole($user, $allowedRoles);
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
        $userSharedService  = new UserSharedService();

        $hasAllowedRoles    = $userSharedService->hasAnyRole($user, [RoleModel::ADMIN, RoleModel::EDITOR]);
        
        $isSubjectCreator   = $userSharedService->hasRole($user, RoleModel::TEACHER) && $user->isSubjectCreator($subject);

        return ($hasAllowedRoles || $isSubjectCreator);

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
        $userSharedService  = new UserSharedService();

        $allowedRoles       = [RoleModel::ADMIN, RoleModel::EDITOR];
        $hasAllowedRoles    = $userSharedService->hasAnyRole($user, $allowedRoles);

        $isSubjectCreator   = $userSharedService->hasRole($user, RoleModel::TEACHER) && $user->isSubjectCreator($subject);

        return ($hasAllowedRoles || $isSubjectCreator);
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


    
    public function viewSingleInSiteFrontend(UserModel $user, SubjectModel $subject)
    {       
        // return Response::allow();
        // return Response::deny('You do not own this post.');
        // return $this->deny('Sorry, your level is not high enough to do that!');
        // return $this->allow('Sorry, your level is not high enough to do that!');
        return true;

        //throw new AuthorizationException('You are not authorized to update this post.');
        //--throw new AuthenticationException('You are not authorized to update this post.');
        //throw new ModelNotFoundException('You are not authorized to update this post.');
        //throw new QueryException('You are not authorized to update this post.');
        //throw new TokenMismatchException('You are not authorized to update this post.');
    }
    
}