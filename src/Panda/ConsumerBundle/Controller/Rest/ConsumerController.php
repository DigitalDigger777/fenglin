<?php

namespace Panda\ConsumerBundle\Controller\Rest;

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
        $email = $this->getUser()->getUsername();

        $qb = $em->createQueryBuilder();
        $qb->select('c')
            ->from('PandaUserBundle:User', 'c')
            ->where($qb->expr()->eq('c.email', ':email'))
            ->setParameter(':email', $email);

        $query = $qb->getQuery();

        try {
            $data = $query->getSingleResult(Query::HYDRATE_ARRAY);
            $this->setData($data);
        } catch (\Exception $e) {
            $this->setCode(500);
            $this->setMessage($e->getMessage() . ' ' . $email);
        }
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
