<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Registry;

use Psr\Container\ContainerInterface;
use Sidus\MenuBundle\Model\Exception\MissingMenuException;
use Sidus\MenuBundle\Model\Menu;
use Sidus\MenuBundle\Model\MenuItem;
use Sidus\MenuBundle\Model\Security;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;

/**
 * Advanced Menu registry decorator that automatically adds menus defined as services or through configuration
 */
#[AsDecorator(decorates: MenuRegistryInterface::class)]
readonly class MenuConfigurationRegistry implements MenuRegistryInterface
{
    private ContainerInterface $menusContainer;

    public function __construct(
        #[AutowireDecorated]
        private MenuRegistryInterface $menuRegistry,
        #[AutowireLocator(services: 'sidus.admin.menu', indexAttribute: 'code')]
        ContainerInterface $menusContainer,
        private array $configuration,
    ) {
        $this->menusContainer = $menusContainer;
    }

    public function getMenu(string $code): Menu
    {
        try {
            return $this->menuRegistry->getMenu($code);
        } catch (MissingMenuException $e) {
            // If menu is defined as a service, inject it in registry
            if ($this->menusContainer->has($code)) {
                $menu = $this->menusContainer->get($code);
                $this->addMenu($menu);

                return $menu;
            }

            if (!array_key_exists($code, $this->configuration['menus'])) {
                throw $e;
            }
            // If menus is defined as a static configuration, build it and inject it in registry
            $menu = $this->buildMenu($code, $this->configuration['menus'][$code]);
            $this->addMenu($menu);

            return $menu;
        }
    }

    public function addMenu(Menu $menu): void
    {
        $this->menuRegistry->addMenu($menu);
    }

    private function buildMenu(string $code, array $configuration): Menu
    {
        $menu = new Menu(
            code: $code,
            template: $configuration['template'],
            menuItemTemplate: $configuration['menu_item_template'],
            options: $configuration['options'],
        );

        foreach ($configuration['items'] as $item) {
            $security = null;
            if ($item['security'] ?? null) {
                $security = new Security(role: $item['security']['role'], object: $item['security']['object']);
            }
            $item = new MenuItem(
                menu: $menu,
                path: $item['path'],
                template: $item['template'],
                title: $item['title'],
                icon: $item['icon'],
                security: $security,
                roles: $item['roles'],
                attributes: $item['attributes'],
                options: $item['options'],
                priority: $item['priority'],
            );
            $menu->addMenuItem($item);
        }

        return $menu;
    }
}
