<?php

namespace Panda\WeChatBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UrlController extends Controller
{
    /**
     * @return string
     */
    public function getQRConnectUrlAction()
    {
        /**
         * @var \Panda\WeChatBundle\Services\WeChat $wechatService
         */
        $wechatService = $this->get('wechat');
        $url = $wechatService->buildQRConnectUrl('snsapi_userinfo', 123);
        return new Response($url);
    }

    /**
     * @return string
     */
    public function getCodeUrlAction()
    {
        /**
         * @var \Panda\WeChatBundle\Services\WeChat $wechatService
         */
        $wechatService = $this->get('wechat');
        $url = $wechatService->buildAuthUrl('snsapi_userinfo', 123);
        return new Response($url);
    }
}
