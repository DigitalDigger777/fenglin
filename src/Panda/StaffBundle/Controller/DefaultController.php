<?php

namespace Panda\StaffBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PandaStaffBundle:Default:index.html.twig');
    }
}
