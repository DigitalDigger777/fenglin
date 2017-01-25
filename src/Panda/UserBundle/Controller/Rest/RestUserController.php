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
class RestUserController extends Controller
{

    /**
     * Restore password.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function restoreAction(Request $request)
    {
        /**
         * @var \Panda\UserBundle\Entity\User $user
         */
        $requestObject = json_decode($request->getContent());

        if (property_exists($requestObject, 'email')) {

            if ($user = $this->findUserByEmail($requestObject->email)) {

                $requestRecovery = $this->createRequestRecovery($user);

                $template = $this->renderView('user/restore/email_templates/restore.html.twig', [
                    'user'              => $user,
                    'requestRecovery'   => $requestRecovery
                ]);

                $from = new Email(null, 'no-reply@feelzan.com');
                $to   = new Email(null, $requestObject->email);

                $content = new Content('text/html', $template);
                $mail    = new Mail($from, 'Restore password', $to, $content);

                $sendGrid = new \SendGrid('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');
                $response = $sendGrid->client->mail()->send()->post($mail);

                return new JsonResponse([
                    'message' => 'Email send'
                ], $response->statusCode());

            } else {
                return new JsonResponse([
                    'message' => 'User not found'
                ], 500);
            }

        } else {
            return new JsonResponse([
                'message' => 'Email not found'
            ]);
        }
    }

    /**
     * Success restore password.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function successRestoreAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\UserBundle\Repository\RequestRecoveryPasswordRepository $requestRecoveryRepo
         * @var \Panda\UserBundle\Entity\RequestRecoveryPassword $requestRecovery
         */
        $em = $this->getDoctrine()->getManager();
        $requestRecoveryRepo = $em->getRepository('PandaUserBundle:RequestRecoveryPassword');

        $requestObject = json_decode($request->getContent());

        if (property_exists($requestObject, 'password') && property_exists($requestObject, 'confirmPassword')) {

            if ($requestObject->password == $requestObject->confirmPassword) {

                if (property_exists($requestObject, 'hash')) {
                    $hash = $requestObject->hash;
                    $requestRecovery = $requestRecoveryRepo->findOneBy([
                        'hash' => $hash
                    ]);

                    if ($requestRecovery->getUsed()) {
                        return new JsonResponse([
                            'message' => 'Url for recovery password has expired'
                        ], 500);
                    }

                    $requestRecovery->setUsed(true);

                    $em->persist($requestRecovery);
                    $em->flush();

                    $encoder = $this->container->get('security.password_encoder');
                    $password = $requestObject->password;

                    $user = $requestRecovery->getUser();
                    $password = $encoder->encodePassword($user, $password);
                    $user->setPassword($password);

                    $em->persist($user);
                    $em->flush();

                    return new JsonResponse([
                        'message' => 'Password change successful'
                    ]);
                }

            } else {
                return new JsonResponse([
                    'message' => 'Password and confirm password not equal'
                ], 500);
            }

        } else {

            return new JsonResponse([
                'message' => 'Not have property password or confirm password'
            ], 500);

        }
    }

    /**
     * Login
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\UserBundle\Entity\User $user
         */

        $encoder = $this->container->get('security.password_encoder');
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('PandaUserBundle:User')->findOneBy([
            'email' => $request->request->get('_username')
        ]);

        $code   = 200;
        $apiKey = null;

        if ($user) {
            $password = $request->request->get('_password');
            $password = $encoder->encodePassword($user, $password);

            if ($user->getPassword() == $password) {
                $apiKey = md5($user->getPassword() . '' . time());
                $user->setApiKey($apiKey);

                $em->persist($user);
                $em->flush();
            } else {
                $code = 401;
            }
        } else {
            $code = 401;
        }

        $response = new JsonResponse([
            'apiKey' => $apiKey
        ], $code);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
        $response->headers->set('Access-Control-Allow-Methods', 'POST');

        return $response;
    }

    /**
     * Find user by email.
     *
     * @param $email
     * @return null|\Panda\UserBundle\Repository\UserInterface
     */
    private function findUserByEmail($email)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\UserBundle\Repository\UserRepository $pandaUserRepo
         */
        $em = $this->getDoctrine()->getManager();
        $pandaUserRepo = $em->getRepository('PandaUserBundle:User');
        return $pandaUserRepo->loadUserByUsername($email);
    }

    /**
     * Generate hash for recovery.
     *
     * @param $email
     * @return string
     */
    private function generateHash($email)
    {
        $timestamp = time();
        return md5($timestamp . ' ' . $email);
    }

    /**
     * Create request recovery password.
     *
     * @param $user \Panda\UserBundle\Entity\User
     * @return RequestRecoveryPassword
     */
    private function createRequestRecovery($user)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();

        $email = $user->getEmail();
        $hash  = $this->generateHash($email);

        $currentDate = new \DateTime();
        $expiredDate = $currentDate->add(new \DateInterval('P1D'));

        $requestRecovery = new RequestRecoveryPassword();
        $requestRecovery->setUser($user);
        $requestRecovery->setDate($currentDate);
        $requestRecovery->setDateExpired($expiredDate);
        $requestRecovery->setHash($hash);
        $requestRecovery->setUsed(false);

        $em->persist($requestRecovery);
        $em->flush();

        return $requestRecovery;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function apiAuthAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\UserBundle\Entity\User $user
         */
        $code = 200;
        $response = [];
        $encoder = $this->container->get('security.password_encoder');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('PandaUserBundle:User')->findOneBy([
            'email' => $request->query->get('email')
        ]);

        if ($user) {
            $password = $request->query->get('password');
            $password = $encoder->encodePassword($user, $password);

            if ($user->getPassword() == $password) {
                $response = [
                    'token' => $user->getApiKey()
                ];
            } else {
                $code = 401;
                $response = [
                    'message' => 'email or password is not correct'
                ];
            }
        } else {
            $code = 401;
            $response = [
                'message' => 'email or password is not correct'
            ];
        }

        $callback = $request->query->get('callback');

        $jsonResponse = new JsonResponse($response, $code);

        if ($callback) {
            $jsonResponse->setCallback($callback);
        }

        return $jsonResponse;
    }
}
