<?php

namespace App\Providers;

use Hash;
use App\Topic;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('no_spaces', function($attributes, $value, $parameters) {
            return !preg_match('/\s/', $value);
        });
        Validator::extend('hash', function($attributes, $value, $parameters) {
            return Hash::check($value, $parameters[0]);
        });
        Validator::extend('unique_slug_title', function($attributes, $value, $parameters) {
            // checks if slug'ified version of the title is unique, compared to existing slugs
            return ! Topic::where('slug', str_slug(mb_strimwidth($value, 0, 255), '-'))->first();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_ENV') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
