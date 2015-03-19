<?php namespace Modules\Menu\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('core::sidebar.content'), function (SidebarGroup $group) {
            $group->weight = 90;
            $group->addItem(trans('menu::menu.title'), function (SidebarItem $item) {
                $item->weight = 3;
                $item->icon = 'fa fa-bars';
                $item->route('admin.menu.menu.index');
                $item->authorize(
                    $this->auth->hasAccess('menu.menus.index')
                );
            });
        });
    }
}
