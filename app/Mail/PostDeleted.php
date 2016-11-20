<?php

namespace App\Mail;

use App\Topic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public $topic;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.postDeleted', [
            'post' => $this->post,
        ]);
    }
}
