<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Application\Service\HomeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class AliveAction implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    public function __construct(string $containerName)
    {
        $this->containerName = $containerName;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['status' => 200, "message" => "Obelix is alive."], 200);
    }
}
