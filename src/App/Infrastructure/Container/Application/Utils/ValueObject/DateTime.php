<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\ValueObject;

final class DateTime extends \DateTime
{
    public function __construct($time = 'now', \DateTimeZone $timezone = null)
    {
        parent::__construct($time, $timezone);
        $this->setTimezone($timezone ?: new \DateTimeZone('UTC'));
    }
}
