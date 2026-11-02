<?php

declare(strict_types=1);

namespace Sidus\MenuBundle\Registry;

use Sidus\MenuBundle\Model\Menu;

interface MenuRegistryInterface
{
    public function getMenu(string $code): Menu;

    public function addMenu(Menu $menu): void;
}
