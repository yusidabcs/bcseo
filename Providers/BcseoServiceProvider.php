<?php

namespace Modules\Bcseo\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;

class BcseoServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    public function boot()
    {
        $this->publishConfig('bcseo', 'permissions');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Bcseo\Repositories\SeoRepository',
            function () {
                $repository = new \Modules\Bcseo\Repositories\Eloquent\EloquentSeoRepository(new \Modules\Bcseo\Entities\Seo());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Bcseo\Repositories\Cache\CacheSeoDecorator($repository);
            }
        );
// add bindings
    }
}
