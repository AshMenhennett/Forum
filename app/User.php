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

    /**
     * Attribute that User is identifiable by.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Each User has many topics.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /**
     * Each User has many posts, through a Topic.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function posts()
    {
        return $this->hasManyThrough(Post::class, Topic::class);
    }

    /**
     * Each User has many reports.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Returns whether a user's avatar field is populated.
     *
     * @return boolean
     */
    public function hasCustomAvatar()
    {
        if ($this->avatar !== null) {
            return true;
        }

        return false;
    }

    /**
     * Returns whether a user has a role of 'moderator'
     *
     * @return boolean
     */
    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    /**
     * Returns whether a user has a role of 'admin'
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Returns whether a user has a role of 'moderator' or 'admin'
     *
     * @return boolean
     */
    public function isElevated()
    {
        return $this->role === 'moderator' || $this->role === 'admin';
    }

    /**
     * Returns a user's role
     *
     * @return string
     */
    public function role()
    {
        return $this->role;
    }

    /**
     * Each User has many subscriptions.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Returns a Collection of subscriptions that a User has
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    protected function getUserSubscriptions()
    {
        return Subscription::where('user_id', $this->id)->get();
    }

    /**
     * Returns whether a user is subscribed to a Topic.
     *
     * @return mixed App\Subscription | boolean
     */
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
