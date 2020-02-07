<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository;

use App\Domain\Entity\User;
use App\Infrastructure\Container\Application\Utils\Doctrine\AbstractDoctrineRepository;
use App\Domain\Repository\UserInterface;
use Doctrine\DBAL\ParameterType;

final class DoctrineUserRepository extends AbstractDoctrineRepository implements UserInterface
{
    protected function getAlias()
    {
        return 'u';
    }

    /**
     * @param string $id
     * @return Chat|array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function fromId(string $id)
    {
        $qb = $this->createQueryBuilder($this->getAlias());

        $qb->where('u.userId = :id');
        $qb->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param string $email
     * @return User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function fromEmail(string $email)
    {
        $qb = $this->createQueryBuilder($this->getAlias());

        $qb->where('u.email = :email');
        $qb->setParameter('email', $email);

        /** @var User $result */
        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param array $data
     * @param int|null $clientID
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getUserList(array $data, ?int $clientID = null)
    {
        $sql = "SELECT
                    count(1) as total,
                    u.user_id as id,
                    u.name as nome,
                    u.email,
                    u.created_at,
                    GROUP_CONCAT(ar.name) as perfil
                FROM user as u
                LEFT JOIN access_user_roles as aur ON aur.user_id = u.user_id
                LEFT JOIN access_role as ar ON ar.access_role_id = aur.access_role_id
                WHERE u.status = 1
                GROUP BY u.user_id
                LIMIT :limit
                OFFSET :offset
                ";

        $em = $this->getEm();
        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue('limit', $data['limit'], ParameterType::INTEGER);
        $statement->bindValue('offset', ($data['page'] - 1) * $data['limit'], ParameterType::INTEGER);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @param int|null $clientID
     * @return mixed[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getUserListCount(?int $clientID = null)
    {
        $sql = "SELECT
                    count(1) as total
                FROM user as u
                WHERE u.status = 1
                ";

        $em = $this->getEm();
        $statement = $em->getConnection()->prepare($sql);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update()
    {
        $this->getEntityManager()->flush();
    }

    public function deleteRoles(string $userId)
    {
        $sql = 'DELETE FROM access_user_roles WHERE user_id = :user_id';

        $em = $this->getEm();
        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue('user_id', $userId);

        return $statement->execute();
    }

    public function getEm()
    {
        return $this->getEntityManager();
    }
}
