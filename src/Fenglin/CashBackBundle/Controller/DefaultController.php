<?php

namespace Fenglin\CashBackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FenglinCashBackBundle:Default:index.html.twig');
    }
}
