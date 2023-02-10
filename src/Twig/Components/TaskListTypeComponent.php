<?php

namespace App\Twig\Components;

use App\Entity\TaskList;
use App\Form\TaskListType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent('task_list_type')]
class TaskListTypeComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use LiveCollectionTrait;

    #[LiveProp(fieldName: 'data')]
    public ?TaskList $taskList = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(TaskListType::class, $this->taskList);
    }
}
