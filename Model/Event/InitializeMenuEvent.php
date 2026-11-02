<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Model\Event;

use Sidus\MenuBundle\Model\Menu;

readonly class InitializeMenuEvent
{
    public function __construct(public Menu $menu)
    {
    }
}
