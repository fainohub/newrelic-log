<?php

namespace App\Infrastructure\Container\Application\Utils\Types;

use App\Infrastructure\Container\Application\Utils\ValueObject\Cnpj;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class CnpjType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValueSQL((string) $value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Cnpj(parent::convertToPHPValue($value, $platform));
    }
}
