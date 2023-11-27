<?php

use App\Permissions\Abilities\RevenueAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use Illuminate\Auth\Access\Response;
use App\Models\User as UserModel;

//use App\Common\SharedServices\UserSharedService;


GateFacade::define(
	RevenueAbilities::VIEW_CHECKOUTS, function(?UserModel $user) {
	
	/*return (new UserPolicy)->viewAny($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view user list in admin panel !');*/	                   
});

GateFacade::define(
	RevenueAbilities::VIEW_EARNINGS, function(?UserModel $user) {

});

GateFacade::define(
	RevenueAbilities::VIEW_COURSE_EARNINGS, function(?UserModel $user) {

});

GateFacade::define(
	RevenueAbilities::VIEW_TEACHER_EARNINGS, function(?UserModel $user) {

});