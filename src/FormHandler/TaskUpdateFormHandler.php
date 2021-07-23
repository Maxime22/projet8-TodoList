<?php

namespace App\FormHandler;

use App\Form\TaskType;
use App\FormHandler\FormHandler;
use Doctrine\ORM\EntityManagerInterface;

class TaskUpdateFormHandler extends FormHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @return void
     */
    public function setEntityManager(EntityManagerInterface $entityManager){
        $this->em = $entityManager;
    }

    /**
     * @return void
     */
    public function process()
    {
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
