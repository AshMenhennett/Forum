<?php

namespace App;

use Config;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'avatar', 'role', 'password', 'last_activity',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, Topic::class);
    }

    public function hasCustomAvatar()
    {
        if ($this->avatar !== null) {
            return true;
        }

        return false;
    }

    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isElevated()
    {
        return $this->role === 'moderator' || $this->role === 'admin';
    }

    public function role()
    {
        return $this->role;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    protected function getUserSubscriptions()
    {
        return Subscription::where('user_id', $this->id)->get();
    }

    public function isSubscribedTo(Topic $topic)
    {

        // loop through all subscriptions for current user
        foreach ($this->getUserSubscriptions() as $subscription) {
            if ($subscription->topic_id === $topic->id) {
                // has a certain subscription, let's return it
                return $subscription;
            }
        }

        // no subscriptions at all..
        return null;
    }

}
