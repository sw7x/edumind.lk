<?php
use Illuminate\Support\Facades\Gate as GateFacade;
use App\Models\User as UserModel;


GateFacade::define('is_admin_aaa', function(UserModel $user) {
    return $user->isAdmin();
});




GateFacade::define('edit-settings', function(UserModel $user) {
    return true;
});




GateFacade::define('update-post', function ($user, $post, $additionalArgument) {
    // Check if the user has permission to update the post based on their role or any other criteria.
    // You can also use the $additionalArgument if needed.

    // Example check:
    if ($user->isAdmin() || $user->id === $post->user_id) {
        return true;
    }

    return false;
});


/*
if (Gate::allows('update-post', [$user, $post, $additionalArgument])) {
    // The user is authorized to update the post.
} else {
    // The user is not authorized to update the post.
}
*/