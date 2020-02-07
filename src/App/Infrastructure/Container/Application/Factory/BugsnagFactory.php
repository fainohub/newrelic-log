<?php
/**
 * Created by PhpStorm.
 * User: ronie
 * Date: 19/04/18
 * Time: 15:30
 */

namespace App\Infrastructure\Container\Application\Factory;

use App\Application\Listener\BugsnagListener;
use Psr\Container\ContainerInterface;
use Zend\Stratigility\Middleware\ErrorHandler;

class BugsnagFactory
{
    public function __invoke(
        ContainerInterface $container,
        $serviceName,
        callable $callback
    ) : ErrorHandler {
        $bugsnag = $container->get('bugsnag');

        $listener = new BugsnagListener($bugsnag);

        $errorHandler = $callback();
        $errorHandler->attachListener($listener);
        return $errorHandler;
    }
}
