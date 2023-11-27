<?php

use App\Permissions\Abilities\ContactUsAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;
use App\Permissions\Policies\ContactUsPolicy;
use Illuminate\Auth\Access\Response;


//allow guest, admin not allow, other allow
GateFacade::define(
	ContactUsAbilities::VIEW_PAGE, function(?UserModel $user) {
	//dd($user->isAdmin());
	//dd($user);
	//return false;	
	

    //return !($user->isAdmin());
	return (!optional($user)->isAdmin()) ? 
			Response::allow() : 
			Response::deny('Contact page has nothing to do with your user role.');

});

GateFacade::define(
	ContactUsAbilities::SUBMIT_FORM, function(?UserModel $user) {
    //return true;    
    //return !$user->isAdmin();	

    return (new ContactUsPolicy)->create($user) ? 
			Response::allow() : 
			Response::deny('Contact form submission is nothing to do with your user role.');
});


