<?php

namespace App\Infrastructure\Container\Application\Utils\Doctrine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class AbstractDoctrineRepository extends EntityRepository
{
    /** @var string */
    protected $alias;

    /** @var QueryBuilder */
    protected $lastQuery;

    /**
     * Utilize para setar os where
     * padrões para todas as consultas
     *
     * @var array
     */
    protected $defaultCriteria = [];
    protected $defaultSort = [];

    protected function queryBuilder(): QueryBuilder
    {
        $this->lastQuery = $this->_em->createQueryBuilder()
            ->select($this->getAlias())
            ->from($this->_entityName, $this->getAlias());

        $this->parseCriteria($this->defaultCriteria, $this->lastQuery);
        $this->parseOrderBy($this->defaultSort, $this->lastQuery);

        return $this->lastQuery;
    }

    /**
     * Retorna a contagem total da última consulta realizada, se for
     * utlizado o método $this->queryBuilder() para a construção da consulta
     * personalizada.
     *
     * @return int|null
     */
    public function countLastQuery()
    {
        if (!$this->lastQuery ||
            !($this->lastQuery instanceof QueryBuilder)
        ) {
            return null;
        }

        return (int)$this->lastQuery
            ->select(sprintf('COUNT(%s) total', $this->getAlias()))
            ->resetDQLPart('groupBy')
            ->resetDQLPart('orderBy')
            ->setFirstResult(null)
            ->setMaxResults(null)
            ->getQuery()
            ->getSingleScalarResult();
    }

    protected function parseCriteria(array $criteria, QueryBuilder $queryBuilder)
    {
        foreach ($criteria as $field => $value) {
            $condition = null;
            $fieldName = $this->getFieldWithAlias($field);

            if ($field === '_search') {
                $likes = [];
                foreach ($value as $_searchField => $_searchValue) {
                    $_searchField = $this->getFieldWithAlias($_searchField);
                    $condition    = $queryBuilder->expr()->like(
                        $_searchField,
                        $queryBuilder->expr()->literal($_searchValue)
                    );
                    array_push($likes, (string)$condition);
                }
                $queryBuilder->andWhere(implode(' OR ', $likes));
                continue;
            }

            if ($field === '_isNot') {
                foreach ($value as $_searchField => $_searchValue) {
                    $_searchField = $this->getFieldWithAlias($_searchField);
                    $condition    = $queryBuilder->expr()->neq(
                        $_searchField,
                        $queryBuilder->expr()->literal($_searchValue)
                    );
                    $queryBuilder->andWhere($condition);
                }
                continue;
            }

            if ($field === '_between') {
                foreach ($value as $_searchField => $_searchValue) {
                    $_searchField = $this->getFieldWithAlias($_searchField);
                    list($_valueIni, $_valueEnd) = $_searchValue;
                    $condition = $queryBuilder->expr()->between(
                        sprintf('DATE(%s)', $_searchField),
                        (string)$queryBuilder->expr()->literal($_valueIni),
                        (string)$queryBuilder->expr()->literal($_valueEnd)
                    );
                    $queryBuilder->andWhere($condition);
                }
                continue;
            }

            switch (gettype($value)) {
                case 'array':
                    $condition = $queryBuilder->expr()->in(
                        $fieldName,
                        $value
                    );
                    break;
                case 'NULL':
                    $condition = $queryBuilder->expr()->isNull($fieldName);
                    break;
                case 'string':
                    if (strpos($value, '%') !== false) {
                        $condition = $queryBuilder->expr()->like($fieldName, $value);
                        break;
                    }

                    $condition = $queryBuilder->expr()->eq(
                        $fieldName,
                        $queryBuilder->expr()->literal($value)
                    );
                    break;
                default:
                    $condition = $queryBuilder->expr()->eq($fieldName, $value);
                    break;

            }

            if (!$condition) {
                continue;
            }

            $queryBuilder->andWhere($condition);
        }
    }

    protected function parseOrderBy(array $orderby = null, QueryBuilder $queryBuilder)
    {
        if (!$orderby) {
            return;
        }

        foreach ($orderby as $field => $direction) {
            $field = $this->getFieldWithAlias($field);
            $queryBuilder->addOrderBy($field, strtoupper($direction));
        }
    }

    /**
     * Retorna o campo com o alias da entidade caso não houver
     *
     * @param $field
     * @return string
     */
    protected function getFieldWithAlias($field)
    {
        if (strpos($field, '.') === false) {
            return sprintf('%s.%s', $this->getAlias(), $field);
        }
        return $field;
    }

    public function createQueryBuilder($alias, $indexBy = null)
    {
        $this->alias = $alias;
        return $this->queryBuilder();
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $queryBuilder = $this->queryBuilder();
        $queryBuilder->andWhere($this->getAlias() . '.id = :id');
        $queryBuilder->setParameter('id', $id);
        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function findAll()
    {
        $queryBuilder = $this->queryBuilder();
        return $queryBuilder->getQuery()->getResult();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $queryBuilder = $this->queryBuilder();
        $this->parseCriteria($criteria, $queryBuilder);
        $this->parseOrderby($orderBy, $queryBuilder);

        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $result = $this->findBy($criteria, $orderBy, 1);

        if (!$result) {
            return null;
        }

        return reset($result);
    }


    /**
     * Retorne o alias da entidade, ex: p
     * @return string
     */
    abstract protected function getAlias();

    public function transactional(\Closure $handler)
    {
        $this->_em->transactional($handler);
    }

    public function getList(array $criteria, array $sort = [], int $limit = 10, int $offset = 0): array
    {
        $qb = $this->createQueryBuilder($this->getAlias());

        foreach ($criteria as $key => $value) {
            $qb->andWhere(sprintf("%s.%s = %s", $this->getAlias(), $key, ':' . $key));
            $qb->setParameter($key, $value);
        }

        foreach ($sort as $key => $direction) {
            $qb->addOrderBy($key, $direction);
        }

        $qb->setMaxResults($limit);
        $qb->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    public function count(array $criteria): int
    {
        $qb = $this->createQueryBuilder($this->getAlias());
        $qb->select('COUNT(1)');

        foreach ($criteria as $key => $value) {
            $qb->andWhere(sprintf("%s.%s = %s", $this->getAlias(), $key, ':' . $key));
            $qb->setParameter($key, $value);
        }

        return (int)$qb->getQuery()->getSingleScalarResult();
    }
}