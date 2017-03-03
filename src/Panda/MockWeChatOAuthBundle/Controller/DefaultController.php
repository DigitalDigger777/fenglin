<?php

namespace Panda\MockWeChatOAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        /**
         * @var \Panda\WeChatBundle\Services\WeChat $wechatService
         */
        $wechatService = $this->get('wechat');
        $url = $wechatService->buildAuthUrl('snsapi_userinfo', 123);

        return $this->render('PandaMockWeChatOAuthBundle:Default:index.html.twig',[
            'url' => $url
        ]);
    }
}
