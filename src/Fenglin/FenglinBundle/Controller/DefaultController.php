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

//        $log = new AuthorizationLog();
//        $log->setCode($code);
//        $log->setState($state);
//        $log->setIp($ip);
//        $log->setDate($date);
//
//        $em->persist($log);
//        $em->flush();
        //check auth
//        $user = $this->getUser();
//        var_dump($user);
//        exit;
        return $this->render('base.html.twig');
    }

    public function consumerAction()
    {
        return $this->render('base.html.twig');
    }

    public function shopperAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $apikey = $request->query->get('apikey');
        $shopper = $em->getRepository('PandaShopperBundle:Shopper')->findOneBy([
            'apiKey' => $apikey
        ]);

        return $this->render('base_shopper.html.twig', [
            'shopper' => $shopper
        ]);
    }
}
