<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\EloquentRepositoryInterface;
use App\Interfaces\UsersRepositoryInterface;

use App\Repositories\BaseRepository;
use App\Repositories\UsersRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( EloquentRepositoryInterface::class , BaseRepository::class  );
        $this->app->bind( UsersRepositoryInterface::class    , UsersRepository::class );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
