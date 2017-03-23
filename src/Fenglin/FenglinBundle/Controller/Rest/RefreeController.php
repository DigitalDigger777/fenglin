<?php

namespace Fenglin\FenglinBundle\Controller\Rest;

use Fenglin\FenglinBundle\Entity\AuthorizationLog;
use Fenglin\FenglinBundle\Entity\RefreeTree;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RefreeController
 * @package Fenglin\FenglinBundle\Controller\Rest
 */
class RefreeController extends Controller
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
     * @return bool
     */
    private function save(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Fenglin\FenglinBundle\Entity\RefreeTree $item
         */
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST') {
            $item = new RefreeTree();
        }
        if ($request->getMethod() == 'PUT') {
            $id = $request->get('id');
            $item = $em->getRepository('FenglinFenglinBundle:RefreeTree')->find($id);
            if (!$item) {
                $this->setCode(500);
                $this->setMessage('RefreeTree not found');
            }
        }

        if ($shopperId = $this->getRequestParameters($request, 'shopperId')) {
            //$item->setRoute($route);
            $shopper = $em->getRepository('PandaShopperBundle:Shopper')->find($shopperId);
            if (!$shopper){
                $this->setCode(500);
                $this->setMessage('shopper not found');
                return false;
            } else {
                $item->setShopper($shopper);
            }
        } else {
            $this->setCode(500);
            $this->setMessage('shopperId not found');
            return false;
        }

        //consumer apikey
        if ($apikey = $this->getRequestParameters($request, 'apikey')) {
            //$item->setRoute($route);
            $consumer = $em->getRepository('PandaConsumerBundle:Consumer')->findOneBy([
                'apiKey' => $apikey
            ]);

            if (!$consumer){
                $this->setCode(500);
                $this->setMessage('consumer not found');
                return false;
            } else {
                $item->setConsumer($consumer);
            }
        } else {
            $this->setCode(403);
            $this->setMessage('apikey not found');
            return false;
        }

        if ($consumerId = $this->getRequestParameters($request, 'consumerId')) {
            //$item->setRoute($route);
            $consumer = $em->getRepository('PandaConsumerBundle:Consumer')->findOneBy([
                'memberId' => $consumerId
            ]);
            if (!$consumer){
                $this->setCode(500);
                $this->setMessage('consumer not found');
                return false;
            } else {
                $item->setReferalConsumer($consumer);
            }
        } else {
            $this->setCode(500);
            $this->setMessage('consumerId not found');
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
            ->from('FenglinFenglinBundle:RefreeTree', 'wr')
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
        $item = $em->getRepository('FenglinFenglinBundle:RefreeTree')->find($id);
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
