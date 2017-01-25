<?php

namespace Panda\UserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Panda\UserBundle\Entity\User;
use Panda\UserBundle\Form\UserType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Creates a new User entity.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('Panda\UserBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('Panda\UserBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Login action.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        //var_dump($authenticationUtils); exit;
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function passwordResetAction()
    {
        return $this->render('user/restore/reset_password.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function passwordNewAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         * @var \Panda\UserBundle\Entity\RequestRecoveryPassword $requestRecovery
         */
        $em = $this->getDoctrine()->getManager();

        $requestRecoveryRepo = $em->getRepository('PandaUserBundle:RequestRecoveryPassword');
        $hash                = $request->get('hash');

        $requestRecovery = $requestRecoveryRepo->findOneBy([
            'hash' => $hash
        ]);

        return $this->render('user/restore/new_password.html.twig', [
            'requestRecovery' => $requestRecovery
        ]);
    }

    /**
     * User list.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $em
         */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from('UserBundle:User', 'u');
        $query = $qb->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('user/list.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Index action.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        if ($request->isMethod('GET'))
        {
            return $this->load($request);
        }

        if ($request->isMethod('PUT') ||$request->isMethod('POST'))
        {
            return $this->save($request);
        }

        if ($request->isMethod('DELETE'))
        {
            return $this->delete($request);
        }
    }

    /**
     * Load user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    private function load(Request $request)
    {
        return new JsonResponse();
    }

    /**
     * Save user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    private function save(Request $request)
    {
        return new JsonResponse();
    }

    /**
     * Delete user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    private function delete(Request $request)
    {
        return new JsonResponse();
    }
}
