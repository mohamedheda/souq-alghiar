<?php

namespace App\Providers;

use App\Repository\CategoryRepositoryInterface;
use App\Repository\CityRepositoryInterface;
use App\Repository\Eloquent\CategoryRepository;
use App\Repository\Eloquent\CityRepository;
use App\Repository\Eloquent\InfoRepository;
use App\Repository\Eloquent\ManagerRepository;
use App\Repository\Eloquent\MarkRepository;
use App\Repository\Eloquent\ModelRepository;
use App\Repository\Eloquent\OtpRepository;
use App\Repository\Eloquent\PermissionRepository;
use App\Repository\Eloquent\ProductImageRepository;
use App\Repository\Eloquent\ProductMakesRepository;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\Repository;
use App\Repository\Eloquent\RoleRepository;
use App\Repository\Eloquent\SettingsRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\InfoRepositoryInterface;
use App\Repository\ManagerRepositoryInterface;
use App\Repository\MarkRepositoryInterface;
use App\Repository\ModelRepositoryInterface;
use App\Repository\OtpRepositoryInterface;
use App\Repository\PermissionRepositoryInterface;
use App\Repository\ProductImageRepositoryInterface;
use App\Repository\ProductMakesRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\RepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\SettingsRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RepositoryInterface::class, Repository::class);
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SettingsRepositoryInterface::class , SettingsRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->singleton(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->singleton(ManagerRepositoryInterface::class, ManagerRepository::class);
        $this->app->singleton(OtpRepositoryInterface::class, OtpRepository::class);
        $this->app->singleton(InfoRepositoryInterface::class, InfoRepository::class);
        $this->app->singleton(CityRepositoryInterface::class, CityRepository::class);
        $this->app->singleton(MarkRepositoryInterface::class, MarkRepository::class);
        $this->app->singleton(ModelRepositoryInterface::class, ModelRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->singleton(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->singleton(ProductMakesRepositoryInterface::class, ProductMakesRepository::class);
        $this->app->singleton(ProductImageRepositoryInterface::class, ProductImageRepository::class);
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
