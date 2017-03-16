<?php

namespace Panda\StaffBundle\Controller\Rest;

use Doctrine\ORM\Query;
use Panda\StaffBundle\Entity\Staff;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class StaffController
 * @package Panda\StaffBundle\Controller\Rest
 */
class StaffController extends Controller
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

        $qb->select('s')
            ->from('PandaStaffBundle:Staff', 's')
            ->join('s.shopper', 'sp')
            ->where($qb->expr()->eq('sp.email', ':shopperEmail'))
            ->setParameter(':shopperEmail', $shopperEmail);

        $result = $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function save(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\StaffBundle\Entity\Staff $item
         */
        $em = $this->getDoctrine()->getManager();
        $shopperEmail = $this->getUser()->getUsername();

        if ($request->getMethod() == 'POST') {
            $item = new Staff();
        }
        if ($request->getMethod() == 'PUT') {
            $id = $request->get('id');
            $item = $em->getRepository('PandaStaffBundle:Staff')->find($id);
            if (!$item) {
                $this->setCode(500);
                $this->setMessage('Staff not found');
            }
        }
        if ($name = $this->getRequestParameters($request, 'name')) {
            $item->setName($name);
        } else {
            $this->setCode(500);
            $this->setMessage('name not found');
            return false;
        }
        if ($tel = $this->getRequestParameters($request, 'tel')) {
            $item->setTel($tel);
        } else {
            $this->setCode(500);
            $this->setMessage('tel not found');
            return false;
        }

        if ($password = $this->getRequestParameters($request, 'password')) {
            //$item->setTel($password);
//            $encoder = $this->container->get('security.password_encoder');
//            $password = $encoder->encodePassword($item, $password);
            $item->setPassword($password);

        } else {
            $this->setCode(500);
            $this->setMessage('tel not found');
            return false;
        }

        $shopper = $em->getRepository('PandaShopperBundle:Shopper')->findOneBy([
            'email' => $shopperEmail
        ]);

        $item->setShopper($shopper);

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
            ->from('PandaStaffBundle:Staff', 'wr')
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
        $item = $em->getRepository('PandaStaffBundle:Staff')->find($id);
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
