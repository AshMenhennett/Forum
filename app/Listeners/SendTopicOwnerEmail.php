<?php

namespace App\Listeners;

use Mail;
use Log;
use App\Mail\UserSubscribedToTopic as UserSubscribedToTopicEmail;
use App\Events\UserSubscribedToTopic;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTopicOwnerEmail
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
     * @param  UserSubscribedToTopic  $event
     * @return void
     */
    public function handle(UserSubscribedToTopic $event)
    {
        Mail::to($event->topic->user()->get())->queue(new UserSubscribedToTopicEmail($event->topic));
    }
}
