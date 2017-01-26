<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Mass assignable fields.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'recipient_id', 'read', 'content',
    ];

    /**
     * A Message belongs to a User (sender).
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender ()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    /**
     * A Message belongs to a User (recipient).
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient ()
    {
        return $this->belongsTo(User::class, 'recipient_id', 'id');
    }

    /**
     * Returns whether a message has been read by a recipient
     *
     * @return boolean
     */
    public function read ()
    {
        return $this->read();
    }

}
