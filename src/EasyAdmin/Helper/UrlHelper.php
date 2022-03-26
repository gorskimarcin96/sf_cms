<?php

namespace App\EasyAdmin\Helper;

use App\Entity\TodoList;
use App\Entity\TodoTask;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class UrlHelper
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    public function getTodoIndex(): string
    {
        return $this->adminUrlGenerator->setRoute('easyadmin_todolist_index')->generateUrl();
    }

    public function getTodoListIsDoneUrl(TodoList $todoList, bool $isDone): string
    {
        return $this->adminUrlGenerator
            ->setRoute('easyadmin_todolist_change_is_done_list', ['id' => $todoList->getId(), 'isDone' => $isDone])
            ->generateUrl();
    }

    public function getTodoTaskIsDoneUrl(TodoTask $todoTask, bool $isDone): string
    {
        return $this->adminUrlGenerator
            ->setRoute('easyadmin_todolist_change_is_done_task', ['id' => $todoTask->getId(), 'isDone' => $isDone])
            ->generateUrl();
    }
}
