<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = 'backend';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            $this->permanentRedirect('/', self::HOME);

            Route::prefix(self::HOME)
                ->group(function () {
                    Route::middleware('api')
                        ->prefix('api')
                        ->group(base_path('routes/api.php'));

                    Route::middleware('web')
                        ->group(base_path('routes/web.php'));

                    Route::middleware('api')
                        ->namespace($this->namespace)
                        ->prefix('/api/v1')
                        ->group(base_path('routes/auth/auth.php'));

                    Route::group([
                        'middleware' => ['api', 'auth:sanctum'],
                        'namespace' => $this->namespace,
                        'prefix' => '/api/v1'
                    ], function ($router) {
                        $routes = glob(base_path('routes/*/*.php'));
                        foreach ($routes as $route) {
                            $folder = basename(dirname($route));
                            if ($folder !== 'auth') {
                                require $route;
                            }
                        }
                    });
                });
        });
    }
}
