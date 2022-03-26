<?php

namespace App\Tests\EasyAdmin;

use App\EasyAdmin\Helper\UrlHelper;
use App\Entity\TodoList;
use App\Entity\TodoTask;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UrlHelperTest extends KernelTestCase
{
    private UrlHelper $urlHelper;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->urlHelper = self::$kernel->getContainer()->get(UrlHelper::class);
    }

    public function testGetTodoListIsDoneUrl(): void
    {
        $todoList = new TodoList();

        $this->assertIsString($this->urlHelper->getTodoListIsDoneUrl($todoList, true));
        $this->assertIsString($this->urlHelper->getTodoListIsDoneUrl($todoList, false));
    }

    public function testGetTodoTaskIsDoneUrl(): void
    {
        $todoTask = new TodoTask();

        $this->assertIsString($this->urlHelper->getTodoTaskIsDoneUrl($todoTask, true));
        $this->assertIsString($this->urlHelper->getTodoTaskIsDoneUrl($todoTask, false));
    }
}
