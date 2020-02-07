<?php

namespace App\Infrastructure\Container\Application\Utils\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use App\Infrastructure\Container\Application\Utils\ValueObject\Uuid;

final class UuidType extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (! $value) {
            return null;
        }

        return parent::convertToDatabaseValueSQL((string) $value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $val = parent::convertToPHPValue($value, $platform);

        if (! $val) {
            return $val;
        }

        return Uuid::fromString($val);
    }
}