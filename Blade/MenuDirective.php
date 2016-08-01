<?php

namespace Modules\Menu\Blade;

final class MenuDirective
{
    private $name;
    private $presenter;
    private $bindings;

    public function show($arguments)
    {
        $this->extractArguments($arguments);

        return $this->returnMenu();
    }

    /**
     * Extract the possible arguments as class properties
     * @param array $arguments
     */
    private function extractArguments(array $arguments)
    {
        $this->name = array_get($arguments, 0);
        $this->presenter = array_get($arguments, 1);
        $this->bindings = array_get($arguments, 2, []);
    }

    /**
     * Prepare arguments and return menu
     * @return string|null
     */
    private function returnMenu()
    {
        return app('menus')->get($this->name, $this->presenter, $this->bindings);
    }

    public function __toString()
    {
        return $this->returnMenu();
    }
}
