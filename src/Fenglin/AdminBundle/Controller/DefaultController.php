<?php

namespace Fenglin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FenglinAdminBundle:Default:index.html.twig');
    }

    public function loginPageAction()
    {
        return $this->render('base_admin.html.twig');
    }
}
