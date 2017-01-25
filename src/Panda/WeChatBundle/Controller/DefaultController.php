<?php

namespace Panda\WeChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PandaWeChatBundle:Default:index.html.twig');
    }
}
