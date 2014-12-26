<?php namespace Modules\Menu\Tests;

class MenuRepositoryTest extends BaseMenuTest
{
    /** @test */
    public function it_creates_menu_with_root_menu_item()
    {
        $this->assertEquals(1, $this->menu->find(1)->count());
        $this->assertEquals('main', $this->menu->find(1)->name);
        $this->assertEquals(1, $this->menuItem->getRootForMenu(1)->count());
    }
}
