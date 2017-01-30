<?php

namespace Panda\WeChatBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CustomMenuController
 * @package Panda\WeChatBundle\Controller
 */
class CustomMenuController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://api.wechat.com'
        ]);

        $response = $client->request('POST', '/cgi-bin/menu/create', [
            'query' => [
                'access_token' => 'oza6PE29j5j_-W6puC-vO7R5bF9-FjfmPZ0VkeFV5jnhSUy1nYK17Po3-zGF8m6nz4QCAY40k-8bnGbNlIPUwYcErjflKyaHZCS6zVPnuWzR-XwInsNMO8ovXAjixvEHGPBeADAJSE'
            ],
            'body' => json_encode([
                'button' => [
                    [
                        "type" => "view",
                        "name" => "Home",
                        "url" => "http://xu.joinppcg.com/fenglin/fenglin/src/after-link-this-shopper-but-no-balance.html"
                    ]
                ]
            ])
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
