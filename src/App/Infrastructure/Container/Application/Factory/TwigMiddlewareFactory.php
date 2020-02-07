<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Factory;


use App\Application\Middleware\TwigMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;


class TwigMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return MiddlewareInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container) : MiddlewareInterface
    {
        /** @var \Twig_Environment $twigRenderer */
        $twigEnv = $container->get(\Twig_Environment::class);

        return new TwigMiddleware($twigEnv);
    }
}
