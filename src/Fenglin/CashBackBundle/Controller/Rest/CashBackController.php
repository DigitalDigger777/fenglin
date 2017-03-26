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
     * @var \Panda\ShopperBundle\Entity\Shopper
     */
    private $shopper;

    /**
     * @var \Panda\ConsumerBundle\Entity\Consumer
     */
    private $consumer;

    /**
     * @var \Panda\ConsumerBundle\Entity\Consumer
     */
    private $consumerLevel2;

    /**
     * @var \Panda\ConsumerBundle\Entity\Consumer
     */
    private $consumerLevel3;

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
     * @return \Panda\ShopperBundle\Entity\Shopper
     */
    public function getShopper()
    {
        return $this->shopper;
    }

    /**
     * @param \Panda\ShopperBundle\Entity\Shopper $shopper
     */
    public function setShopper($shopper)
    {
        $this->shopper = $shopper;
    }

    /**
     * @return \Panda\ConsumerBundle\Entity\Consumer
     */
    public function getConsumer()
    {
        return $this->consumer;
    }

    /**
     * @param \Panda\ConsumerBundle\Entity\Consumer $consumer
     */
    public function setConsumer($consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     * @return \Panda\ConsumerBundle\Entity\Consumer
     */
    public function getConsumerLevel2()
    {
        return $this->consumerLevel2;
    }

    /**
     * @param \Panda\ConsumerBundle\Entity\Consumer $consumerLevel2
     */
    public function setConsumerLevel2($consumerLevel2)
    {
        $this->consumerLevel2 = $consumerLevel2;
    }

    /**
     * @return \Panda\ConsumerBundle\Entity\Consumer
     */
    public function getConsumerLevel3()
    {
        return $this->consumerLevel3;
    }

    /**
     * @param \Panda\ConsumerBundle\Entity\Consumer $consumerLevel3
     */
    public function setConsumerLevel3($consumerLevel3)
    {
        $this->consumerLevel3 = $consumerLevel3;
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
        $roles = $this->getUser()->getRoles();

        if ($roles[0] == 'ROLE_STAFF') {
            $this->setCode(403);
            $this->setMessage('Access Denied');

            return new JsonResponse([
                'message' => $this->getMessage()
            ], $this->getCode());
        }

        $shopperEmail = $this->getUser()->getUsername();
        $qb = $em->createQueryBuilder();
        $qb->select('c, cns, ca, s')
            ->from('FenglinCashBackBundle:CashBack', 'c')
            ->join('c.shopper', 's')
            ->join('c.consumer', 'cns')
            ->join('cns.amountConsumers', 'ca')
            ->join('ca.shopper', 'ss', 'WITH', 'ss.email=:shopperEmail')
            ->where($qb->expr()->eq('s.email', ':shopperEmail'))
            ->orderBy('c.date', 'DESC')
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
     * @throws \Exception
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
        $em = $this->getDoctrine()->getManager();


        $id = $request->get('id');
        $data = [];

        $shopperEmail = $this->getShopperEmail();

        $data['shopper_email'] = $shopperEmail;
        $payable = $this->getRequestParameters($request, 'payable');
        $balance = $this->getRequestParameters($request, 'balance');
        $data['payable'] = $payable;
        $data['balance'] = $balance;


        $shopper = $em->getRepository('PandaShopperBundle:Shopper')->findOneBy([
            'email' => $shopperEmail
        ]);
        $consumer = $em->getRepository('PandaConsumerBundle:Consumer')->find($id);
        $this->setConsumer($consumer);
        $this->setShopper($shopper);

        if ($payable > 0) {
            $rebateLevel    = $shopper->getRebateLevelRate();
            $rebateLevel2   = $shopper->getRebateLevel2Rate();
            $rebateLevel3   = $shopper->getRebateLevel3Rate();

            $amount = ($payable/100) * $rebateLevel;
            $amountLevel2 = ($payable/100) * $rebateLevel2;
            $amountLevel3 = ($payable/100) * $rebateLevel3;

            $transactionId = $this->cashBack($payable, $amount, $amountLevel2, $amountLevel3);
            $returnBalance = $this->calcBalance($balance, $amount, $amountLevel2, $amountLevel3);
            $data['transactionId'] = $transactionId;
            $data['balance'] = $returnBalance;

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
     * @return JsonResponse
     * @throws \Exception
     */
    public function confirmCashBackListAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\ConsumerBundle\Entity\Consumer $consumer
         * @var \Panda\ShopperBundle\Entity\Shopper $shopper
         * @var \Fenglin\FenglinBundle\Entity\ConsumerAmount $amountConsumer
         * @var \Fenglin\FenglinBundle\Entity\RefreeTree $refreeTree
         * @var \Fenglin\FenglinBundle\Entity\RefreeTree $refreeTreeLevel2
         * @var \Fenglin\FenglinBundle\Entity\RefreeTree $refreeTreeLevel3
         */
        $em = $this->getDoctrine()->getManager();
        $transactionId     = $this->getRequestParameters($request, 'transactionId');

        $shopperEmail = $this->getShopperEmail();

        $qb = $em->createQueryBuilder();
        $qb->select('c, cns, ca, s')
            ->from('FenglinCashBackBundle:CashBack', 'c')
            ->join('c.consumer', 'cns')
            ->join('cns.amountConsumers', 'ca')
            ->join('ca.shopper', 's', 'WITH', 's.email=:email')
            ->where($qb->expr()->eq('c.transactionId', ':transactionId'))
            ->orderBy('c.id', 'ASC')
            ->setParameter(':transactionId', $transactionId)
            ->setParameter(':email', $shopperEmail);

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
     * @param $payable
     * @param $amountLevel
     * @param $amountLevel2
     * @param $amountLevel3
     * @return string
     */
    private function cashBack($payable, $amountLevel, $amountLevel2, $amountLevel3)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $consumer = $this->getConsumer();
        $shopper = $this->getShopper();

        $transactionId = $consumer->getId() . '|' . time();
        $cashBack = new CashBack();
        $cashBack->setConsumer($consumer);
        $cashBack->setShopper($shopper);
        $cashBack->setPayable($payable);
        $cashBack->setAmount($amountLevel);
        $cashBack->setAmountLevel2($amountLevel2);
        $cashBack->setAmountLevel3($amountLevel3);
        $cashBack->setDate(new \DateTime());
        $cashBack->setStatus(CashBack::STATUS_CONFIRM);
        $cashBack->setTransactionId($transactionId);
        $em->persist($cashBack);
        $em->flush();

        //level 2
        //echo $shopper->getId() . '|' . $consumer->getId(); exit;
        $refreeTree = $em->getRepository('FenglinFenglinBundle:RefreeTree')->findOneBy([
            'shopper'  => $shopper,
            'consumer' => $consumer
        ]);

        if ($refreeTree) {
            $consumerLevel2 = $refreeTree->getReferalConsumer();
            $this->setConsumerLevel2($consumerLevel2);

            $cashBack = new CashBack();
            $cashBack->setConsumer($consumerLevel2);
            $cashBack->setShopper($shopper);
            $cashBack->setAmount($amountLevel2);
            $cashBack->setAmountLevel2(0);
            $cashBack->setAmountLevel3(0);
            $cashBack->setDate(new \DateTime());
            $cashBack->setStatus(CashBack::STATUS_CONFIRM);
            $cashBack->setTransactionId($transactionId);
            $em->persist($cashBack);
            $em->flush();

            //level 3
            $refreeTree = $em->getRepository('FenglinFenglinBundle:RefreeTree')->findOneBy([
                'shopper'  => $shopper,
                'consumer' => $consumerLevel2
            ]);

            if ($refreeTree) {
                $consumerLevel3 = $refreeTree->getReferalConsumer();
                $this->setConsumerLevel3($consumerLevel3);

                $cashBack = new CashBack();
                $cashBack->setConsumer($consumerLevel3);
                $cashBack->setShopper($shopper);
                $cashBack->setAmount($amountLevel3);
                $cashBack->setAmountLevel2(0);
                $cashBack->setAmountLevel3(0);
                $cashBack->setDate(new \DateTime());
                $cashBack->setStatus(CashBack::STATUS_CONFIRM);
                $cashBack->setTransactionId($transactionId);
                $em->persist($cashBack);
                $em->flush();
            }
        }

        return $cashBack->getTransactionId();
    }

    /**
     * @param $balance
     * @param $amountLevel
     * @param $amountLevel2
     * @param $amountLevel3
     * @return int
     */
    private function calcBalance($balance, $amountLevel, $amountLevel2, $amountLevel3)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Fenglin\FenglinBundle\Entity\ConsumerAmount $amountConsumer
         */
        $em = $this->getDoctrine()->getManager();

        $consumer   = $this->getConsumer();
        $consumerLevel2 = $this->getConsumerLevel2();
        $consumerLevel3 = $this->getConsumerLevel3();

        $shopper    = $this->getShopper();
        $shopperId  = $shopper->getId();
        $returnBalanceForConsumer = 0;

        //level 1
        $amountConsumers = $consumer->getAmountConsumers();

        foreach($amountConsumers as $amountConsumer) {
            $amountShopperId = $amountConsumer->getShopper()->getId();
            if ($shopperId == $amountShopperId) {
                $amountConsumer->setTotalAmount($balance + $amountLevel);
                $em->persist($amountConsumer);
                $em->flush();

                $returnBalanceForConsumer = $balance + $amountLevel;
            }
        }

        //level 2
        if ($consumerLevel2) {
            $amountConsumers = $consumerLevel2->getAmountConsumers();

            foreach ($amountConsumers as $amountConsumer) {
                $amountShopperId = $amountConsumer->getShopper()->getId();
                if ($shopperId == $amountShopperId) {
                    $balanceLevel2 = $amountConsumer->getTotalAmount();
                    $amountConsumer->setTotalAmount($balanceLevel2 + $amountLevel2);
                    $em->persist($amountConsumer);
                    $em->flush();
                }
            }
        }

        //level 3
        if ($consumerLevel3) {
            $amountConsumers = $consumerLevel3->getAmountConsumers();

            foreach ($amountConsumers as $amountConsumer) {
                $amountShopperId = $amountConsumer->getShopper()->getId();
                if ($shopperId == $amountShopperId) {
                    $balanceLevel3 = $amountConsumer->getTotalAmount();
                    $amountConsumer->setTotalAmount($balanceLevel3 + $amountLevel3);
                    $em->persist($amountConsumer);
                    $em->flush();
                }
            }
        }

        return $returnBalanceForConsumer;
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
     * @return mixed
     * @throws \Exception
     */
    private function getShopperEmail()
    {
        $em = $this->getDoctrine()->getManager();
        $roles = $this->getUser()->getRoles();

        if ($roles[0] == 'ROLE_SHOPPER') {

            $shopperEmail = $this->getUser()->getUsername();

        } elseif ($roles[0] == 'ROLE_STAFF') {

            $staffEmail   = $this->getUser()->getUsername();
            $staffRepo    = $em->getRepository('PandaStaffBundle:Staff');
            $staff        = $staffRepo->findOneBy(['email'=>$staffEmail]);
            $shopperEmail = $staff->getShopper()->getEmail();

        } else {
            throw new \Exception('Access Denied');
        }

        return $shopperEmail;
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
