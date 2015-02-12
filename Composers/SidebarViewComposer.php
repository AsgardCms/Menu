<?php namespace Modules\Menu\Composers;

use Illuminate\Contracts\View\View;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->items->put('menus', [
            'weight' => 7,
            'request' => "*/$view->prefix/menu/menu*",
            'route' => 'admin.menu.menu.index',
            'icon-class' => 'fa fa-bars',
            'title' => 'Menus',
            'permission' => $this->auth->hasAccess('menu.menus.index'),
        ]);
    }
}
