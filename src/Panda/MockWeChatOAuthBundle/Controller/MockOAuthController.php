<?php

namespace Panda\MockWeChatOAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MockOAuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function authorizeAction(Request $request)
    {
        $appid          = $request->query->get('appid');
        $redirectUri    = $request->query->get('redirect_uri');
        $responseType   = $request->query->get('response_type');
        $scope          = $request->query->get('scope');
        $state          = $request->query->get('state');

        $code = md5($appid . $scope);
        $uri = $redirectUri . '?code=' . $code;
        $uri .= $state ? '&state=' . $state : '';

        return $this->redirect($uri);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function accessTokenAction(Request $request)
    {
        $appid      = $request->query->get('appid');
        $secret     = $request->query->get('secret');
        $code       = $request->query->get('code');
        $grantType  = $request->query->get('grant_type');

        return new JsonResponse([
            'access_token'  => base64_encode($appid . $secret),
            'expires_in'    => 7200,
            'refresh_token' => 'REFRESH_TOKEN',
            'openid'        => '1234',
            'scope'         => 'snsapi_userinfo'
        ]);
    }
}
