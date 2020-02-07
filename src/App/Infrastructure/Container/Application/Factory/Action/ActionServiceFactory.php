<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Factory\Action;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function get_class;

class ActionServiceFactory
{
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function __invoke(ContainerInterface $container, $requestedService) : RequestHandlerInterface
    {
        $service = null !== $this->service ? $container->get($this->service) : null;

        return new $requestedService(get_class($container), $service);
    }
}
