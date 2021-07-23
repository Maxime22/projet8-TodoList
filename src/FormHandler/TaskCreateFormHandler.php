<?php

namespace App\FormHandler;

use App\Form\TaskType;
use App\FormHandler\FormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class TaskCreateFormHandler extends FormHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Security
     */
    private $security;

    /**
     * @return void
     */
    public function setEntityManager(EntityManagerInterface $entityManager){
        $this->em = $entityManager;
    }

    /**
     * @return void
     */
    public function setSecurity(Security $security){
        $this->security = $security;
    }

    /**
     * @return void
     */
    public function process()
    {
        $this->entity->setAuthor($this->security->getUser());
        $this->entity->setCreatedAt();
        $this->em->persist($this->entity);
        $this->em->flush();
    }

    /**
     * @return string
     */
    public function getFormType()
    {
        return TaskType::class;
    }
}
