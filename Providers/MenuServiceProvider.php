<?php namespace Modules\Menu\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Repositories\Cache\CacheMenuDecorator;
use Modules\Menu\Repositories\Eloquent\EloquentMenuRepository;

class MenuServiceProvider extends ServiceProvider
{
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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Register class binding
     */
    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Menu\Repositories\MenuRepository',
            function() {
                $repository = new EloquentMenuRepository(new Menu);

                if (! Config::get('app.cache')) {
                    return $repository;
                }

                return new CacheMenuDecorator($repository);
            }
        );
    }

}
