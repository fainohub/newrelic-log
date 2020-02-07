<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

/**
 * Value Object 
 *
 * Class Plate
 * @package TransportChain\Tracking\Domain\Entity
 */
final class Plate
{
    private $value;
    
    public function __construct(string $plate)
    {
        $plate = $this->removeSpecialChars(mb_strtoupper($plate));
        $this->value = $plate;
    }

    private function removeSpecialChars(string $value): string
    {
        $value = trim($value);
        return (string)preg_replace('/[^A-Z0-9]/', '', $value);
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function __toString()
    {
        return (string) $this->getValue();
    }
}