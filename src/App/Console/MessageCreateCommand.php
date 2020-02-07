<?php

namespace App\Console;

ini_set('memory_limit', '-1');

use App\Infrastructure\Container\Application\Utils\Broker\MessageBroker;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;
use ZF\Console\Route;
use App\Infrastructure\Container\Application\Utils\Console\AbstractConsole;

class MessageCreateCommand extends AbstractConsole
{
    const NAME = 'app-message:send';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Enviar Mensagem')
            ->setRoute('--payload=');
    }

    public function execute(Route $route, AdapterInterface $console)
    {
        $console->writeLine('Seu payload: ' . $route->getMatchedParam('payload'), ColorInterface::YELLOW);
        $console->writeLine('Aguardando Mensagens do Broker', ColorInterface::GREEN);

        $payload = json_decode($route->getMatchedParam('payload'), true);

        $command = \App\Application\Command\ReadTopicCommand::fromArray($payload);

        MessageBroker::readTopic($command->getTopic());
    }
}
