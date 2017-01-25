<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 26.08.16
 * Time: 18:55
 */

namespace Panda\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class CheckLoginEventListener
 * @package Panda\UserBundle\EventListener
 */
class CheckLoginEventListener
{
    /**
     * @var \Symfony\Component\Routing\Router
     */
    private $router;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;

    /**
     * Constructor.
     *
     * @param $router
     * @param $container
     */
    public function __construct($router, $container)
    {
        $this->router    = $router;
        $this->container = $container;
    }

    /**
     * @param GetResponseEvent $event
     *
     * @throws \Exception
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $currentRoute = $event->getRequest()->get('_route');

        if ($currentRoute == 'user_login' && $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')) {

            $url = $this->router->generate('xu_site_homepage');
            $event->setResponse(new RedirectResponse($url));

        }
    }
}