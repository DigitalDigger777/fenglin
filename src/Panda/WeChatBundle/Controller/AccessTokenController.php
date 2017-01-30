<?php

namespace Panda\WeChatBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccessTokenController extends Controller
{
    /**
     * Get access token.
     *
     * @return JsonResponse
     */
    public function getAccessTokenAction()
    {
        /**
         * @var \Panda\WeChatBundle\WeChatAPI\AccessToken $accessToken
         */
        $accessToken = $this->get('we_chat_api.access_token');

        return new JsonResponse([
            'message'       => '',
            'access_token'  => $accessToken->getAccessToken()
        ], 200);
    }
}
