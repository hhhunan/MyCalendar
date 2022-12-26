<?php

namespace App\Providers;


use App\Contracts\Repositories\CalendarRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\CalendarRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;


/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register Services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(UserRepositoryInterface::class, function($app)
//        {
//            return new UserRepository(new User);
//        });

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            CalendarRepositoryInterface::class,
            CalendarRepository::class
        );
    }

    /**
     * Bootstrap Services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
