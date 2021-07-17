<?php

namespace App\FormHandler;

use App\Entity\Task;
use App\Form\TaskType;
use App\FormHandler\FormHandler;
use Symfony\Component\Form\FormInterface;

class TaskFormHandler extends FormHandler
{
    /**
     * @var Task
     */
    private $task;

    /**
     * @return FormInterface
     */
    public function init(Task $task)
    {
        $this->task = $task;
        return $this->form = $this->formFactory->create(TaskType::class, $task);
    }

    /**
     * @return void
     */
    public function create()
    {
        $this->task->setAuthor($this->security->getUser());
        $this->task->setCreatedAt();
        $this->em->persist($this->task);
        $this->em->flush();
    }

    /**
     * @return void
     */
    public function update()
    {
        $this->em->flush();
    }
}
