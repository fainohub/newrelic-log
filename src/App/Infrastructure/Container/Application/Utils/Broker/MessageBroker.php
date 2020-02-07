<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Utils\Broker;

use Broadway\Domain\DomainEventStream;

class MessageBroker
{
    private static function stompConnect($clientId = null)
    {
        $config = [
            'user'      => getenv('BROKER_USER'),
            'password'  => getenv('BROKER_PASSWORD'),
            'url'       => getenv('BROKER_URL').':'.getenv('BROKER_PORT')
        ];

        $client = [];

        if (!empty($clientId)) {
            $client['client-id'] = $clientId;
        }

        $stomp = new \Stomp($config['url'], $config['user'], $config['password'], $client);

        return $stomp;
    }

    public static function publish(string $topic, DomainEventStream $uncommitedEvents)
    {
        $events = $uncommitedEvents->getIterator();

        foreach ($events as $event) {
            $payload = $event->getPayload()->serialize();
            self::postTopic($topic, \GuzzleHttp\json_encode($payload));
        }
    }

    public static function postTopic(string $topic, string $payload)
    {
       try {
            $stomp = self::stompConnect();
            $stomp->send(sprintf('/topic/%s', $topic), $payload);
            unset($stomp);

            return true;

        } catch(StompException $e) {
            echo $e->getMessage();
        }
    }

    public static function readTopic(string $topic)
    {
        try {
            $stomp = self::stompConnect(getenv('APP_NAME'));
            $stomp->subscribe(sprintf('/topic/%s', $topic), ['activemq.subscriptionName' => 'Skeleton']);

            while(true) {
                $frame = $stomp->readFrame();
                if( $frame ) {
                    print_r($frame);
                    $stomp->ack($frame);
                }
            }
            unset($stomp);
        } catch(\StompException $e) {
            echo $e->getMessage();
        }
    }
}