<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'delegators' => [
            \Zend\Stratigility\Middleware\ErrorHandler::class => [
                \App\Infrastructure\Container\Application\Factory\BugsnagFactory::class,
            ],
        ],
        'aliases' => [
            \Symfony\Contracts\HttpClient\ResponseInterface::class =>
                \Psr\Http\Message\ResponseInterface::class
        ],
        'invokables' => [

        ],
        'factories'  => [
            'bugsnag' => function (ContainerInterface $container) {
                $key = $container->get("config")['bugsnag']['key'];

                $bugsnag = Bugsnag\Client::make($key);

                $bugsnag->getConfig()->setReleaseStage(getenv('APPLICATION_ENV'));
                $bugsnag->getConfig()->setNotifyReleaseStages($container->get("config")['bugsnag']['notify']);

                return $bugsnag;
            },

            // REDIS
            \App\Application\Service\CacheService::class =>
                \App\Infrastructure\Container\Application\Factory\CacheServiceFactory::class,

            //Middlewares
            \App\Application\Middleware\TwigMiddleware::class =>
                \App\Infrastructure\Container\Application\Factory\TwigMiddlewareFactory::class,
        ],
    ],
];
