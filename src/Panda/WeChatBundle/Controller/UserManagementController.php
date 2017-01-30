<?php

namespace Panda\WeChatBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserManagementController
 * @package Panda\WeChatBundle\Controller
 */
class UserManagementController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function followerListAction(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://api.wechat.com'
        ]);

        $response = $client->request('GET', '/cgi-bin/user/get', [
            'query' => [
                'access_token' => 'H_jAEbVEy1x88A53X7FODFqr6SbiLt7RmCwc9vS21zNqMNWVBvJJobZ4lFUBjyoxJtnKRHRrJWCag0yL5qk2xiq5C3Ukkp2NGgGEIHRZ7bNToQSYVEWHHhdU0pNM-VOkYMWfAFAQEO'
            ]
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

    public function profileAction(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://api.wechat.com'
        ]);

        $response = $client->request('GET', '/cgi-bin/user/info', [
            'query' => [
                'access_token' => 'H_jAEbVEy1x88A53X7FODFqr6SbiLt7RmCwc9vS21zNqMNWVBvJJobZ4lFUBjyoxJtnKRHRrJWCag0yL5qk2xiq5C3Ukkp2NGgGEIHRZ7bNToQSYVEWHHhdU0pNM-VOkYMWfAFAQEO',
                'openid' => 'oc-vDwrHhz3KzLOmuFFfFqCOKfiE',
                'lang' => 'en_US'
            ]
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
