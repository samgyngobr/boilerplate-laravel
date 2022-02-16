<?php

namespace Samgyngobr\Scarlet;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ScarletServiceProvider extends ServiceProvider
{


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Samgyngobr\Scarlet\Controllers\AdminController');
        $this->app->make('Samgyngobr\Scarlet\Controllers\ConfigController');

        require_once(  __DIR__ . '/helpers.php' );
    }



    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'scarlet');


        // https://stackoverflow.com/questions/52197782/laravel-package-development-and-link-to-css-js-file
        // php artisan vendor:publish

        $this->publishes([
            //__DIR__.'/public' => public_path('vendor/bryanjack/dash'),
            __DIR__.'/views' => base_path('resources/views/samgyngobr/scarlet'),
            __DIR__.'/lang'  => base_path('resources/lang'),
        ]);


        View::composer('*', 'Samgyngobr\Scarlet\ViewComposers\ScarletViewComposer');

    }


}
