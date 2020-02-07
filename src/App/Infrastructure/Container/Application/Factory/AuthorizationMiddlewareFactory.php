<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Factory;

use App\Application\Middleware\AuthorizationMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Expressive\Authorization\Acl\ZendAcl;
use Zend\Expressive\Authorization\AuthorizationInterface;
use Zend\Expressive\Handler\NotFoundHandler;
use Zend\Permissions\Acl\Acl;

class AuthorizationMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return MiddlewareInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container) : MiddlewareInterface
    {
        $notFoundHandler   = $container->get(NotFoundHandler::class);
        $redirect          = $container->get('config')['authentication']['redirect'];

        return new AuthorizationMiddleware($notFoundHandler, $redirect);
    }
}
