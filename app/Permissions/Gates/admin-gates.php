<?php
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;


GateFacade::define('is_admin_aaa', function(UserModel $user) {
    return $user->isAdmin();
});




GateFacade::define('edit-settings', function(UserModel $user) {
    return true;
});