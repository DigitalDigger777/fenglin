<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 03.03.17
 * Time: 21:13
 */

namespace Panda\WeChatBundle\Services;
use GuzzleHttp\Client;
use Panda\UserBundle\Entity\User;
use Panda\WeChatBundle\Entity\AccessToken;
use Panda\WeChatBundle\Entity\Log;


/**
 * Class WeChat
 * @package Panda\WeChatBundle\Services
 */
class WeChat
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
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
        $appid       = $this->container->getParameter('wechat_appid');
        $baseUri     = $this->container->getParameter('wechat_base_uri_auth');
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

    /**
     * @param string $scope
     * @param null $state
     * @return string
     */
    public function buildQRConnectUrl($scope = 'snsapi_login', $state = null)
    {
        $appid       = $this->container->getParameter('wechat_appid');
        $baseUri     = $this->container->getParameter('wechat_base_uri_auth');
        $redirectUri = $this->container->getParameter('wechat_redirect_uri');

        $url = $baseUri . 'connect/qrconnect';
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

    /**
     * @param $code
     * @param string $grand_type
     * @return bool|mixed|AccessToken
     */
    public function getAccessTokenByCode($code, $grand_type = 'authorization_code')
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \GuzzleHttp\Psr7\Response $response
         */
        $client = new Client([
            'base_uri' => $this->container->getParameter('wechat_base_uri_api')
        ]);

        $response = $client->request('GET', 'sns/oauth2/access_token', [
            'query' => [
                'appid'         => $this->container->getParameter('wechat_appid'),
                'secret'        => $this->container->getParameter('wechat_secret'),
                'code'          => $code,
                'grant_type'    => $grand_type
            ]
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode == 200) {
            $content        = $response->getBody()->getContents();
            $responseObject = json_decode($content);

            if (property_exists($responseObject, 'errcode')) {
                $log = new Log();
                $log->setAction('get access token by code');
                $log->setData($responseObject);
                $log->setDate(new \DateTime());

                $em->persist($log);
                $em->flush();
                return false;
            }

            return $responseObject;
        } else {
            $log = new Log();
            $log->setAction('get access token by code');
            $log->setData([
                'status_code' => $statusCode,
                'content' => $response->getBody()->getContents()
            ]);
            $log->setDate(new \DateTime());
            return false;
        }
    }

    /**
     * @param User $user
     * @return bool|mixed
     */
    public function refreshAccessToken(User $user)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \GuzzleHttp\Psr7\Response $response
         */
        $em = $this->container->get('doctrine')->getManager();
        $client = new Client([
            'base_uri' => $this->container->getParameter('wechat_base_uri_api')
        ]);

        $data = $user->getData();
        echo $data['refresh_token']; exit
        $response = $client->request('GET', 'sns/oauth2/refresh_token', [
            'query' => [
                'appid'         => $this->container->getParameter('wechat_appid'),
                'grant_type'    => 'refresh_token',
                'refresh_token' => $data['refresh_token'],
            ]
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode == 200) {
            $content        = $response->getBody()->getContents();
            $responseObject = json_decode($content);

            if (property_exists($responseObject, 'errcode')) {
                $log = new Log();
                $log->setAction('get access token by code');
                $log->setData($responseObject);
                $log->setDate(new \DateTime());

                $em->persist($log);
                $em->flush();
                return false;
            }

            $user->setData($responseObject);
            $em->persist($user);
            $em->flush();

            return $responseObject;
        } else {
            $log = new Log();
            $log->setAction('get access token by code');
            $log->setData([
                'status_code' => $statusCode,
                'content' => $response->getBody()->getContents()
            ]);
            $log->setDate(new \DateTime());
            return false;
        }
    }

    /**
     * @param $access_token
     * @param $openid
     * @return bool|mixed
     */
    public function getUserInfo($access_token, $openid)
    {
        /**
         * @var \GuzzleHttp\Psr7\Response $response
         */
        $client = new Client([
            'base_uri' => $this->container->getParameter('wechat_base_uri_api')
        ]);

        $response = $client->request('GET', 'sns/userinfo', [
            'query' => [
                'access_token'  => $access_token,
                'openid'        => $openid
            ]
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode == 200) {
            $content        = $response->getBody()->getContents();
            return json_decode($content);
        } else {
            $log = new Log();
            $log->setAction('get user info');
            $log->setData([
                'status_code' => $statusCode,
                'content' => $response->getBody()->getContents()
            ]);
            $log->setDate(new \DateTime());
            return false;
        }
    }


}