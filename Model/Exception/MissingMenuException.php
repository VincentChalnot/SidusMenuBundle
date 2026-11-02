<?php
declare(strict_types=1);

namespace Sidus\MenuBundle\Model\Exception;

class MissingMenuException extends \RuntimeException
{
    public static function fromCode(string $code): self
    {
        return new self("Menu with code '{$code}' is not defined");
    }
}
