<?php namespace Modules\Menu\Repositories\Eloquent;

use Modules\Menu\Events\MenuWasCreated;
use Modules\Menu\Repositories\MenuRepository;
use Laracasts\Commander\Events\EventGenerator;
use Laracasts\Commander\Events\DispatchableTrait;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentMenuRepository extends EloquentBaseRepository implements MenuRepository
{
    use EventGenerator, DispatchableTrait;

    public function create($data)
    {
        $menu = $this->model->create($data);

        $this->raise(new MenuWasCreated($menu));

        $this->dispatchEventsFor($this);

        return $menu;
    }

    public function update($menu, $data)
    {
        $menu->update($data);

        return $menu;
    }
}
