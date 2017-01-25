<?php

namespace Panda\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PandaUserBundle:Default:index.html.twig');
    }
}
