<?php

namespace Modules\Menu\Services;

class ParseBladeArguments
{
    private $name;
    private $presenter;
    private $bindings;

    public function __construct($arguments)
    {
        $this->extractArguments($arguments);
        $this->returnMenu();
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
        if (empty($this->presenter)) {
            $this->presenter = config('asgard.menu.config.default_menu_presenter');
        }

        return app('menus')->get($this->name, $this->presenter, $this->bindings);
    }

    public function __toString()
    {
        return $this->returnMenu();
    }
}
