<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    // update permission
    public function update(User $user, Post $post) {

        return $user->id == $post->user_id;
    }

    // modify permission
    public function delete(User $user, Post $post) {
        return $user->id == $post->user_id;
    }
}
