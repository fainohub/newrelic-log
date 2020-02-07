<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Session\SessionMiddleware;

abstract class BaseAction
{
    /** @var ServerRequestInterface $request */
    protected $request;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handler(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    protected function getSession()
    {
        return $this->request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
    }
}