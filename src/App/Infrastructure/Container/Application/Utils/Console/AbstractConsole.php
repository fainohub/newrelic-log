<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\Console;

use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractConsole implements ConsoleInterface
{
    protected $serviceLocator;
    protected $parameters;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator                     = $serviceLocator;
        $this->parameters                         = [];
        $this->parameters['defaults']             = [];
        $this->parameters['handler']              = [$this, 'execute'];
        $this->parameters['options_descriptions'] = [];
    }

    abstract protected function configure();

    protected function setName($name)
    {
        $this->parameters['name'] = $name;
        return $this;
    }

    protected function setRoute($route)
    {
        $this->parameters['route'] = $route;
        return $this;
    }

    protected function setDescription($description)
    {
        $this->parameters['description'] = $description;
        return $this;
    }

    protected function setShortDescription($shortDescription)
    {
        $this->parameters['short_description'] = $shortDescription;
        return $this;
    }

    protected function addDefaultParameter($key, $value)
    {
        $this->parameters['defaults'][$key] = $value;
        return $this;
    }

    protected function addOptionsDescriptions($key, $value)
    {
        $this->parameters['options_descriptions'][$key] = $value;
        return $this;
    }

    public function getConfiguration(): array
    {
        $this->configure();
        return $this->parameters;
    }
}
