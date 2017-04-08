<?php

namespace Panda\ConsumerBundle\Controller\Rest;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Panda\ConsumerBundle\Entity\Consumer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConsumerController extends Controller
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
            if (!$request->get('id')) {
                $this->load($request);
            } else {
                $this->search($request);
            }
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
    public function joinToShopperAction(Request $request)
    {
       /**
        * @var \Doctrine\ORM\EntityManager $em
        * @var \Panda\ShopperBundle\Entity\Shopper $shopper
        * @var \Fenglin\FenglinBundle\Repository\ConsumerAmountRepository $consumerAmountRepo
        */
       $em = $this->getDoctrine()->getEntityManager();
       $consumerAmountRepo = $em->getRepository('FenglinFenglinBundle:ConsumerAmount');
       $shopperId = $this->getRequestParameters($request, 'shopperId');
       $shopper = $em->getRepository('PandaShopperBundle:Shopper')->find($shopperId);

       if ($shopper) {
           $consumerApiKey = $this->getRequestParameters($request, 'apikey');
           $consumer = $em->getRepository('PandaConsumerBundle:Consumer')->findOneBy([
               'apiKey' => $consumerApiKey
           ]);

           if ($consumer) {
               $followConsumers = $shopper->getFollowConsumers();
               $followConsumers->add($consumer);

               $shopper->setFollowConsumers($followConsumers);


               $em->persist($shopper);
               $em->flush();

               $consumerAmountRepo->createIfNotExist($shopper, $consumer);
           } else {
               $this->setMessage('access denied');
               $this->setCode(403);
           }
        } else {
           $this->setMessage('Shopper not found');
           $this->setCode(500);
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
         * @var \Panda\ConsumerBundle\Entity\Consumer $item
         */
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST') {
            $item = new Consumer();
        }
        if ($request->getMethod() == 'PUT') {
            $id = $request->get('id');
            $item = $em->getRepository('PandaConsumerBundle:Consumer')->find($id);
            if (!$item) {
                $this->setCode(500);
                $this->setMessage('Consumer not found');
            }
        }
        //TODO:save
//        if ($route = $this->getRequestParameters($request, 'route')) {
//            $item->setRoute($route);
//        } else {
//            $this->setCode(500);
//            $this->setMessage('Consumer not found');
//            return false;
//        }
//        if ($items = $this->getRequestParameters($request, 'items')) {
//            $item->setItems($items);
//        } else {
//            $this->setCode(500);
//            $this->setMessage('Items not found');
//            return false;
//        }
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
        $memberId = $request->query->get('memberId');
        $domain = $this->container->getParameter('wechat_domain');

        $qb = $em->createQueryBuilder();
        $qb->select('c')
            ->from('PandaUserBundle:User', 'c');

        if (!$memberId) {
            $email = $this->getUser()->getUsername();
            $qb->where($qb->expr()->eq('c.email', ':email'))
                ->setParameter(':email', $email);
        } else {

            $qb->where($qb->expr()->eq('c.memberId', ':memberId'))
                ->setParameter(':memberId', $memberId);
        }

        $query = $qb->getQuery();

        try {
            $data = $query->getSingleResult(Query::HYDRATE_ARRAY);
            $data['domain'] = $domain;
            $this->setData($data);
        } catch (\Exception $e) {
            $this->setCode(500);
            $this->setMessage($e->getMessage() . ' ' . $email);
        }

        $response = new JsonResponse($data, $this->getCode());

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function loadByMemberIdAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\ShopperBundle\Repository\ShopperRepository $shopperRepo
         * @var \Panda\StaffBundle\Repository\StaffRepository $staffRepo
         * @var \Panda\ConsumerBundle\Repository\ConsumerRepository $consumerRepo
         * @var \Fenglin\FenglinBundle\Repository\ConsumerAmountRepository $consumerAmountRepo
         * @var \Panda\StaffBundle\Entity\Staff $staff
         */
        $em = $this->getDoctrine()->getManager();
        $shopperRepo        = $this->getDoctrine()->getRepository('\Panda\ShopperBundle\Entity\Shopper');
        $staffRepo        = $this->getDoctrine()->getRepository('\Panda\StaffBundle\Entity\Staff');
        $consumerRepo       = $this->getDoctrine()->getRepository('\Panda\ConsumerBundle\Entity\Consumer');
        $consumerAmountRepo = $this->getDoctrine()->getRepository('\Fenglin\FenglinBundle\Entity\ConsumerAmount');

        $roles = $this->getUser()->getRoles();
        if ($roles[0] == 'ROLE_STAFF') {
            $staffEmail = $this->getUser()->getUsername();
            $staff = $staffRepo->findOneBy([
                'email' => $staffEmail
            ]);
            $shopperEmail = $staff->getShopper()->getEmail();
        } else {
            $shopperEmail = $this->getUser()->getUsername();
        }

        $shopper      = $shopperRepo->findByEmail($shopperEmail);

        if (!$shopper) {
            $this->setCode(500);
            $this->setMessage('shopper not found email:' . $shopperEmail);
        } else {
            $shopperId    = $shopper->getId();
            $memberId     = $request->query->get('memberId');
            $consumer     = $consumerRepo->findByMemberId($memberId);

            if (!$consumer) {
                $this->setCode(500);
                $this->setMessage('consumer not found memberId:' . $memberId);
            } else {
                $consumerAmount = $consumerAmountRepo->createIfNotExist($shopper, $consumer);

                if ($consumerAmount) {
                    $qb = $em->createQueryBuilder();
                    $qb->select('c, ac, s, cs, fc')
                        ->from('PandaConsumerBundle:Consumer', 'c')
                        ->leftJoin('c.followShoppers', 'fc', 'WITH', 'fc.id=:id')
                        ->join('c.amountConsumers', 'ac')
                        ->join('ac.shopper', 's')
                        ->join('ac.consumer', 'cs')
                        ->where(
                            $qb->expr()->andX(
                                $qb->expr()->eq('c.memberId', ':memberId'),
                                $qb->expr()->eq('s.id', ':id')
                            )

                        )
                        ->setParameter(':memberId', $memberId)
                        ->setParameter(':id', $shopperId);

                    $query = $qb->getQuery();

                    try {
                        $data = $query->getSingleResult(Query::HYDRATE_ARRAY);
                        $this->setData($data);

                    } catch (\Exception $e) {

                        $this->setCode(500);
                        $this->setMessage($e->getMessage() . ' memberId:' . $memberId);
                    }
                }
            }

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
     */
    public function search(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');

        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from('PandaUserBundle:User', 'u')
            ->where($qb->expr()->eq('u.id', ':id'))
            ->setParameter(':id', $id);

        $query = $qb->getQuery();

        try {
            $data = $query->getSingleResult(Query::HYDRATE_ARRAY);
            $this->setData($data);
        } catch (\Exception $e) {
            $this->setCode(500);
            $this->setMessage($e->getMessage() . ' ' . $id);
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
        $item = $em->getRepository('PandaConsumerBundle:Consumer')->find($id);
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
