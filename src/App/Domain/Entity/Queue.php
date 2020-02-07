<?php

namespace App\Domain\Entity;

/**
 * Class Queue
 * @package App\Domain\Entity
 */
class Queue
{
    /**
     * @var string
     */
    private $idQueue;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var \DateTime
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * Queue constructor.
     * @param string $idQueue
     * @param string $payload
     * @throws \Exception
     */
    public function __construct(string $idQueue, string $payload)
    {
        $this->idQueue   = $idQueue;
        $this->payload   = $payload;
        $this->createdAt = new \DateTime;
        $this->updatedAt = new \DateTime;
    }

    /**
     * @return string
     */
    public function getIdQueue(): string
    {
        return $this->idQueue;
    }

    /**
     * @param string $idQueue
     */
    public function setIdQueue(string $idQueue): void
    {
        $this->idQueue = $idQueue;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }



    /**
     * @return array
     */
    public function toArray()
    {
        $result = [
            'idQueue'  => $this->idQueue,
            'payload'  => $this->payload,
            'createdAt' => $this->createdAt,
            'updateAt' => $this->updatedAt
        ];

        return $result;
    }
}
