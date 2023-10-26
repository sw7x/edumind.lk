<?php

use App\Permissions\Abilities\ContactUsAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\ContactUs as ContactUsModel;
use App\Models\User as UserModel;
use App\Permissions\Policies\ContactUsPolicy;
use Illuminate\Auth\Access\Response;


//allow guest, admin not allow, other allow
GateFacade::define(
	ContactUsAbilities::VIEW_PAGE, function(?UserModel $user) {
	//dd($user->isAdmin());
	//dd($user);
	//return false;	
    //return true;

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




GateFacade::define(
	ContactUsAbilities::VIEW_ADMIN_PANEL_GUEST_MESSAGES, function(UserModel $user) {
	//dd($user);
	//return true;	

	return (new ContactUsPolicy)->viewAny($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view guest messages');
});

GateFacade::define(
	ContactUsAbilities::VIEW_ADMIN_PANEL_STUDENT_MESSAGES, function(UserModel $user) {
    
    //return (new ContactUsPolicy)->viewAny($user);
    return (new ContactUsPolicy)->viewAny($user)
                ? Response::allow()
                : Response::deny('You dont have Permissions to view student messages');

});

GateFacade::define(
	ContactUsAbilities::VIEW_ADMIN_PANEL_TEACHER_MESSAGES, function(UserModel $user) {
    
    return (new ContactUsPolicy)->viewAny($user)
                ? Response::allow()
                : Response::deny('You dont have Permissions to view teacher messages');
});

GateFacade::define(
	ContactUsAbilities::VIEW_ADMIN_PANEL_OTHER_USER_MESSAGES, function(UserModel $user) {

    return (new ContactUsPolicy)->viewAny($user)
                ? Response::allow()
                : Response::deny('You dont have Permissions to view other user messages');
});




	    


GateFacade::define(
	ContactUsAbilities::DELETE_MESSAGES, function(UserModel $user) {
	//ContactUsAbilities::DELETE_MESSAGES, function(UserModel $user, ContactUsModel $contactUs) {
	//return true;
	
	//return (new ContactUsPolicy)->delete($user);
	return (new ContactUsPolicy)->delete($user)
                ? Response::allow()
                : Response::deny('You dont have Permissions to delete messages');   
});



GateFacade::define(
	//ContactUsAbilities::TEST, function(?UserModel $user, ContactUsModel $rec, $isCheck) {
	ContactUsAbilities::TEST, function(?UserModel $user, $isCheck) {
	//ContactUsAbilities::TEST, function(UserModel $user, ContactUsModel $contactUs) {
	

	//dump($rec);
	dump($isCheck);
	dd();

	//return true;
	$response = ($isCheck === 999) ? Response::allow() : Response::deny('fff');
	return $response;
});