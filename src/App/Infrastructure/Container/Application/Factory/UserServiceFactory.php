<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Factory;

use App\Application\Service\UserService;
use App\Domain\Entity\AccessRole;
use App\Domain\Entity\User;
use App\Domain\Repository\AccessRoleInterface;
use App\Domain\Repository\UserInterface;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

class UserServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $em */
        $em = $container->get('doctrine.entity_manager.orm_default');
        $em2 = $container->get('doctrine.entity_manager.orm_default');

        /** @var UserInterface $repository */
        $repository = $em->getRepository(User::class);

        /** @var AccessRoleInterface $roleRepository */
        $roleRepository = $em->getRepository(AccessRole::class);

        return new UserService($repository, $roleRepository);
    }
}
