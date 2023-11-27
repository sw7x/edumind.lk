<?php

use App\Permissions\Abilities\ContactUsAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\ContactUs as ContactUsModel;
use App\Models\User as UserModel;
use App\Permissions\Policies\ContactUsPolicy;
use Illuminate\Auth\Access\Response;


GateFacade::define(
	ContactUsAbilities::VIEW_GUEST_MESSAGES, function(UserModel $user) {
	//dd($user);
	//return true;	

	return (new ContactUsPolicy)->viewAny($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view guest messages');
});

GateFacade::define(
	ContactUsAbilities::VIEW_STUDENT_MESSAGES, function(UserModel $user) {
    
    //return (new ContactUsPolicy)->viewAny($user);
    return (new ContactUsPolicy)->viewAny($user)
                ? Response::allow()
                : Response::deny('You dont have Permissions to view student messages');

});

GateFacade::define(
	ContactUsAbilities::VIEW_TEACHER_MESSAGES, function(UserModel $user) {
    
    return (new ContactUsPolicy)->viewAny($user)
                ? Response::allow()
                : Response::deny('You dont have Permissions to view teacher messages');
});

GateFacade::define(
	ContactUsAbilities::VIEW_OTHER_USER_MESSAGES, function(UserModel $user) {

    return (new ContactUsPolicy)->viewAny($user)
                ? Response::allow()
                : Response::deny('You dont have Permissions to view other user messages');
});




	    


GateFacade::define(
	ContactUsAbilities::DELETE_CONTACT_MESSAGES, function(UserModel $user) {
	//ContactUsAbilities::DELETE_CONTACT_MESSAGES, function(UserModel $user, ContactUsModel $contactUs) {
	//return true;
	
	//return (new ContactUsPolicy)->delete($user);
	return (new ContactUsPolicy)->delete($user)
                ? Response::allow()
                : Response::deny('You dont have Permissions to delete messages');   
});

