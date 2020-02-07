<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\Console;

use Zend\Console\Adapter\AdapterInterface;
use ZF\Console\Route;

interface ConsoleInterface
{
    public function execute(Route $route, AdapterInterface $console);
}