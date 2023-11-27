<?php

use App\Permissions\Abilities\CouponAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use Illuminate\Auth\Access\Response;
use App\Models\User as UserModel;






GateFacade::define(
	CouponAbilities::CREATE_COUPONS, function(?UserModel $user) {

});



GateFacade::define(
	CouponAbilities::VIEW_MARKETER_COUPON_LIST, function(?UserModel $user) {

});

GateFacade::define(
	CouponAbilities::VIEW_MARKETER_COUPON, function(?UserModel $user) {

});
GateFacade::define(
	CouponAbilities::DELETE_MARKETER_COUPON, function(?UserModel $user) {

});

GateFacade::define(
	CouponAbilities::CHANGE_MARKETER_COUPON_STATUS, function(?UserModel $user) {

});




GateFacade::define(
	CouponAbilities::VIEW_TEACHER_COUPON_LIST, function(?UserModel $user) {

});

GateFacade::define(
	CouponAbilities::VIEW_TEACHER_COUPON, function(?UserModel $user) {

});
GateFacade::define(
	CouponAbilities::DELETE_TEACHER_COUPON, function(?UserModel $user) {

});

GateFacade::define(
	CouponAbilities::CHANGE_TEACHER_COUPON_STATUS, function(?UserModel $user) {

});




GateFacade::define(
	CouponAbilities::ADMIN_PANEL_VIEW_COUPON, function(?UserModel $user) {

});

GateFacade::define(
	CouponAbilities::ADMIN_PANEL_VIEW_COUPON_USAGE_SECTION, function(?UserModel $user) {

});




GateFacade::define(
	CouponAbilities::ADMIN_PANEL_VIEW_NEW_COUPONS, function(?UserModel $user) {

});

GateFacade::define(
	CouponAbilities::ADMIN_PANEL_VIEW_USED_COUPONS, function(?UserModel $user) {

});









/*
GateFacade::define(
	CouponAbilities::PAY_SALARY, function(?UserModel $user) {
	
	return (new UserPolicy)->viewAny($user) ? 
		Response::allow() : 
		Response::deny('You dont have Permissions to view user list in admin panel !');                   
});
*/