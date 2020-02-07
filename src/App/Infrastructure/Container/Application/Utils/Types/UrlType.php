<?php

namespace App\Infrastructure\Container\Application\Utils\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Infrastructure\Container\Application\Utils\ValueObject\Url;
use Doctrine\DBAL\Types\StringType;

final class UrlType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (! $value) {
            return null;
        }

        return parent::convertToDatabaseValueSQL((string)$value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (! $value) {
            return null;
        }

        return new Url(parent::convertToPHPValue($value, $platform));
    }
}
