<?php

namespace App\Providers;

use App\Ports\ICompetitionRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;
use App\Ports\IRepository;
use App\Ports\IUserRepository;
use App\Repositories\CompetitionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IRepository::class, BaseRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(ICompetitionRepository::class, CompetitionRepository::class);
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
