<?php

namespace Fenglin\FenglinBundle\Controller;

use Fenglin\FenglinBundle\Entity\AuthorizationLog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $code = $request->query->get('code');
        $state = $request->query->get('state');
        $date = new \DateTime();
        $ip = $request->getClientIp();

        $log = new AuthorizationLog();
        $log->setCode($code);
        $log->setState($state);
        $log->setIp($ip);
        $log->setDate($date);

        $em->persist($log);
        $em->flush();

        return $this->render('base.html.twig');
    }

    public function shopperAction()
    {
        return $this->render('base_shopper.html.twig');
    }
}
