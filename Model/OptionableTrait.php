<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Model;

/**
 * @property array $options
 */
trait OptionableTrait
{
    protected array $options = [];

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getOption(string $key, mixed $default = null): mixed
    {
        return $this->options[$key] ?? $default;
    }

    public function setOption(string $key, mixed $value): void
    {
        $this->options[$key] = $value;
    }
}
