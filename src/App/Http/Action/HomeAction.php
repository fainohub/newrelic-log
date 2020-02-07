<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Application\Service\HomeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class HomeAction implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    /** @var TestService */
    private $service;

    public function __construct(string $containerName, HomeService $service)
    {
        $this->service = $service;
        $this->containerName = $containerName;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getQueryParams();

        $result = [
            'status' => true,
            'customers' => [
                'id' => 'a94e8cb2-2daa-4dee-b065-9d94717c6871',
                'contact' => '35988270925'
            ]
        ];

        return new JsonResponse($result, 200);;
    }
}
