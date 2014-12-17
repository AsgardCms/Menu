<?php namespace Modules\Menu\Composers;

use Illuminate\Contracts\View\View;
use Modules\Menu\Entities\Menuitem;

class NavigationViewComposer
{
    public function __construct()
    {
    }

    public function compose(View $view)
    {
        $tree = Menuitem::where('id', '=', 9)->first()->getDescendantsAndSelf()->toHierarchy();
        dd($tree);
    }
}