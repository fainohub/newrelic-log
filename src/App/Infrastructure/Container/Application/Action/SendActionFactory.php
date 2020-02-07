<?php

namespace App\Infrastructure\Container\Application\Action;

use Assert\Assertion;
//use MMLabs\Core\ServiceBus\CommandBusInterface;
use Psr\Container\ContainerInterface;

class SendActionFactory
{
    public function __invoke(ContainerInterface $container, $requestedService)
    {
        Assertion::classExists($requestedService);

        return new $requestedService($container->get(CommandBusInterface::NAME));
    }
}
