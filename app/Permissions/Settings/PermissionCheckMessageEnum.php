<?php
namespace App\Permissions\Settings;

class PermissionCheckMessageEnum {
    
    const NO_AUTH_MSG       = 'The page you are trying to access is inaccessible to unauthenticated users.';
    const INVALID_ROLE_MSG  = 'The page you are trying to access is inaccessible because your user role is not valid.';
    const FORBIDDEN_MSG     = 'The page you are trying to access is inaccessible because you dont have permissions.';
    const SUCCESS_MSG       = 'Permission granted. You have the necessary privileges to access this resource.';
    

}