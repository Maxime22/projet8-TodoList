<?php

namespace App\FormHandler;

use App\Entity\User;
use App\Form\UserType;
use App\FormHandler\FormHandler;
use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\FormInterface;

class UserFormHandler extends FormHandler
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(FormFactoryInterface $formFactory, RequestStack $requestStack, EntityManagerInterface $entityManager, Security $security, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($formFactory, $requestStack, $entityManager, $security);
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @return FormInterface
     */
    public function init(User $user)
    {
        $this->user = $user;
        return $this->form = $this->formFactory->create(UserType::class, $user);
    }

    /**
     * @return void
     */
    public function create()
    {
        $password = $this->passwordHasher->hashPassword($this->user, $this->user->getPassword());
        $this->user->setPassword($password);
        $this->em->persist($this->user);
        $this->em->flush();
    }

    /**
     * @return void
     */
    public function update()
    {
        $password = $this->passwordHasher->hashPassword($this->user, $this->user->getPassword());
        $this->user->setPassword($password);
        $this->em->flush();
    }
}
