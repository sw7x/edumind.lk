<?php
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;


GateFacade::define('is_admin_ddd', function(UserModel $user) {
    return $user->isAdmin();
});