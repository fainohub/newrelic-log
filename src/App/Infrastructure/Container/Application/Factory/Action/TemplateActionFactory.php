<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Factory\Action;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

use function get_class;

class TemplateActionFactory
{
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function __invoke(ContainerInterface $container, $requestedService) : RequestHandlerInterface
    {
        $router   = $container->get(RouterInterface::class);
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        $service = $container->get($this->service);

        return new $requestedService(get_class($container), $router, $template, $service);
    }
}
