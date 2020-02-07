<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\Command;

/**
 * Interface CommandInterface
 * @package App\Infrastructure\Container\Application\Utils
 */
interface CommandInterface
{
    /**
     * Factory para criar command a partir de array
     *
     * @param array $data
     */
    public static function fromArray($data);

    /**
     * Serializa os parametros do command
     * @return array
     */
    public function toArray(): array;
}
