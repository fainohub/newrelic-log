<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application;

use App\Http\Action;
use App\Application\Service;
use App\Infrastructure\Container\Application\Factory;
use App\Infrastructure\Rest\Repository\AndyRepository;
use App\Infrastructure\Rest\Repository\BlackPantherRepository;
use App\Infrastructure\Rest\Repository\CRM360Repository;
use App\Infrastructure\Rest\Repository\RexRepository;
use App\Infrastructure\Rest\Repository\WarMachineRepository;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'twig'         => $this->getTwig(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [],
            'factories' => [
                // Actions
                Action\HomeAction::class => new Factory\Action\ActionServiceFactory(Service\HomeService::class),
                Action\AliveAction::class => new Factory\Action\ActionServiceFactory(null),
                Action\LoginAction::class => new Factory\Action\ActionServiceFactory(null),

                // Services
                Service\HomeService::class => Factory\Service\HomeServiceFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => ['src/App/Application/Templates/app'],
                'error'  => ['src/App/Application/Templates/error'],
                'layout' => ['src/App/Application/Templates/layout'],
            ],
        ];
    }

    public function getTwig()
    {
        return [
            //'cache_dir' => 'data/cache/twig',
            'debug' => true,
            'assets_url' => '/',
            'assets_version' => null,
            'extensions' => [

            ],
            'runtime_loaders' => [
                // runtime loader names or instances
            ],
            'globals' => [
                // Variables to pass to all twig templates
            ],
            // 'timezone' => 'default timezone identifier; e.g. America/Chicago',
        ];
    }
}
