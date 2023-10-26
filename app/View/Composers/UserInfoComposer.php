<?php
namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Role as RoleModel;
use Sentinel;
use App\Common\SharedServices\UserSharedService;
    use App\Permissions\Abilities\AdminPanelAbilities;


class UserInfoComposer
{
    public function compose(View $view)
    {
        try {

            $user     = Sentinel::getUser();
            $userRole = (new UserSharedService)->getRoleByUser($user);

        } catch (\Exception $e) {
            $user     = null;
            $userRole = null;
        }

        $view->with([
            'currentUser'       => $user,
            'currentUserRole'   => $userRole
        ]);      


    }

}


