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
use App\Repository\Event\EventRepository;
use App\Repository\Event\EventRepositoryInterface;
use App\Repository\Organizer\OrganizerRepository;
use App\Repository\Organizer\OrganizerRepositoryInterface;
use App\Repository\Permission\PermissionGroupRepository;
use App\Repository\Permission\PermissionGroupRepositoryInterface;
use App\Repository\Permission\PermissionRepository;
use App\Repository\Permission\PermissionRepositoryInterface;
use App\Repository\Role\RolePermissionRepository;
use App\Repository\Role\RolePermissionRepositoryInterface;
use App\Repository\Role\RoleRepositoryInterface;
use App\Repository\Score\ScoreRepository;
use App\Repository\Score\ScoreRepositoryInterface;
use App\Repository\Sponsor\SponsorRepository;
use App\Repository\Sponsor\SponsorRepositoryInterface;
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
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(OrganizerRepositoryInterface::class, OrganizerRepository::class);
        $this->app->bind(ScoreRepositoryInterface::class, ScoreRepository::class);
        $this->app->bind(SponsorRepositoryInterface::class, SponsorRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
