<?php

namespace App;

use App\User;
use App\Topic;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topic_id', 'user_id', 'subscibed',
    ];

    /**
     * Each Subscription belongs to a User.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Each Report belongs to a Topic.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

}
