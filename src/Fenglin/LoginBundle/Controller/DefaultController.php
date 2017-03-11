<?php

namespace Fenglin\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $tel = $request->request->get('tel');
        $password = $request->request->get('password');

        if ($tel && $password) {
            return $this->auth($request);
        }

        return $this->render('fenglin/login/login.html.twig');
    }

    public function exampleAction(Request $request)
    {
        $memberId = $request->query->get('member_id');
        return new Response("Member ID: " . $memberId);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    private function auth(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\ShopperBundle\Entity\Shopper $shopper
         */
        $encoder = $this->container->get('security.password_encoder');

        $em          = $this->getDoctrine()->getManager();
        $shopperRepo = $em->getRepository('PandaShopperBundle:Shopper');
        $adminRepo = $em->getRepository('FenglinAdminBundle:Admin');

        $tel         = $request->request->get('tel');
        $password    = $request->request->get('password');

        $shopper = $shopperRepo->findOneBy(['tel' => $tel]);
        $admin = $adminRepo->findOneBy(['tel' => $tel]);

        if ($shopper) {
            $password = $encoder->encodePassword($shopper, $password);

            if ($password == $shopper->getPassword()) {
                return $this->redirect($request->getSchemeAndHttpHost() . '/shopper?apikey=' . $shopper->getApiKey() . '#shopper/home');
            } else {
                return new Response('Password not correct', 403);
            }


        } elseif ($admin) {
            $password = $encoder->encodePassword($admin, $password);

            if ($password == $admin->getPassword()) {
                return $this->redirect($request->getSchemeAndHttpHost() . '/admin?apikey=' . $admin->getApiKey() . '#admin/shopper/inactive-reactive/account');
            } else {
                return new Response('Password not correct', 403);
            }


        } else {
            return new Response('Shopper with tel ' . $tel . 'not found', 403);
        }

        return new Response('Phone number or password is not correct', 403);
    }
}
