<?php

namespace App\Listeners;

use Mail;
use App\User;
use App\Events\PostReported;
use App\Mail\PostReported as PostReportedEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendModeratorsPostReportedEmail implements ShouldQueue
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
     * @param  PostReported  $event
     * @return void
     */
    public function handle(PostReported $event)
    {
        $moderators = User::where('role', 'moderator')->get();
        $user = $event->user;
        if (count($moderators)) {
            foreach ($moderators as $moderator) {
                if ($moderator->id !== $user->id) {
                    // only send email notification to moderator if they aren't the user who 'reported' the content
                    Mail::to($moderator)->queue(new PostReportedEmail($event->topic, $event->post));
                }
            }
        }
    }
}
