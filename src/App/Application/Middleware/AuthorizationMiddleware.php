<?php

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Authentication\DefaultUser;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Handler\NotFoundHandler;
use Zend\Expressive\Router\RouteResult;
use Zend\Expressive\Session\SessionMiddleware;

class AuthorizationMiddleware implements MiddlewareInterface
{
    private $notFoundHandler;
    private $redirect;

    public function __construct(NotFoundHandler $notFoundHandler, string $redirect)
    {
        $this->notFoundHandler = $notFoundHandler;
        $this->redirect        = $redirect;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) : ResponseInterface {

        // 404 check early
        $routeResult = $request->getAttribute(RouteResult::class);
        if ($routeResult->isFailure()) {
            return $this->notFoundHandler->handle($request, $handler);
        }

        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

        // No Session data
        if (!$session->has(UserInterface::class)) {
            $user  = '';
            $roles = ['guest'];

            $request = $request->withAttribute(
                UserInterface::class,
                new DefaultUser(
                    $user,
                    $roles
                )
            );

            $response = $handler->handle($request);
            if ($request->getUri()->getPath() === $this->redirect || $response->getStatusCode() !== 403) {
                return $response;
            }

            return new RedirectResponse($this->redirect);
        }

        // at /login page, redirect to authenticated page
        if ($request->getUri()->getPath() === $this->redirect) {
            return new RedirectResponse('/');
        }

        // define roles from DB
        $sessionData = $session->get(UserInterface::class);
        $request = $request->withAttribute(
            UserInterface::class,
            new DefaultUser(
                $sessionData['username'],
                $sessionData['roles'],
                $sessionData['details']
            )
        );

        return $handler->handle($request);
    }
}
