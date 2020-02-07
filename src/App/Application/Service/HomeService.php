<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Command\HomeCommand;
use App\Domain\Repository\ChatInterface;
use App\Infrastructure\Container\Application\Utils\Event\AggregateRoot;
use Ramsey\Uuid\Uuid;

final class HomeService extends AggregateRoot
{
    /**
     * @return string
     * @throws \Exception
     */
    public function getAggregateRootId(): string
    {
        return Uuid::uuid4()->toString();
    }
}