<?php

use App\Permissions\Abilities\SettingsAbilities;
use Illuminate\Support\Facades\Gate as GateFacade;
use Illuminate\Auth\Access\Response;
use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
use App\Common\SharedServices\UserSharedService;


GateFacade::define(
	SettingsAbilities::VIEW_GENERAL_SETTINGS, function(?UserModel $user) {
	
	$response   =   (new UserSharedService)->hasRole($user, RoleModel::ADMIN) ? 
	                    Response::allow() : 
	                    Response::deny('You dont have Permissions to view general settings in admin panel !'); 
    return  $response;      	
});

GateFacade::define(
	SettingsAbilities::VIEW_ADVANCED_SETTINGS, function(?UserModel $user) {
	
	$response   =   (new UserSharedService)->hasRole($user, RoleModel::ADMIN) ? 
                        Response::allow() : 
                        Response::deny('You dont have Permissions to view advanced settings in admin panel !'); 
    return  $response;
});

GateFacade::define(
	SettingsAbilities::UPDATE_GENERAL_SETTINGS, function(?UserModel $user) {
	
	$response   =   (new UserSharedService)->hasRole($user, RoleModel::ADMIN) ? 
                        Response::allow() : 
                        Response::deny('You dont have Permissions to update general settings in admin panel !'); 
    return  $response;
});

GateFacade::define(
	SettingsAbilities::UPDATE_ADVANCED_SETTINGS, function(?UserModel $user) {
	
	$response   =   (new UserSharedService)->hasRole($user, RoleModel::ADMIN) ? 
	                    Response::allow() : 
	                    Response::deny('You dont have Permissions to update advanced settings in admin panel !'); 
    return  $response;
});

