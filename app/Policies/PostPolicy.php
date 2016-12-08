<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit (User $user, Post $post)
    {
        return $user->id === $post->user_id || $user->isElevated();
    }

    public function update (User $user, Post $post)
    {
        return $user->id === $post->user_id || $user->isElevated();
    }

    public function delete (User $user, Post $post)
    {
        return $user->id === $post->user_id || $user->isElevated();
    }
}
