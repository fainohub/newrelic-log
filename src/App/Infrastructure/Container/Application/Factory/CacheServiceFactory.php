<?php
declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Factory;

use App\Application\Service\CacheService;
use Predis\Client;
use Psr\Container\ContainerInterface;

class CacheServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return CacheService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $client = new Client($config['redis']);

        return new CacheService($client);
    }
}