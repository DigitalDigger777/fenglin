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
         * @var \Panda\UserBundle\Entity\User $user
         * @var \Panda\WeChatBundle\Entity\AccessToken $accessToken
         */
        $wechatService  = $this->get('wechat');
        $code           = $request->query->get('code', 0);

        $em = $this->getDoctrine()->getManager();

//        $log = new Log();
//        $log->setAction('get_code');
//        $log->setData([
//            'code' => $code,
//            'state' => $request->query->get('state', 0)
//        ]);
//        $log->setDate(new \DateTime());
//        $em->persist($log);
//        $em->flush();

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

            if ($responseObject) {
                $responseObjectUserInfo = $wechatService->getUserInfo($responseObject->access_token, $responseObject->openid);

                if (property_exists($responseObjectUserInfo, 'errcode')) {

                    $wechatService->writeToLog('get userinfo', $responseObject);

                } else {

                    $user = $em->getRepository('PandaUserBundle:User')->findOneBy([
                        'openId' => $responseObject->openid
                    ]);

                    if (!$user) {
                        $user = new User();
                    }

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


        $response = new RedirectResponse(
            $this->generateUrl('fenglin_fenglin_homepage', [
                'apikey' => $user->getApiKey(),
                '_fragment'=>'consumer/home'
            ])
        );


        if (!$request->cookies->get('openid')) {
            $cookie = new Cookie('openid', $user->getOpenId());
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
