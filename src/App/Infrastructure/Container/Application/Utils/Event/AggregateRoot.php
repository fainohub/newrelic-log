<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\Event;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

abstract class AggregateRoot extends EventSourcedAggregateRoot
{
    protected function raise($event)
    {
        $this->apply($event);
    }


}