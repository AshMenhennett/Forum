<?php

namespace App\Listeners;

use Mail;
use App\Events\UsersMentioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\UserMentioned as UserMentionedEmail;

class SendUsersMentionedEmail
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
     * @param  UsersMentioned  $event
     * @return void
     */
    public function handle(UsersMentioned $event)
    {
        $users = $event->users->unique();
        if (count($users)) {
            foreach ($users as $user) {
                Mail::to($user)->queue(new UserMentionedEmail($event->topic, $event->post));
            }
        }
    }
}
