<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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
        \View::composer('includes/admin/sidebar', function ($view) {

            $areas = DB::table('sk_area')->where('status', 1)->get();
            $view->with([ 'areas' => $areas ]);
        });

    }
}
