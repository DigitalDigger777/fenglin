<?php

namespace Panda\ConsumerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('PandaConsumerBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function readQRAction(Request $request)
    {
        $shopperId = $request->get('memberId');

        return $this->render('consumer/read_qr.html.twig', [
            'shopperId' => $shopperId
        ]);
    }
}
