<?php

namespace Panda\UserBundle\Controller\Rest;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RestUserController
 * @package Panda\UserBundle\Controller\Rest
 */
class RestValidateController extends Controller
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
        if ($this->getMethod($request) == 'ISSET_TEL') {
            $this->issetTel($request);
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
    private function issetTel(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $tel = $this->getRequestParameters($request, 'tel');

        if ($tel) {
            $user = $em->getRepository('PandaUserBundle:User')->findOneBy([
                'tel' => $tel
            ]);

            if (!$user) {
                $this->setData(['isset_tel' => 0]);
            } else {
                $this->setData(['isset_tel' => 1]);
            }

        } else {
            $this->setMessage('Tel is null');
            $this->setCode(500);
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
