<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Model;

class MenuItem
{
    use OptionableTrait;

    public function __construct(
        private readonly Menu $menu,
        private readonly ?string $path = null,
        private readonly ?string $template = null,
        private readonly ?string $title = null,
        private readonly ?string $icon = null,
        private readonly ?Security $security = null,
        private readonly array $roles = [],
        private readonly array $attributes = [],
        array $options = [],
        private readonly int $priority = 0,
    ) {
        $this->options = $options;
    }

    public function getMenu(): Menu
    {
        return $this->menu;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function getSecurity(): ?Security
    {
        return $this->security;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function getAttributes(array $defaults = []): array
    {
        return array_merge($defaults, $this->attributes);
    }
}
