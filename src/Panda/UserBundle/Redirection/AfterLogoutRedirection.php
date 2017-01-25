<?php
/**
 * @copyright  Copyright (c) 2009-2014 Steven TITREN - www.webaki.com
 * @package    Webaki\UserBundle\Redirection
 * @author     Steven Titren <contact@webaki.com>
 */
namespace Panda\UserBundle\Redirection;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class AfterLogoutRedirection implements LogoutSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param RouterInterface $router
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(RouterInterface $router, TokenStorageInterface $tokenStorage)
    {
        $this->router       = $router;
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function onLogoutSuccess(Request $request)
    {
        // Get list of roles for current user
        $roles = $this->tokenStorage->getToken()->getRoles();
        // Tranform this list in array
        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);
        // If is a commercial user or admin or super admin we redirect to the login area. Here we used FoseUserBundle bundle
        if (in_array('ROLE_COMMERCIAL', $rolesTab, true) || in_array('ROLE_ADMIN', $rolesTab, true) || in_array('ROLE_SUPER_ADMIN', $rolesTab, true))
            $response = new RedirectResponse($this->router->generate('xu_site_homepage'));
        // otherwise we redirect user to the homepage of website
        else
            $response = new RedirectResponse($this->router->generate('xu_site_homepage'));
        return $response;
    }
}