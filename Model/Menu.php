<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Menu
{
    use OptionableTrait;

    /** @var Collection<MenuItem> */
    private Collection $menuItems;

    private bool $sorted = false;

    public function __construct(
        private readonly string $code,
        private string $template,
        private string $menuItemTemplate,
        array $options = [],
    ) {
        $this->menuItems = new ArrayCollection();
        $this->options = $options;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function getMenuItemTemplate(): string
    {
        return $this->menuItemTemplate;
    }

    public function setMenuItemTemplate(string $menuItemTemplate): void
    {
        $this->menuItemTemplate = $menuItemTemplate;
    }

    /** @return Collection<MenuItem> */
    public function getMenuItems(): Collection
    {
        if (!$this->sorted) {
            $menuItems = $this->menuItems->toArray();
            usort($menuItems, static fn(MenuItem $a, MenuItem $b) => $b->getPriority() <=> $a->getPriority());
            $this->menuItems = new ArrayCollection($menuItems);
            $this->sorted = true;
        }

        return $this->menuItems;
    }

    public function addMenuItem(MenuItem $menuItem): void
    {
        $this->menuItems->add($menuItem);
        $this->sorted = false;
    }

    public function removeMenuItem(MenuItem $menuItem): void
    {
        $this->menuItems->removeElement($menuItem);
    }
}
