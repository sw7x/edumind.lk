<?php
namespace App\Permissions;

class PermissionCheckResultEnum {
    
    const NO_AUTH       = 'no_auth';
    const INVALID_ROLE  = 'invalid_role';    
    const FORBIDDEN     = 'forbidden';
    const SUCCESS       = 'success';
}