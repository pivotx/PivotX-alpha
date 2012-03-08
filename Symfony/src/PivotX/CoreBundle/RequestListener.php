<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PivotX\CoreBundle;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use PivotX\Core\Component\Routing\RouteService;

/**
 * Initializes request attributes based on a matching route.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class RequestListener
{
    private $router;
    private $logger;
    private $httpPort;
    private $httpsPort;

    private $routeservice;
    private $routesetup;

    public function __construct(RouterInterface $router, $httpPort = 80, $httpsPort = 443, LoggerInterface $logger = null, RouteService $routeservice = null)
    {
        $this->router = $router;
        $this->httpPort = $httpPort;
        $this->httpsPort = $httpsPort;
        $this->logger = $logger;

        if (!is_null($logger)) {
            $logger->debug('RequestListener constructor have logger');
        }
        if (!is_null($routeservice)) {
            $logger->debug('RequestListener constructor have setup');

            $this->routeservice = $routeservice;
            $this->routesetup   = $routeservice->getRouteSetup();
        }
    }

    public function onEarlyKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();
        $context = $this->router->getContext();

        // set the context even if the parsing does not need to be done
        // to have correct link generation
        $context->setBaseUrl($request->getBaseUrl());
        $context->setMethod($request->getMethod());
        $context->setHost($request->getHost());
        $context->setScheme($request->getScheme());
        $context->setHttpPort($request->isSecure() ? $this->httpPort : $request->getPort());
        $context->setHttpsPort($request->isSecure() ? $request->getPort() : $this->httpsPort);
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->has('_controller')) {
            // routing is already done
            return;
        }

        $uri = $request->getUri();
        $uri = preg_replace('|app(_dev)[.]php/|','',$uri);
        $this->logger->debug('in['.$request->getUri().'] out['.$uri.']');

        $routematch = $this->routesetup->matchUrl($uri);

        if (!is_null($routematch)) {
            /*
            if ($uri = $routematch->getRedirectUri()) {
                // @todo do something
            }
            */

            $parameters = $routematch->getAttributes();

            $request->attributes->add($parameters);

            if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
                $context = $this->router->getContext();
                $session = $request->getSession();
                if ($locale = $request->attributes->get('_locale')) {
                    if ($session) {
                        $session->setLocale($locale);
                    }
                    $context->setParameter('_locale', $locale);
                } elseif ($session) {
                    $context->setParameter('_locale', $session->getLocale());
                }
            }
        }
    }

    private function parametersToString(array $parameters)
    {
        $pieces = array();
        foreach ($parameters as $key => $val) {
            $pieces[] = sprintf('"%s": "%s"', $key, (is_string($val) ? $val : json_encode($val)));
        }

        return implode(', ', $pieces);
    }
}
