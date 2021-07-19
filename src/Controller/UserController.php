<?php

namespace App\Controller;

use App\Entity\User;
use App\FormHandler\UserCreateFormHandler;
use App\FormHandler\UserUpdateFormHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_list")
     */
    public function listAction(): Response
    {
        return $this->render(
            'user/list.html.twig',
            ['users' => $this->getDoctrine()->getRepository(User::class)->findAll()]
        );
    }

    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(UserCreateFormHandler $usercreateFormHandler): Response
    {
        $form = $usercreateFormHandler->createForm(new User());
        if ($usercreateFormHandler->handle()) {
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function editAction(User $user, UserUpdateFormHandler $userUpdateFormHandler): Response
    {
        $form = $userUpdateFormHandler->createForm($user);
        if ($userUpdateFormHandler->handle()) {
            $this->addFlash('success', "L'utilisateur a bien été modifié");
            return $this->redirectToRoute('user_list');
        }
        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
