<?php
namespace Panda\ShopperBundle\Controller\Rest;

use Doctrine\ORM\Query;
use Panda\ShopperBundle\Entity\Shopper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Shopper QR Controller
 * @package Panda\ShopperBundle\Controller\Rest
 */
class ShopperQRController extends Controller
{
    /**
     * @var int
     */
    private $code = 200;
    /**
     * @var string
     */
    private $message = '';
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var array
     */
    private $requestObject = null;
    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    /**
     * Index action.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        if ($this->getMethod($request) == 'POST' || $this->getMethod($request) == 'PUT') {
            $this->save($request);
        }

        if ($this->getMethod($request) == 'GET') {
            $this->load($request);
        }

        if ($this->getMethod($request) == 'DELETE') {
            $this->delete($request);
        }

        $data = $this->getData();


        if (count($data) > 0) {
            $response = new JsonResponse($data, $this->getCode());
        } else {
            $response = new JsonResponse([
                'message' => $this->getMessage(),
                'data' => $data
            ], $this->getCode());
        }

        $callback = $this->getRequestParameters($request, 'callback');
        if ($callback) {
            $response->setCallback($callback);
        }

        return $response;
    }

    /**
     * @return JsonResponse
     */
    public function getTicketAction()
    {
        /**
         * @var \Panda\WeChatBundle\Services\WeChat $wechatService
         * @var \Panda\WeChatBundle\Entity\AccessToken $accessToken
         */
        $wechatService  = $this->get('wechat');
        $accessTokenObject = $wechatService->getAccessToken();
        $accessToken = $accessTokenObject->access_token;
        $ticketObject = $wechatService->createQRCodeTicket($accessToken);

//        var_dump($ticketObject);
//        exit;
        return new JsonResponse($ticketObject);
    }

    /**
     * Get request parameter.
     *
     * @param Request $request
     * @param $parameter
     * @return mixed|null
     */
    private function getRequestParameters(Request $request, $parameter)
    {
        $value = null;

        if (!$this->requestObject) {
            $this->requestObject = json_decode($request->getContent());
        }

        if ($this->requestObject && property_exists($this->requestObject, $parameter)) {

            $value = $this->requestObject->{$parameter};

        } elseif ($request->query->get($parameter)) {

            $value = $request->query->get($parameter);

        } elseif ($request->request->get($parameter)) {

            $value = $request->request->get($parameter);

        }
        return $value;
    }

    /**
     * This method need for compatibility async cross domain requests.
     *
     * @param Request $request
     * @return mixed|null|string
     */
    private function getMethod(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            if ($method = $this->getRequestParameters($request, 'method')) {
                return $method;
            }
        }
        return $request->getMethod();
    }

}