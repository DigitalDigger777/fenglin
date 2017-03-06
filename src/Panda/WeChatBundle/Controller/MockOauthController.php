<?php

namespace Panda\WeChatBundle\Controller;

use GuzzleHttp\Client;
use Panda\UserBundle\Entity\User;
use Panda\WeChatBundle\Entity\Log;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class MockOauthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function authAction(Request $request)
    {
        //http://dev.fenglin/app_dev.php/mock-wechat-oauth/connect/oauth2/authorize?appid=wx70d2ff5978524a23&redirect_uri=http%3A%2F%2Fdev.fenglin%2Fapp_dev.php%2Fpanda-we-chat%2Fmock-oauth%2Fget-code-response&response_type=code&scope=snsapi_userinfo&state=123
        //on this acction wechat redirect after user allow permission
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\WeChatBundle\Services\WeChat $wechatService
         */
        $wechatService = $this->get('wechat');
        $em = $this->getDoctrine()->getManager();

        $log = new Log();
        $log->setAction('get_code');
        $log->setData([
            'code' => $request->query->get('code', 0),
            'state' => $request->query->get('state', 0)
        ]);
        $log->setDate(new \DateTime());
        $em->persist($log);
        $em->flush();

        $code = $request->query->get('code');
        $responseObject = $wechatService->getAccessTokenByCode($code);

        if ($responseObject) {
            if (property_exists($responseObject, 'errcode')) {
                $log = new Log();
                $log->setAction('get access token by code');
                $log->setData($responseObject);
                $log->setDate(new \DateTime());

                $em->persist($log);
                $em->flush();
            } else {

                $responseObjectUserInfo = $wechatService->getUserInfo($responseObject->access_token, $responseObject->openid);

                if (property_exists($responseObjectUserInfo, 'errcode')) {
                    $log = new Log();
                    $log->setAction('get userinfo');
                    $log->setData($responseObject);
                    $log->setDate(new \DateTime());

                    $em->persist($log);
                    $em->flush();
                } else {
                    $user = $em->getRepository('PandaUserBundle:User')->findOneBy([
                        'apiKey' => md5($responseObject->openid)
                    ]);

                    if (!$user) {
                        $user = new User();
                        $user->setApiKey(md5($responseObject->openid));
                        $user->setRole('ROLE_CONSUMER');
                        $user->setStatus(1);
                        $user->setEmail(md5($responseObject->openid) . '@mock.com');
                        $user->setPassword('');
                        $user->setOpenId($responseObject->openid);
                        $user->setData($responseObject);
                        $user->setWechatData($responseObjectUserInfo);

                        $em->persist($user);
                        $em->flush();
                    }
                }
            }
        }

        $client = new Client([
            'base_uri' => $this->container->getParameter('wechat_base_uri_api')
        ]);

        $response = $client->request('GET', 'sns/oauth2/access_token', [
            'query' => [
                'appid'         => $this->container->getParameter('wechat_appid'),
                'secret'        => $this->container->getParameter('wechat_secret'),
                'code'          => $request->query->get('code'),
                'grant_type'    => 'authorization_code'
            ]
        ]);


        $response = new RedirectResponse(
            $this->generateUrl('fenglin_fenglin_homepage', [
                'apikey' => $user->getApiKey(),
                '_fragment'=>'consumer/home'
            ])
        );
        if (!$request->cookies->get('access_token')) {
            $cookie = new Cookie('access_token', $responseObject->access_token);
            $response->headers->setCookie($cookie);
        }

        if (!$request->cookies->get('apikey')) {
            $cookie = new Cookie('apikey', $user->getApiKey());
            $response->headers->setCookie($cookie);
        }

        return $response;
    }

    public function getAccessToken()
    {
        //get access token with Code
    }

    public function updateAccessToken()
    {

    }
}
