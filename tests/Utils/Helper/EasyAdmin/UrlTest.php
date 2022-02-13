<?php

namespace App\Tests\Utils\Helper\EasyAdmin;

use App\Entity\TodoList;
use App\Entity\TodoTask;
use App\Utils\Helper\EasyAdmin\Url;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UrlTest extends KernelTestCase
{
    private Url $urlHelper;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->urlHelper = self::$kernel->getContainer()->get(Url::class);
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
