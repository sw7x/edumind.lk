<?php

use App\Permissions\Abilities\AuthAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;
use Illuminate\Auth\Access\Response;


GateFacade::define(
	AuthAbilities::ACTIVATE, function(?UserModel $user) {
	
	return is_null($user) ? 
		Response::allow() : 
		Response::deny('You must log out before using the activation link. !'); 
});




GateFacade::define(
	AuthAbilities::CHANGE_PASSWORD, function(?UserModel $user) {
	
	return is_null($user) ? 
		Response::deny('You must first log in before changing your password. !') : 
		Response::allow(); 
});




GateFacade::define(
	AuthAbilities::RESET_PASSWORD_REQUEST, function(?UserModel $user) {
	
	return is_null($user) ? 
		Response::allow() : 
		Response::deny('Logout first, then request reset password !');
});


GateFacade::define(
	AuthAbilities::RESET_PASSWORD_CONFIRM, function(?UserModel $user) {
	
	return is_null($user) ? 
		Response::allow() : 
		Response::deny('Logout first, then submit reset password form !');
});




GateFacade::define(
	AuthAbilities::LOGIN, function(?UserModel $user) {
	
	return is_null($user) ?
		Response::allow() : 
		Response::deny('You already logged in !');
});

GateFacade::define(
	AuthAbilities::LOGOUT, function(?UserModel $user) {
	
	return is_null($user) ? 
		Response::deny('Log in before you log out. !') : 
		Response::allow(); 
});



GateFacade::define(
	AuthAbilities::STUDENT_REGISTER, function(?UserModel $user) {
	
	return is_null($user) ? 
		Response::allow() : 
		Response::deny('You already logged in !');
});

GateFacade::define(
	AuthAbilities::TEACHER_REGISTER, function(?UserModel $user) {
	
	return is_null($user) ? 
		Response::allow() : 
		Response::deny('You already logged in !');
});