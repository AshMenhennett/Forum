<?php

namespace App\Events;

use App\Post;
use App\Topic;
use Illuminate\Support\Collection;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UsersMentioned
{
    use InteractsWithSockets, SerializesModels;

    public $users;
    public $topic;
    public $post;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Collection $users, Topic $topic, Post $post)
    {
        $this->users = $users;
        $this->topic = $topic;
        $this->post = $post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
