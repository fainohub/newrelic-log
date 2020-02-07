<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

use Respect\Validation\Validator as v;

/**
 * Class ZipCode
 * @package TransportChain\Tracking\Domain\Entity\Address
 */
final class ZipCode
{
    private $value;

    public function __construct($postalCode)
    {
        $postalCode = trim($postalCode);
        v::postalCode('BR')->check($postalCode);

        $this->value = $this->removeSpecialCaracters($postalCode);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->getValue();
    }

    public function removeSpecialCaracters($value)
    {
        $value = trim($value);
        return (string)preg_replace('/[^0-9]/', '', $value);
    }

    public function equals(ZipCode $zipCode)
    {
        return $zipCode->getValue() === $this->getValue();
    }

    public function pretify()
    {
        return substr($this->getValue(), 0, 5) . '-' . substr($this->getValue(), 5, 3);
    }
}
