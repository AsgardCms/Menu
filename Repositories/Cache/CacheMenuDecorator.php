<?php namespace Modules\Menu\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Menu\Repositories\MenuRepository;

class CacheMenuDecorator extends BaseCacheDecorator implements MenuRepository
{
    /**
     * @var MenuRepository
     */
    protected $repository;

    public function __construct(MenuRepository $menu)
    {
        parent::__construct();
        $this->entityName = 'menus';
        $this->repository = $menu;
    }
}
