<?php

namespace App\Application\Middleware;

use App\Infrastructure\Container\Application\Twig\Extensions\IsAllowed;
use App\Infrastructure\Container\Application\Twig\Extensions\RenderLink;
use App\Infrastructure\Container\Application\Utils\Auth\SystemAcl;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Authorization\Acl\ZendAcl;

class TwigMiddleware implements MiddlewareInterface
{
    /** @var \Twig_Environment  */
    private $twigEnv;

    public function __construct(\Twig_Environment $twigEnv)
    {
        $this->twigEnv = $twigEnv;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) : ResponseInterface {

        $routeResult = $request->getAttribute('Zend\Expressive\Router\RouteResult');
        $routeName   = $routeResult->getMatchedRouteName();

        $this->twigEnv->addExtension(new RenderLink());
        $this->twigEnv->addGlobal('routeName', $routeName);

        return $handler->handle($request);
    }
}
