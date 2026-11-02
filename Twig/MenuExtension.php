<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Twig;

use Sidus\MenuBundle\Model\MenuItem;
use Sidus\MenuBundle\Registry\MenuRegistryInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuExtension extends AbstractExtension
{
    public function __construct(
        private readonly MenuRegistryInterface $menuRegistry,
        private readonly Environment $environment,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'sidus_menu',
                $this->renderMenu(...),
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'sidus_menu_item',
                $this->renderMenuItem(...),
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function renderMenu(string $code): string
    {
        $menu = $this->menuRegistry->getMenu($code);

        return $this->environment->render($menu->getTemplate(), ['menu' => $menu]);
    }

    public function renderMenuitem(MenuItem $menuItem): string
    {
        $template = $menuItem->getTemplate() ?? $menuItem->getMenu()->getMenuItemTemplate();

        return $this->environment->render($template, ['menuItem' => $menuItem]);
    }
}
