<?php namespace Modules\Menu\Tests;

class MenuRepositoryTest extends BaseMenuTest
{
    /** @test */
    public function it_creates_menu()
    {
        $menu = $this->createMenu('main', 'Main Menu');

        $this->assertEquals(1, $this->menu->find($menu->id)->count());
        $this->assertEquals($menu->name, $this->menu->find($menu->id)->name);
    }
}
