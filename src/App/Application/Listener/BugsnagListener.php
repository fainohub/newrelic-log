<?php

declare(strict_types=1);

namespace App\Application\Listener;

use Bugsnag\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BugsnagListener
{
    /**
     * Log message string with placeholders
     */
    const LOG_STRING = '{status} [{method}] {uri}: {error}';

    private $bugsnag;

    public function __construct(Client $bugsnag)
    {
        $this->bugsnag = $bugsnag;
    }

    public function __invoke(
        $error,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {

        $this->bugsnag->notifyException($error, function($report) use($response, $request) {
            $report->setSeverity('info');
            $report->setMetaData([
                'status' => [
                    'code' => $response->getStatusCode(),
                ],
                'body' => [
                    'contents' => $request->getBody()->getContents()
                ]
            ]);
        });

    }
}