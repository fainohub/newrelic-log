<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

use Respect\Validation\Validator;

/**
 * Value Object que representa uma chave de um manifesto
 *
 * Class MDFKey
 * @package App\Infrastructure\Container\Application\Utils\ValueObject
 */
final class MDFKey
{
    private $value;

    public function __construct(string $value)
    {
        $value = $this->clear($value);
        Validator::length(44, 44)->check($value);

        $this->value = $value;
    }

    private function clear(string $value)
    {
        return (string)str_replace('MDFe', '', $value);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function equals(MDFKey $key)
    {
        return $key->getValue() === $this->getValue();
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
