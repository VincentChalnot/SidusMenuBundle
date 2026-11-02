<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Model;

readonly class Security
{
    public function __construct(
        private ?string $role,
        private mixed $object = null,
    ) {
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getObject(): mixed
    {
        return $this->object;
    }
}
