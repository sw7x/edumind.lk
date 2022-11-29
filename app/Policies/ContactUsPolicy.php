<?php

namespace App\Policies;

use App\Models\Contact_us;
use App\Models\User;
use Sentinel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactUsPolicy
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
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contact_us  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Contact_us $contactUs)
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        //dd('create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contact_us  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Contact_us $contactUs)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contact_us  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Contact_us $contactUs)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contact_us  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Contact_us $contactUs)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contact_us  $contactUs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Contact_us $contactUs)
    {
        //
    }
}
