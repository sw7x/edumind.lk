<?php

use App\Permissions\Abilities\PayingAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use Illuminate\Auth\Access\Response;
use App\Models\User as UserModel;

/*
use App\Common\SharedServices\UserSharedService;
*/

GateFacade::define(
	PayingAbilities::PAY_SALARY, function(?UserModel $user) {
	
	/*return (new UserPolicy)->viewAny($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view user list in admin panel !');*/	                   
});

GateFacade::define(
	PayingAbilities::VIEW_SALARY_SLIP, function(?UserModel $user) {

});

GateFacade::define(
	PayingAbilities::PAY_COMMISSION, function(?UserModel $user) {

});

GateFacade::define(
	PayingAbilities::VIEW_COMMISSION_SLIP, function(?UserModel $user) {

});