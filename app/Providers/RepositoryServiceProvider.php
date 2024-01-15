<?php

namespace App\Providers;

use App\Repository\Base\BaseRepository;
use App\Repository\Role\RoleRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\Base\BaseRepositoryInterface;
use App\Repository\Candidate\CandidateRepository;
use App\Repository\Candidate\CandidateRepositoryInterface;
use App\Repository\Category\CategoryRepository;
use App\Repository\Category\CategoryRepositoryInterface;
use App\Repository\Permission\PermissionGroupRepository;
use App\Repository\Permission\PermissionGroupRepositoryInterface;
use App\Repository\Permission\PermissionRepository;
use App\Repository\Permission\PermissionRepositoryInterface;
use App\Repository\Role\RolePermissionRepository;
use App\Repository\Role\RolePermissionRepositoryInterface;
use App\Repository\Role\RoleRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(PermissionGroupRepositoryInterface::class, PermissionGroupRepository::class);
        $this->app->bind(RolePermissionRepositoryInterface::class, RolePermissionRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CandidateRepositoryInterface::class, CandidateRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
