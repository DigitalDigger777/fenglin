<?php

namespace Panda\ConsumerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PandaConsumerBundle:Default:index.html.twig');
    }
}
