<?php
namespace App\Permissions;

class PermissionDeniedMessageEnum {
    
    const NO_AUTH_MSG       = 'The page you are trying to access is inaccessible to unauthenticated users.';
    const INVALID_ROLE_MSG  = 'The page you are trying to access is inaccessible because your user role is not valid.';
    const FORBIDDEN_MSG   = 'The page you are trying to access is inaccessible because you dont have permissions.';
    

}