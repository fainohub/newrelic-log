<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Factory\Service;

use App\Application\Service\HomeService;
//use App\Domain\Entity\Chat;
use App\Domain\Repository\ChatInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

use function get_class;

class HomeServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new HomeService();
    }
}
