<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        # Menu Sidebar
        View::composer('back.parent.layout', function ($view) {
            $title = config('titles.' . Route::currentRouteName());

            $view->with(compact('title'));
        });

        # Conditionnel personnaliser
        # @request
        Blade::if('request', function ($url) {
            return request()->is($url);
        });
    }
}
