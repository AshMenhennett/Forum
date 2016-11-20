<?php

namespace App\Listeners;

use Mail;
use App\Events\PostDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\PostDeleted as PostDeletedEmail;

class SendPostOwnerPostDeletedEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostDeleted  $event
     * @return void
     */
    public function handle(PostDeleted $event)
    {
        Mail::to($post->user->email)->queue(new PostDeletedEmail($post));
    }
}
