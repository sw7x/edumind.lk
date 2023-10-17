<?php

namespace App\Permissions\Policies;

use App\Models\ContactUs as ContactUsModel;
use App\Models\User as UserModel;
use Sentinel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactUsPolicy
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
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\ContactUs as ContactUsModel  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UserModel $user, ContactUsModel $contactUs)
    {
        
        //dd($user);
        //dump($user->isAdmin());
        //$userRole = $user->roles()->first()->slug;
        //dump($userRole);


        //dump($contactUs);
        //dump($user);
        //dd('view');
        //die('ssssssssssssssssss');

        //dd('666666666');
        //return true;
        //return false;
    }

    
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User as UserModel  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(UserModel $user)
    {
        return !$user->isAdmin();

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\ContactUs as ContactUsModel  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UserModel $user, ContactUsModel $contactUs)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\ContactUs as ContactUsModel  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UserModel $user, ContactUsModel $contactUs)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\ContactUs as ContactUsModel  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UserModel $user, ContactUsModel $contactUs)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User as UserModel  $user
     * @param  \App\Models\ContactUs as ContactUsModel  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(UserModel $user, ContactUsModel $contactUs)
    {
        //
    }



}
