<?php

namespace Fenglin\CashBackBundle\Controller\Rest;

use Doctrine\ORM\Query;
use Fenglin\CashBackBundle\Entity\CashBack;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CashBackController
 * @package Fenglin\CashBackBundle\Controller
 */
class CashBackController extends Controller
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
                'message' => $this->getMessage()
            ], $this->getCode());
        }
        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();

        $shopperEmail = $this->getUser()->getUsername();
        $qb = $em->createQueryBuilder();
        $qb->select('c')
            ->from('FenglinCashBackBundle:CashBack', 'c')
            ->join('c.shopper', 's')
            ->where($qb->expr()->eq('s.email', ':shopperEmail'))
            ->setParameter(':shopperEmail', $shopperEmail);

        $query = $qb->getQuery();
        try {
            $data = $query->getResult(Query::HYDRATE_ARRAY);
            $this->setData($data);
        } catch (\Exception $e) {
            $this->setCode(500);
            $this->setMessage($e->getMessage());
        }

        $data = $this->getData();
        if (count($data) > 0) {
            $response = new JsonResponse($data, $this->getCode());
        } else {
            $response = new JsonResponse([
                'message' => $this->getMessage()
            ], $this->getCode());
        }
        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmCashBackAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\ConsumerBundle\Entity\Consumer $consumer
         * @var \Panda\ShopperBundle\Entity\Shopper $shopper
         * @var \Fenglin\FenglinBundle\Entity\ConsumerAmount $amountConsumer
         * @var \Fenglin\FenglinBundle\Entity\RefreeTree $refreeTree
         */
        $id = $request->get('id');
        $data = [];
        $shopperEmail = $this->getUser()->getUsername();
        $data['shopper_email'] = $shopperEmail;
        $payable = $this->getRequestParameters($request, 'payable');
        $balance = $this->getRequestParameters($request, 'balance');
        $data['payable'] = $payable;
        $data['balance'] = $balance;

        $em = $this->getDoctrine()->getManager();
        $shopper = $em->getRepository('PandaShopperBundle:Shopper')->findOneBy([
            'email' => $shopperEmail
        ]);
        $consumer = $em->getRepository('PandaConsumerBundle:Consumer')->find($id);


        if ($payable > 0) {
            $rebateLevel    = $shopper->getRebateLevelRate();
            $rebateLevel2   = $shopper->getRebateLevel2Rate();
            $rebateLevel3   = $shopper->getRebateLevel3Rate();

            $amount = ($payable/100) * $rebateLevel;
            $amountLevel2 = ($payable/100) * $rebateLevel2;
            $amountLevel3 = ($payable/100) * $rebateLevel3;

            $cashBack = new CashBack();
            $cashBack->setConsumer($consumer);
            $cashBack->setShopper($shopper);
            $cashBack->setAmount($amount);
            $cashBack->setAmountLevel2($amountLevel2);
            $cashBack->setAmountLevel3($amountLevel3);
            $cashBack->setDate(new \DateTime());
            $cashBack->setStatus(CashBack::STATUS_CONFIRM);

            $em->persist($cashBack);
            $em->flush();

            //update balance current consumer level 1
            $shopperId = $shopper->getId();
            $amountConsumers = $consumer->getAmountConsumers();

            foreach($amountConsumers as $amountConsumer) {
                $amountShopperId = $amountConsumer->getShopper()->getId();
                if ($shopperId == $amountShopperId) {
                    $amountConsumer->setTotalAmount($balance + $amount);
                    $em->persist($amountConsumer);
                    $em->flush();
                }
            }

            //update balance consumer level 2
            $refreeTree = $em->getRepository('FenglinFenglinBundle:RefreeTree')->findOneBy([
                'shopper' => $shopper,
                'consumer' => $consumer
            ]);

            $consumerLevel2 = $refreeTree->getReferalConsumer();

            $amountConsumers = $consumerLevel2->getAmountConsumers();

            foreach($amountConsumers as $amountConsumer) {
                $amountShopperId = $amountConsumer->getShopper()->getId();
                if ($shopperId == $amountShopperId) {
                    $amountConsumer->setTotalAmount($balance + $amount);
                    $em->persist($amountConsumer);
                    $em->flush();
                }
            }

            //update balance consumer level 3
            $refreeTree = $em->getRepository('FenglinFenglinBundle:RefreeTree')->findOneBy([
                'shopper' => $shopper,
                'consumer' => $consumerLevel2
            ]);

            $consumerLevel3 = $refreeTree->getReferalConsumer();

            $amountConsumers = $consumerLevel3->getAmountConsumers();

            foreach($amountConsumers as $amountConsumer) {
                $amountShopperId = $amountConsumer->getShopper()->getId();
                if ($shopperId == $amountShopperId) {
                    $amountConsumer->setTotalAmount($balance + $amount);
                    $em->persist($amountConsumer);
                    $em->flush();
                }
            }
        } else {
            $shopperId = $shopper->getId();
            $amountConsumers = $consumer->getAmountConsumers();

            foreach($amountConsumers as $amountConsumer) {
                $amountShopperId = $amountConsumer->getShopper()->getId();
                if ($shopperId == $amountShopperId) {
                    $amountConsumer->setTotalAmount($balance);
                    $em->persist($amountConsumer);
                    $em->flush();
                }
            }
        }

        //$data = $this->getData();
        if (count($data) > 0) {
            $response = new JsonResponse($data, $this->getCode());
        } else {
            $response = new JsonResponse([
                'message' => $this->getMessage()
            ], $this->getCode());
        }
        return $response;
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function save(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Fenglin\CashBackBundle\Entity\CashBack $item
         */
        $em = $this->getDoctrine()->getManager();
        $isNew = false;
        if ($request->getMethod() == 'POST') {
            $item = new CashBack();
            $item->setDate(new \DateTime());
            $item->setStatus(CashBack::STATUS_NEW);
            $isNew = true;
        }

        if ($request->getMethod() == 'PUT') {
            $id = $request->get('id');
            $item = $em->getRepository('FenglinCashBackBundle:CashBack')->find($id);
            if (!$item) {
                $this->setCode(500);
                $this->setMessage('CashBack not found');
            } else {
                if ($status = $this->getRequestParameters($request, 'status')) {
                    $item->setStatus($status);
                }
            }
        }

        if ($amount = $this->getRequestParameters($request, 'amount')) {
            $item->setAmount($amount);
        } elseif($isNew) {
            $this->setCode(500);
            $this->setMessage('amount not found');
            return false;
        }

        if ($amountLevel2 = $this->getRequestParameters($request, 'amountLevel2')) {
            $item->setAmountLevel2($amountLevel2);
        } elseif($isNew) {
            $this->setCode(500);
            $this->setMessage('amountLevel2 not found');
            return false;
        }

        if ($amountLevel3 = $this->getRequestParameters($request, 'amountLevel3')) {
            $item->setAmountLevel3($amountLevel3);
        } elseif($isNew) {
            $this->setCode(500);
            $this->setMessage('amountLevel3 not found');
            return false;
        }

        if ($consumerId = $this->getRequestParameters($request, 'consumerId')) {

            $consumer = $em->getRepository('PandaConsumerBundle:Consumer')->find($consumerId);
            if ($consumer) {
                $item->setConsumer($consumer);
            } else {
                $this->setCode(500);
                $this->setMessage('consumer not found');
                return false;
            }
        } elseif($isNew) {
            $this->setCode(500);
            $this->setMessage('consumerId not found');
            return false;
        }

        if ($shopperId = $this->getRequestParameters($request, 'shopperId')) {

            $shopper = $em->getRepository('PandaShopperBundle:Shopper')->find($shopperId);
            if ($shopper) {
                $item->setShopper($shopper);
            } else {
                $this->setCode(500);
                $this->setMessage('shopper not found');
                return false;
            }
        } elseif($isNew) {
            $this->setCode(500);
            $this->setMessage('shopperId not found');
            return false;
        }

        try {
            $em->persist($item);
            $em->flush();
            $this->setMessage('Item save successful');
        } catch(\Exception $e) {
            $this->setCode(500);
            $this->setMessage($e->getMessage());
        }
    }

    /**
     * @param Request $request
     */
    private function load(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $qb = $em->createQueryBuilder();
        $qb->select('wr')
            ->from('FenglinCashBackBundle:CashBack', 'wr')
            ->where($qb->expr()->eq('wr.id', ':id'))
            ->setParameter(':id', $id);
        $query = $qb->getQuery();
        try {
            $data = $query->getSingleResult(Query::HYDRATE_ARRAY);
            $this->setData($data);
        } catch (\Exception $e) {
            $this->setCode(500);
            $this->setMessage($e->getMessage());
        }
    }
    /**
     * @param Request $request
     */
    private function delete(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $item = $em->getRepository('FenglinCashBackBundle:CashBack')->find($id);
        if ($item) {
            try {
                $em->remove($item);
                $em->flush();
            } catch(\Exception $e) {
                $this->setCode(500);
                $this->setMessage($e->getMessage());
            }
        } else {
            $this->setCode(500);
            $this->setMessage('Item not found');
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
        if (is_object($this->requestObject) && property_exists($this->requestObject, $parameter)) {
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
