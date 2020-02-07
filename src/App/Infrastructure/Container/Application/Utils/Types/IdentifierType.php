<?php

namespace App\Infrastructure\Container\Application\Utils\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Infrastructure\Container\Application\Utils\ValueObject\Identifier;

final class IdentifierType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (! $value) {
            return;
        }

        return parent::convertToDatabaseValueSQL((string)$value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Identifier(parent::convertToPHPValue($value, $platform));
    }
}
