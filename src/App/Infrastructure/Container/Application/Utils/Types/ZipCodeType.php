<?php

namespace App\Infrastructure\Container\Application\Utils\Types;

use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use App\Infrastructure\Container\Application\Utils\ValueObject\ZipCode;

final class ZipCodeType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValueSQL((string) $value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }
        return new ZipCode(parent::convertToPHPValue($value, $platform));
    }
}
