<?php

namespace App\FormHandler;

use App\Form\UserType;
use App\FormHandler\FormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateFormHandler extends FormHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    /**
     * @return void
     */
    public function setEntityManager(EntityManagerInterface $entityManager){
        $this->em = $entityManager;
    }

    /**
     * @return void
     */
    public function setPasswordHasher(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @return void
     */
    public function process()
    {
        $password = $this->passwordHasher->hashPassword($this->entity, $this->entity->getPassword());
        $this->entity->setPassword($password);
        $this->em->persist($this->entity);
        $this->em->flush();
    }

    /**
     * @return string
     */
    public function getFormType()
    {
        return UserType::class;
    }
}
