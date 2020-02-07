<?php

namespace App\Infrastructure\Container\Application\Utils\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Infrastructure\Container\Application\Utils\ValueObject\CteKey;

final class CteKeyType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValueSQL((string)$value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }
        return new CteKey(parent::convertToPHPValue($value, $platform));
    }
}
