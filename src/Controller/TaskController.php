<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tasks')]
class TaskController extends AbstractController
{
    #[Route('/{id}/toggle', name: 'app_task_toggle', methods: ['POST'])]
    public function toggle(Task $task, TaskRepository $repository): Response
    {
        $task->setDone(!$task->isDone());
        $repository->save($task, true);

        return $this->redirectToRoute('app_task_list_show', ['id' => $task->getList()->getId()]);
    }
}
