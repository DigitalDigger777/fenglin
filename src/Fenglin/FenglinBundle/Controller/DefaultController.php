<?php

namespace Fenglin\FenglinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FenglinFenglinBundle:Default:index.html.twig');
    }
}
