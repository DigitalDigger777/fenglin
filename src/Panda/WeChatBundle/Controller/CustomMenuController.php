<?php

namespace Panda\WeChatBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CustomMenuController
 * @package Panda\WeChatBundle\Controller
 */
class CustomMenuController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        /**
         * @var \Panda\WeChatBundle\WeChatAPI\AccessToken $accessToken
         * @var \Panda\WeChatBundle\Services\WeChat $wechatService
         */
        $accessToken = $this->get('we_chat_api.access_token');
        $wechatService = $this->get('wechat');

        $appId = $this->container->getParameter('wechat_appid');

        $client = new Client([
            'base_uri' => 'https://api.wechat.com'
        ]);

        $response = $client->request('POST', '/cgi-bin/menu/create', [
            'query' => [
                'access_token' => $accessToken->getAccessToken()
            ],
            'body' => json_encode([
                'button' => [
                    [
                        "type" => "view",
                        "name" => "我的返现",
                        "url"  => $wechatService->buildAuthUrl('snsapi_userinfo', 'consumer')
                    ],
                    [
                        "type" => "view",
                        "name" => "商户入口",
                        "url"  => 'http://wxfenling.com/login'
                    ]
                ],
                JSON_UNESCAPED_UNICODE
            ])
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode == 200) {
            $content = $response->getBody()->getContents();
            $responseObject = json_decode($content);
            //$accessToken = $responseObject->access_token;
            $message = 'success';
        } else {
            $responseObject = '';
            $message = 'error';
        }

        return new JsonResponse([
            'message'   => $message,
            'response'  => $responseObject
        ], $statusCode);
    }
}
