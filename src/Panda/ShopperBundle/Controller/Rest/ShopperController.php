<?php
namespace Panda\ShopperBundle\Controller\Rest;

use Doctrine\ORM\Query;
use Panda\ShopperBundle\Entity\Shopper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Shopper Controller
 * @package Panda\ShopperBundle\Controller\Rest
 */
class ShopperController extends Controller
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
     * @param Request $request
     * @return JsonResponse
     */
    public function listAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $page = $request->get('page');

        $qb = $em->createQueryBuilder();
//        $qb->select('COUNT(s)')
//            ->from('PandaShopperBundle:Shopper', 's');
//        $count = $qb->getQuery()->getSingleScalarResult();
        $apiKey = $request->query->get('apikey');
        $search = $request->query->get('search');

        $qb->select('s, fc')
            ->from('PandaShopperBundle:Shopper', 's')
            ->leftJoin('s.followConsumers', 'fc', 'WITH', ' fc.apiKey=:apiKey');

        if ($search) {
            $qb->where($qb->expr()->like('s.name', ':name'))
                ->setParameter(':name', '%' . $search . '%');
        }

        $qb->setParameter(':apiKey', $apiKey);


        $result = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $qb = $em->createQueryBuilder();

        $qb->select('cu, c, s')
            ->from('FenglinFenglinBundle:ConsumerAmount', 'cu')
            ->join('cu.consumer', 'c')
            ->join('cu.shopper', 's')
            ->where($qb->expr()->eq('c.apiKey', ':apiKey'))
            ->setParameter(':apiKey', $apiKey);

        $amounts = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);

//        print_r($amounts); exit;
        foreach ($result as $key => $item) {
            $result[$key]['amount'] = 0;

            foreach ($amounts as $amountItem) {
                if ($item['id'] == $amountItem['shopper']['id'] ) {
                    $result[$key]['amount'] = $amountItem['totalAmount'];
                }
            }
        }

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function cashBackListAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $id = $this->getRequestParameters($request, 'id');

        $qb = $em->createQueryBuilder();
        $qb->select('c')
            ->from('FenglinCashBackBundle:CashBack', 'c')
            ->join('c.shopper', 's')
            ->where($qb->expr()->eq('s.id', ':id'))
            ->setParameter(':id', $id);

        $result = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function loadByNameAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $id = $this->getRequestParameters($request, 'name');
        $qb = $em->createQueryBuilder();

        $qb->select('s')
            ->from('PandaShopperBundle:Shopper', 's')
            ->where($qb->expr()->like('s.name', ':name'))
            ->setParameter(':name', '%' . $id . '%');
        $query = $qb->getQuery();

        try {
            $data = $query->getResult(Query::HYDRATE_ARRAY);
            if (count($data) > 0) {
                $this->setData($data[0]);
            } else {
                $this->setCode(500);
                $this->setMessage('not found');
            }
        } catch (\Exception $e) {
            $this->setCode(500);
            $this->setMessage($e->getMessage());
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
     * @return JsonResponse
     * @throws \Exception
     */
    public function loadCurrentAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\ShopperBundle\Repository\ShopperRepository $shopperRepo
         * @var \Panda\StaffBundle\Repository\StaffRepository $staffRepo
         * @var \Panda\StaffBundle\Entity\Staff $staff
         */
        $em = $this->getDoctrine()->getManager();

        $shopperRepo = $em->getRepository('PandaShopperBundle:Shopper');
        $staffRepo   = $em->getRepository('PandaStaffBundle:Staff');

        $apikey = $request->query->get('apikey');
        $qb = $em->createQueryBuilder();

        if ($user = $shopperRepo->findOneBy(['apiKey' => $apikey])) {
            $shopperId = $user->getId();
        } elseif ($user = $staffRepo->findOneBy(['apiKey' => $apikey])) {
            $this->setCode(403);
            $this->setMessage('Access Denied');

            return new JsonResponse([
                'message' => $this->getMessage()
            ], $this->getCode());
        } else {
            throw new \Exception('Access Denied');
        }

        $qb->select('s')
            ->from('PandaShopperBundle:Shopper', 's')
            ->where($qb->expr()->eq('s.id', ':id'))
            ->setParameter(':id', $shopperId);


        $query = $qb->getQuery();

        try {
            $data = $query->getSingleResult(Query::HYDRATE_ARRAY);
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
     * @return array
     */
    public function uploadImageAction(Request $request)
    {
        /**
         * @var \Symfony\Component\HttpFoundation\File\UploadedFile $file
         */

        $files = $request->files;
        $responseFiles = [];

        foreach ($files as $file) {

            $name = time() . '.jpg';

            if ($file) {
                $file->move('uploads/shoppers', $name);
                $responseFiles[] = $name;
            }
        }

        return new JsonResponse($responseFiles, 200);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function save(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\ShopperBundle\Entity\Shopper $item
         */
        $em = $this->getDoctrine()->getManager();
        $method = $request->getMethod();
        $encoder = $this->container->get('security.password_encoder');

        if ($method == 'POST') {
            $item = new Shopper();
        }

        if ($method == 'PUT') {
            $id = $request->get('id');
            $item = $em->getRepository('PandaShopperBundle:Shopper')->find($id);

            if (!$item) {
                $this->setCode(500);
                $this->setMessage('Shopper not found');
            }
        }

        $fields = [
            'name' => [
                'required' => [
                    'POST',
                    'PUT'
                ]
            ],
            'logo'              => [],
            'address'           => [],
            'tel'               => [],
            'totalAmount'       => [],
            'rebate'            => [],
            'rebateLevelRate'   => [],
            'rebateLevel2Rate'  => [],
            'rebateLevel3Rate'  => [],
            'shedule'           => [],
            'contactTel'        => []
        ];

        foreach($fields as $fieldName => $rule) {
            $fieldValue = $this->getRequestParameters($request, $fieldName);

            //check rule
            if (count($rule) == 0) {

                if ($fieldValue) {

                    $item->{"set" . ucfirst($fieldName)}($fieldValue);
                }

            } else {

                if (isset($rule['required']) && in_array(strtoupper($method), $rule['required']) && $fieldValue) {

                    $item->{"set" . ucfirst($fieldName)}($fieldValue);

                } else {
                    $this->setCode(500);
                    $this->setMessage($fieldName . ' not found');
                    return false;
                }

            }

        }

        try {
            $tel = $item->getTel();
            $pass = $this->getRandomPassword();
            $password = $encoder->encodePassword($item, $pass);

            $item->setEmail($tel.'@wxfenling.com');

            if ($this->getMethod($request) == 'POST') {
                $item->setPassword($password);
                $item->setOpenPassword($pass);
                $item->setApiKey(md5($pass));
            }

            $item->setStatus(Shopper::STATUS_ACTIVE);

            $item->setRole('ROLE_SHOPPER');

            $em->persist($item);
            $em->flush();
            $this->setMessage('Item save successful');
            $this->setData([
                'id' => $item->getId(),
                'password' => $item->getOpenPassword()
            ]);
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
        $apikey = $this->getRequestParameters($request, 'apikey');
        $qb = $em->createQueryBuilder();

        $qb->select('s, a')
            ->from('PandaShopperBundle:Shopper', 's')
            ->leftJoin('s.amountConsumers', 'a')
            ->leftJoin('a.consumer','c', 'WITH', 'c.apiKey=:apikey')
            ->where($qb->expr()->eq('s.id', ':id'))
            ->setParameter(':id', $id)
            ->setParameter(':apikey', $apikey);

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
        $item = $em->getRepository('PandaShopperBundle:Shopper')->find($id);
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