<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;

class AutoLinkUsernameServiceProvider extends ServiceProvider
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
        App::bind('AutoLinkUsername', function() {
            return AutoLinkUsername::class;
        });
    }
}
