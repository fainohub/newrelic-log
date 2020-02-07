<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

use Respect\Validation\Validator;

/**
 * Value Object que representa uma chave de CTE
 *
 * Class NfeKey
 * @package TransportChain\Logistics\Domain\Entity
 */
final class CteKey
{
    private $value;

    public function __construct(string $value)
    {
        preg_match_all('/\d+/', $value, $matches);
        $value = array_shift($matches[0]);
        Validator::length(44, 44)->check($value);

        $this->value = $value;
    }

    public function getValue()
    {
        return (string)$this->value;
    }

    public function equals(CteKey $key)
    {
        return $key->getValue() === $this->getValue();
    }

    public function __toString()
    {
        return $this->getValue() ?? '';
    }
}
