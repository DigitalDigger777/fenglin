<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 30.01.17
 * Time: 16:29
 */

namespace Panda\WeChatBundle\WeChatAPI;

use GuzzleHttp\Client;

/**
 * Class AccessToken
 * @package Panda\WeChatBundle\WeChatAPI
 */
class AccessToken
{
    private $container;

    /**
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getAccessToken()
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

        return $accessToken;
    }
}