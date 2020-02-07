<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

use Respect\Validation\Validator;

final class Cpf
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $value = $this->removeSpecialChars($value);
        Validator::cpf()->check($value);

        $this->value = $value;
    }

    private function removeSpecialChars(string $value): string
    {
        $value = trim($value);
        return (string)preg_replace('/[^0-9]/', '', $value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function equals(Cpf $identifier)
    {
        return $identifier->getValue() === $this->getValue();
    }
}
