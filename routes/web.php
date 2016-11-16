<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// remove email from check of reg code

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// authorization
// cond. showing of user specific functions
// mod and admin controls and access
// markdown parser
// auto link to @username

Route::group(['middleware' => ['log.activity']], function() {

    Route::get('/user/profile/@{user}', 'ProfileController@index')->name('user.profile.index');

    // auth routing
    Route::group(['middleware' => ['auth']], function () {
        //general user routing
        Route::get('/home', 'HomeController@index')->name('home.index');

        Route::group(['prefix' => 'forum'], function() {
            // auth forum routes
            Route::get('/topics/create', 'TopicsController@showCreateForm')->name('forum.topics.create.form');
            Route::post('/topics/create', 'TopicsController@create')->name('forum.topics.create.submit');

            Route::post('/topics/{topic}/posts/create', 'PostsController@create')->name('forum.topics.posts.create.submit');

            Route::get('/topics/{topic}/subscription/status', 'SubscriptionsController@getSubscriptionStatus')->name('forum.topics.topic.subscription.status');
            Route::post('/topics/{topic}/subscription', 'SubscriptionsController@handleSubscription')->name('forum.topics.topic.subscription.submit');
        });

        Route::group(['prefix' => 'user'], function() {
            Route::get('/settings', 'SettingsController@index')->name('user.settings.index');
            Route::post('/settings/update/', 'SettingsController@update')->name('user.settings.update');
        });

        // admin routing
        Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin']], function () {
            Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard.index');
            Route::post('/dashboard/update', 'DashboardController@update')->name('admin.dashboard.update');
            Route::post('/dashboard/invite', 'DashboardController@invite')->name('admin.dashboard.invite');

            Route::get('/dashboard/users/index', 'DashboardController@fetchUsers')->name('admin.dashboard.user.index');
            Route::delete('/dashboard/users/{user}', 'DashboardController@destroy')->name('admin.dashboard.user.destroy');
        });

    });

    Route::group(['prefix' => 'forum'], function() {
        // public forum routes
        Route::get('/', 'TopicsController@index')->name('forum.topics.index');
        Route::get('/topics/{topic}', 'TopicsController@show')->name('forum.topics.topic.show');
    });

});
