<?php

namespace Panda\ShopperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PandaShopperBundle:Default:index.html.twig');
    }
}
