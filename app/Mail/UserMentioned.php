<?php

namespace App\Mail;

use App\Post;
use App\Topic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMentioned extends Mailable
{
    use Queueable, SerializesModels;

    public $topic;
    public $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Topic $topic, Post $post)
    {
        $this->topic = $topic;
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.userMentioned', [
            'topic' => $this->topic,
            'post' => $this->post,
        ]);
    }
}
