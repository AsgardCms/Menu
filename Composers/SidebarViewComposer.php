<?php namespace Modules\Menu\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group('Menus', function (SidebarGroup $group) {
            $group->enabled = false;

            $group->addItem('Menus', function (SidebarItem $item) {
                $item->route('admin.menu.menu.index');
                $item->icon = 'fa fa-bars';
                $item->name = 'Menus';
                $item->authorize(
                    $this->auth->hasAccess('menu.menus.index')
                );
            });
        });
    }
}
