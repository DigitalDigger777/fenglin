<?php

namespace Panda\WeChatBundle\Controller;

use GuzzleHttp\Client;
use Panda\ConsumerBundle\Entity\Consumer;
use Panda\ShopperBundle\Entity\Shopper;
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
         * @var \Panda\UserBundle\Entity\User $user
         * @var \Panda\WeChatBundle\Entity\AccessToken $accessToken
         */
        $wechatService  = $this->get('wechat');
        $code           = $request->query->get('code', 0);
        $state          = $request->query->get('state', 0);

        $em = $this->getDoctrine()->getManager();

        $openid = $request->cookies->get('openid');

        if ($openid) {
            $user = $em->getRepository('PandaUserBundle:User')->findOneBy([
                'openId' => $openid
            ]);

        } else {
            $user = null;
        }


        if (!$user) {
            $responseObject = $wechatService->getAccessTokenByCode($code);
            //print_r($responseObject); exit;
            if ($responseObject) {
                $responseObjectUserInfo = $wechatService->getUserInfo($responseObject->access_token, $responseObject->openid);

                if (property_exists($responseObjectUserInfo, 'errcode')) {

                    $wechatService->writeToLog('get userinfo', $responseObject);

                } else {

                    $user = $em->getRepository('PandaUserBundle:User')->findOneBy([
                        'openId' => $responseObject->openid
                    ]);

                    if ($state == 'consumer') {
                        if (!$user) {
                            $user = new Consumer();
                        }
                    } elseif ($state == 'shopper') {
                        if (!$user) {
                            $user = new Shopper();
                        }
                    }

                    $user->setApiKey(md5($responseObject->openid));
                    if ($state == 'consumer') {
                        $user->setRole('ROLE_CONSUMER');
                    } elseif($state == 'shopper') {
                        $user->setRole('ROLE_SHOPPER');
                    }
                    $user->setStatus(1);
                    $user->setEmail(md5($responseObject->openid) . '@mock.com');
                    $user->setPassword('');
                    $user->setOpenId($responseObject->openid);
                    $user->setData($responseObject);
                    $user->setWechatData($responseObjectUserInfo);
                    $user->setMemberId(crc32($responseObject->openid));

                    $em->persist($user);
                    $em->flush();
                }
            }
        } else {

//            $wechatData = $user->getWechatData();
            $responseObject = $wechatService->getAccessTokenByCode($code);

            if (property_exists($responseObject, 'errcode')) {
                $wechatService->writeToLog('get access token', $responseObject);
            } else {
                $responseObjectUserInfo = $wechatService->getUserInfo($responseObject->access_token, $user->getOpenId());

                if (property_exists($responseObjectUserInfo, 'errcode')) {
                    $wechatService->writeToLog('get user info', $responseObjectUserInfo);
                } else {
                    $user->setData($responseObject);
                    $user->setWechatData($responseObjectUserInfo);

                    $em->persist($user);
                    $em->flush();
                }
            }
        }


        if ($state == 'consumer') {
            $response = new RedirectResponse(
                $this->generateUrl('fenglin_fenglin_homepage', [
                    'apikey' => $user->getApiKey(),
                    '_fragment' => 'consumer/home'
                ])
            );
        } else {
            $response = new RedirectResponse(
                $this->generateUrl('fenglin_fenglin_shopper', [
                    'apikey' => $user->getApiKey(),
                    '_fragment' => 'shopper/login'
                ])
            );
        }


        if (!$request->cookies->get('openid')) {
            $cookie = new Cookie('openid', $user->getOpenId());
            $response->headers->setCookie($cookie);
        }

        return $response;
    }

}
