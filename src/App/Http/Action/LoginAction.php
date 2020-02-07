<?php

declare(strict_types=1);

namespace App\Http\Action;

use App\Application\Helper\ParseHelper;
use \Firebase\JWT\JWT;
use \Tuupo;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

class LoginAction implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    public function __construct(string $containerName)
    {
        $this->containerName = $containerName;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $now = new \DateTime();
        $future = new \DateTime("now +24 hours");
        $jti = hash('sha256', random_bytes(16));

        $secret = "#@!Ob3l1xM4d31r4M4d31r42018!@#";

        $payload = [
            "jti" => $jti
        ];

        $token = JWT::encode($payload, $secret, "HS256");

        return new JsonResponse(['status' => 200, "token" => $token], 200);
    }
}
