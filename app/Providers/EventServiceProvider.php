<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserPostedOnTopic' => [
            'App\Listeners\SendTopicSubscribersPostEmail',
        ],
        'App\Events\UserSubscribedToTopic' => [
            'App\Listeners\SendTopicOwnerSubscriptionCreatedEmail',
        ],
        'App\Events\TopicReported' => [
            'App\Listeners\SendModeratorsTopicReportedEmail',
        ],
        'App\Events\PostReported' => [
            'App\Listeners\SendModeratorsPostReportedEmail',
        ],
        'App\Events\TopicDeleted' => [
            'App\Listeners\SendTopicOwnerTopicDeletedEmail',
        ],
        'App\Events\PostDeleted' => [
            'App\Listeners\SendPostOwnerPostDeletedEmail',
        ],
        'App\Events\UserRoleModified' => [
            'App\Listeners\SendUserRoleModifiedEmail',
        ],
        'App\Events\UsersMentioned' => [
            'App\Listeners\SendUsersMentionedEmail',
        ],
        'App\Events\UserHasViewedMessagesFromSender' => [
            'App\Listeners\UpdateReadFlagOnMessagesForGivenSender',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
