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
         */
        $accessToken = $this->get('we_chat_api.access_token');
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
                        "name" => "Home",
                        "url"  => "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appId&redirect_uri=http%3A%2F%2Ffenglin.joinppcg.com&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "Shopper",
                        "url"  => "http://fenglin.joinppcg.com/shopper#shopper/home"
                    ]
                ]
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
