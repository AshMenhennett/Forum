<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class GetMentionedUsersServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('GetMentionedUsers', function() {
            return GetMentionedUsers::class;
        });
    }
}
