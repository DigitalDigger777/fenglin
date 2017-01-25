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
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Class AfterLoginRedirection
 * @package Panda\UserBundle\Redirection
 */
class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;
    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // Get list of roles for current user
        $roles = $token->getRoles();
        // Tranform this list in array
        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);

        if (in_array('ROLE_USER', $rolesTab, true) || in_array('USER_ROLE', $rolesTab, true)) {
            $redirection = new RedirectResponse($this->router->generate('xu_user_setting'));
        }

        if (in_array('ROLE_ADMIN', $rolesTab, true)) {
            $redirection = new RedirectResponse($this->router->generate('xu_admin_user_list'));
        }

        if (in_array('ROLE_SHOPPER', $rolesTab, true)) {
            $redirection = new RedirectResponse($this->router->generate('xu_shopper_setting'));
        }

        if (in_array('IS_AUTHENTICATED_ANONYMOUSLY', $rolesTab, true)) {
            $redirection = new RedirectResponse($this->router->generate('user_login'));
        }

        return $redirection;
    }
}