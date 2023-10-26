<?php

use App\Permissions\Abilities\CartAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
use Illuminate\Auth\Access\Response;
use App\Common\SharedServices\UserSharedService;









GateFacade::define(
	CartAbilities::VIEW_CART, function(UserModel $user) {
	return (new UserSharedService)->hasRole($user, RoleModel::STUDENT) ? 
		Response::allow() : 
		Response::deny('Only students were allowed to view cart'); 
});




GateFacade::define(
	CartAbilities::CHECKOUT, function(UserModel $user) {
	
	return (new UserSharedService)->hasRole($user, RoleModel::STUDENT) ? 
		Response::allow() : 
		Response::deny('Only students were allowed to checkout cart'); 
});




GateFacade::define(
	CartAbilities::ADD_TO_CART, function(UserModel $user) {
	
	return (new UserSharedService)->hasRole($user, RoleModel::STUDENT) ? 
		Response::allow() : 
		Response::deny('Only students were allowed to add courses to cart');
});

GateFacade::define(
	CartAbilities::REMOVE_FROM_CART, function(UserModel $user) {
	
	return (new UserSharedService)->hasRole($user, RoleModel::STUDENT) ? 
		Response::allow() : 
		Response::deny('Only students were allowed to remove courses from cart');
});




GateFacade::define(
	CartAbilities::REMOVE_COUPON, function(UserModel $user) {
	
	return (new UserSharedService)->hasRole($user, RoleModel::STUDENT) ? 
		Response::allow() : 
		Response::deny('Only students were allowed to remove coupons from his/her cart');
});

GateFacade::define(
	CartAbilities::APPLY_COUPON, function(UserModel $user) {
	
	return (new UserSharedService)->hasRole($user, RoleModel::STUDENT) ? 
		Response::allow() : 
		Response::deny('Only students were allowed to apply coupons to his/her cart');
});