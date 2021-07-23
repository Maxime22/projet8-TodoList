<?php

namespace App\Controller;

use App\Entity\Task;
use App\FormHandler\TaskCreateFormHandler;
use App\FormHandler\TaskUpdateFormHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction(): Response
    {
        return $this->render(
            'task/list.html.twig',
            ['tasks' => $this->getDoctrine()->getRepository(Task::class)->findBy(['isDone' => 0])]
        );
    }

    /**
     * @Route("/tasks/ended", name="task_list_ended")
     */
    public function listEndingAction(): Response
    {
        return $this->render(
            'task/list.html.twig',
            ['tasks' => $this->getDoctrine()->getRepository(Task::class)->findBy(['isDone' => 1])]
        );
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(TaskCreateFormHandler $taskCreateFormHandler): Response
    {
        $form = $taskCreateFormHandler->createForm(new Task());
        if ($taskCreateFormHandler->handle()) {
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');
            return $this->redirectToRoute('task_list');
        }
        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, TaskUpdateFormHandler $taskUpdateFormHandler): Response
    {
        $form = $taskUpdateFormHandler->createForm($task);
        if ($taskUpdateFormHandler->handle()) {
            $this->addFlash('success', 'La tâche a bien été modifiée.');
            return $this->redirectToRoute('task_list');
        }
        return $this->render(
            'task/edit.html.twig',
            [
                'form' => $form->createView(),
                'task' => $task,
            ]
        );
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task): Response
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success', sprintf("La tâche %s a bien changée d'état", $task->getTitle()));
        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task): Response
    {
        $this->denyAccessUnlessGranted('task_delete', $task);
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
        $this->addFlash('success', 'La tâche a bien été supprimée.');
        return $this->redirectToRoute('task_list');
    }
}
