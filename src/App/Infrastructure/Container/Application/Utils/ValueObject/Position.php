<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

/**
 * Value Object
 *
 * Class Position
 * @package TransportChain\Tracking\Domain\Entity
 */
class Position
{
    /**
     * Latitude
     * @var float
     */
    protected $lat;

    /**
     * Longitude
     * @var float
     */
    protected $long;

    /**
     * Position constructor.
     * @param float $lat Latitude
     * @param float $long Longitude
     */
    public function __construct(float $lat, float $long)
    {
        $this->lat = $lat;
        $this->long = $long;
    }

    public static function createFromLatAndLong(float $lat, float $long)
    {
        return new static($lat, $long);
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLong()
    {
        return $this->long;
    }

    public function __toString()
    {
        return "{$this->lat}, {$this->long}";
    }
}
