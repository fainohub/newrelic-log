<?php

declare(strict_types=1);

namespace App\Infrastructure\Container\Application\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Flash\FlashMessages;

abstract class MultipleAction
{
    /** @var ServerRequestInterface $request */
    protected $request;

    /** @var RequestHandlerInterface $handler */
    protected $handler;

    /** @var FlashMessages $flashMessages */
    protected $flashMessages;

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->request = $request;
        $this->handler  = $handler;
        $this->flashMessages = $this->request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $function = strtolower($request->getMethod());

        return $this->$function();
    }

    abstract protected function get();

    abstract protected function post();
}