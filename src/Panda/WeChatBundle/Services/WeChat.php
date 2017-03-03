<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 03.03.17
 * Time: 21:13
 */

namespace Panda\WeChatBundle\Services;

/**
 * Class WeChat
 * @package Panda\WeChatBundle\Services
 */
class WeChat
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
     * @param string $scope
     * @param null $state
     * @return array|string
     */
    public function buildAuthUrl($scope = 'snsapi_userinfo', $state = null)
    {
        $appid = $this->container->getParameter('wechat_appid');
        $baseUri = $this->container->getParameter('wechat_base_uri_api');
        $redirectUri = $this->container->getParameter('wechat_redirect_uri');

        $url = $baseUri . 'connect/oauth2/authorize';
        $urlParts = [
            'appid=' . $appid,
            'redirect_uri=' . urlencode($redirectUri),
            'response_type=code',
            'scope=' . $scope
        ];

        if ($state) {
            $urlParts[] = 'state=' . $state;
        }

        $url .= '?' . implode('&', $urlParts);

        return $url;
    }
}