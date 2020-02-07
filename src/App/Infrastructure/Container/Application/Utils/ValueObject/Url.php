<?php

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

use Respect\Validation\Validator as v;

final class Url
{
    private $value;

    public function __construct(string $value)
    {
        v::url()->check($value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(Url $url)
    {
        return $url->getValue() === $this->getValue();
    }
}