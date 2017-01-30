<?php

namespace Panda\WeChatBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class OauthController extends Controller
{
    /**
     * Get access token.
     *
     * @return JsonResponse
     */
    public function getAccessTokenAction()
    {
        $client = new Client([
            'base_uri' => 'https://api.wechat.com'
        ]);

        $response = $client->request('GET', '/cgi-bin/token', [
            'query' => [
                'grant_type' => $this->container->getParameter('wechat_grant_type'),
                'appid'      => $this->container->getParameter('wechat_appid'),
                'secret'     => $this->container->getParameter('wechat_secret')
            ]
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode == 200) {
            $content = $response->getBody()->getContents();
            $responseObject = json_decode($content);
            $accessToken = $responseObject->access_token;
            $message = 'success';
        } else {
            $accessToken = '';
            $message = 'error';
        }

        return new JsonResponse([
            'message'       => $message,
            'access_token'  => $accessToken
        ], $statusCode);
    }
}
