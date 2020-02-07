<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\Event;


interface DomainEvent extends EventInterface
{
    /**
     * deve retornar o id do Aggregate
     *
     * @return mixed
     */
    public function aggregateId(): string;

    /**
     * \DateTimeImmutable de quando o evento foi criado
     *
     * @return mixed
     */
    public function recordedAt(): \DateTimeImmutable;

    /**
     * Deve retornar o evento serializado como array
     *
     * @return array
     */
    public function serialize(): array;
}
