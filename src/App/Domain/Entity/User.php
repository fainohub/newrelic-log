<?php

namespace App\Domain\Entity;

/**
 * Class User
 * @package App\Domain\Entity
 */
class User
{
    /**
     * @var string
     */
    private $session;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $origin;

    /**
     * @var string
     */
    private $target;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * User constructor.
     * @param string $session
     * @param string $type
     * @param string $origin
     * @param string $target
     * @param string $payload
     * @param string $status
     * @throws \Exception
     */
    public function __construct(string $session,string $type,string $origin,string $target,string $payload, string $status)
    {
        $this->session   = $session;
        $this->type      = $type;
        $this->origin    = $origin;
        $this->target    = $target;
        $this->payload   = $payload;
        $this->status    = $status;
        $this->createdAt = new \DateTime;
        $this->updatedAt = new \DateTime;
    }

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getOrigin(): string
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     */
    public function setOrigin(string $origin): void
    {
        $this->origin = $origin;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
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

    public function toArray()
    {
        $result = [
            'session'  => $this->session,
            'type'     => $this->type,
            'origin'   => $this->origin,
            'target'   => $this->target,
            'payload'  => $this->payload,
            'status'  => $this->status
        ];

        return $result;
    }
}
