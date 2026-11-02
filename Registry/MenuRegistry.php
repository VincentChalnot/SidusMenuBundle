<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Registry;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Psr\EventDispatcher\EventDispatcherInterface;
use Sidus\MenuBundle\Model\Event\InitializeMenuEvent;
use Sidus\MenuBundle\Model\Exception\MissingMenuException;
use Sidus\MenuBundle\Model\Menu;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * Base registry to store menus
 */
#[AsAlias(MenuRegistryInterface::class)]
class MenuRegistry implements MenuRegistryInterface
{
    private Collection $menu;

    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
        $this->menu = new ArrayCollection();
    }

    public function getMenu(string $code): Menu
    {
        if (!$this->menu->containsKey($code)) {
            throw MissingMenuException::fromCode($code);
        }
        return $this->menu->get($code);
    }

    public function addMenu(Menu $menu): void
    {
        $event = new InitializeMenuEvent($menu);
        $this->eventDispatcher->dispatch($event);
        $this->menu->set($menu->getCode(), $menu);
    }
}
