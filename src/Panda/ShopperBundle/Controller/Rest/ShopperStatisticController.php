<?php

namespace Panda\ShopperBundle\Controller\Rest;

use Doctrine\ORM\Query;
use Panda\ShopperBundle\Entity\Shopper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Shopper Statistic Controller
 * @package Panda\ShopperBundle\Controller\Rest
 */
class ShopperStatisticController extends Controller
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

        if ($this->getMethod($request) == 'GET_TOTAL_SPENT') {
            $this->loadTotalSpent($request);
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
     * @param Request $request
     */
    private function loadTotalSpent(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\ShopperBundle\Repository\ShopperRepository $shopperRepo
         * @var \Fenglin\FenglinBundle\Repository\FollowStatisticRepository $followStatisticRepo
         */
        $em     = $this->getDoctrine()->getManager();
        $shopperRepo = $em->getRepository('PandaShopperBundle:Shopper');
        $followStatisticRepo = $em->getRepository('FenglinFenglinBundle:FollowStatistic');

        $apikey = $this->getRequestParameters($request, 'apikey');

        try {
            $totalSpent = $shopperRepo->getTotalSpent($apikey);
            $todayMemberConsumed = $shopperRepo->getTodayMemberConsumed($apikey);
            $todayConsumed  = $shopperRepo->getTodayConsumed($apikey);
            $todayCashback  = $shopperRepo->getTodayCashback($apikey);
            $todaySpent     = $shopperRepo->getTodaySpent($apikey);
            $todayPayable   = $shopperRepo->getTodayPayable($apikey);

            $shopperArray['totalSpent'] = $totalSpent ? $totalSpent : 0;
            $shopperArray['todayMemberConsumed'] = $todayMemberConsumed ? $todayMemberConsumed : 0;
            $shopperArray['todayConsumed'] = $todayConsumed ? $todayConsumed : 0;
            $shopperArray['todayCashback'] = $todayCashback ? $todayCashback : 0;
            $shopperArray['todaySpent'] = $todaySpent ? $todaySpent : 0;
            $shopperArray['todayPayable'] = $todayPayable ? $todayPayable : 0;
            $shopperArray['totalJoinedConsumers'] = $followStatisticRepo->getCountFollow($apikey);
            $shopperArray['totalConsumers'] = $shopperRepo->getTotalMembers($apikey);

            //wechat redirect options
            //$shopperArray['domain'] = $this->container->getParameter('wechat_domain');
            //$shopperArray['biz'] = $this->container->getParameter('wechat_biz');
            $this->setData($shopperArray);
        } catch (\Exception $e) {
            $this->setCode(500);
            $this->setMessage($e->getMessage());
        }
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

    /**
     * @return string
     */
    private function getRandomPassword()
    {
        $chars = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        $len = strlen($chars);
        $pass = '';
        for ($i = 0; $i < 6; $i++) {
            $pass .= substr($chars, rand(0, $len - 1), 1);
        }

        return $pass;
    }
}