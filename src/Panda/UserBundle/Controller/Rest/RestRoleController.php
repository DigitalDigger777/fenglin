<?php

namespace Panda\UserBundle\Controller\Rest;

use Panda\UserBundle\Entity\RequestRecoveryPassword;
use SendGrid\Content;
use SendGrid\Email;
use SendGrid\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class RestUserController
 * @package Panda\UserBundle\Controller\Rest
 */
class RestRoleController extends Controller
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

    public function loadAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\UserBundle\Repository\UserRepository $userRepo
         * @var \Panda\UserBundle\Entity\User $user
         */
        $em = $this->getDoctrine()->getManager();
        $apiKey = $this->getRequestParameters($request, 'apikey');
        $userRepo = $em->getRepository('PandaUserBundle:User');
        $user = $userRepo->loadUserByApiKey($apiKey);

        if ($user) {
            $this->setData([
                'role' => $user->getRole()
            ]);
        } else {
            $this->setMessage('user not found');
            $this->setCode(500);
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
}
