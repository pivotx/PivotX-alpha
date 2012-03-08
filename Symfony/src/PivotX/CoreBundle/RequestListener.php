<?php

/**
 * This file is part of the PivotX Core bundle
 *
 * (c) Marcel Wouters / Two Kings <marcel@twokings.nl>
 */

namespace PivotX\CoreBundle;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use PivotX\Core\Component\Routing\RouteService;
use PivotX\Core\Component\Routing\Exception\RouteNotFoundHttpException;

/**
 * Initializes request attributes based on a matching route.
 *
 * @author Marcel Wouters <marcel@twokings.nl>
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

        $this->routeservice = $routeservice;
        $this->routesetup   = $routeservice->getRouteSetup();
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
        $uri = preg_replace('|app(_dev)?[.]php/|','',$uri);

        $routematch = $this->routesetup->matchUrl($uri);

        if (!is_null($routematch)) {
            $protector  = 10;
            while (($routematch->isRewrite()) && ($protector > 0)) {
                $protector--;
                $routematch = $routematch->getRewrite();
            }

            if ($protector == 0) {
                $message = sprintf('Routing rewrite loop for "%s %s"', $request->getMethod(), $uri);
                throw new RouteNotFoundHttpException($message);
            }
        }

        if (!is_null($routematch)) {
            if ($routematch->isRedirect()) {
                list($redirect_routematch,$redirect_status) = $routematch->getRedirect();
                if (is_null($redirect_routematch)) {
                    $message = sprintf('Routing redirect not found for "%s %s"', $request->getMethod(), $uri);
                    throw new RouteNotFoundHttpException($message);
                }
                $redirect_uri = $redirect_routematch->buildUrl(null,false);

                if ($redirect_uri == $uri) {
                    $message = sprintf('Routing redirect loop for "%s %s"', $request->getMethod(), $uri);
                    throw new RouteNotFoundHttpException($message);
                }

                $event->setResponse(new RedirectResponse($redirect_uri,$redirect_status));
                return;
            }

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
}
