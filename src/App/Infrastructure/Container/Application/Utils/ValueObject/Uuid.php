<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

use Ramsey\Uuid\Uuid as BaseUuid;

final class Uuid
{
    private $id;

    private function __construct(){}

    public static function fromString(string $stringId): Uuid
    {
        $instance = new self();
        $instance->id = BaseUuid::fromString($stringId);
        return $instance;
    }

    public static function newId(): Uuid
    {
        $instance = new self();
        $instance->id = BaseUuid::uuid4();
        return $instance;
    }

    public static function isValid($uuid): bool
    {
        return BaseUuid::isValid($uuid);
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
