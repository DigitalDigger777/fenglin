<?php

namespace Fenglin\FenglinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('base.html.twig');
    }

    public function shopperAction()
    {
        return $this->render('base_shopper.html.twig');
    }
}
