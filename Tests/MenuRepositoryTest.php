<?php namespace Modules\Menu\Tests;

class MenuRepositoryTest extends BaseMenuTest
{
    /** @test */
    public function it_creates_menu_with_root_menu_item()
    {
        $menu = $this->createMenu('main', 'Main Menu');

        $this->assertEquals(1, $this->menu->find($menu->id)->count());
        $this->assertEquals($menu->name, $this->menu->find($menu->id)->name);
        $this->assertInstanceOf('Modules\Menu\Entities\Menuitem', $this->menuItem->getRootForMenu($menu->id));
    }
}
