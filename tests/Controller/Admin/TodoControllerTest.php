<?php

namespace App\Tests\Controller\Admin;

class TodoControllerTest extends AbstractEasyAdminControllerTestCase
{
    public function testVisitPage(): void
    {
        $this->goTodoPage();

        $this->assertSelectorTextContains('h1', 'Todo list');
    }

    public function testAddTodoList(): void
    {
        $client = $this->goTodoPage();
        $form = $client->getCrawler()->filter('form[name="todo_list"]')->last()
            ->selectButton('Save')->form();

        $client->submit($form, ['todo_list[name]' => 'My test todo list']);
        $client->followRedirect();
        $this->assertStringContainsString('My test todo list', $client->getCrawler()->text());
        $this->assertSame(
            'User access: gorskimarcin96@gmail.com, ola_2341@o2.pl',
            $client->getCrawler()->filter('.card-footer')->last()->text()
        );
    }

    public function testAddTodoListWitchCheckUser(): void
    {
        $client = $this->goTodoPage();
        $form = $client->getCrawler()->filter('form[name="todo_list"]')->last()
            ->selectButton('Save')->form();

        $client->submit($form, ['todo_list[name]' => 'My test todo list 2', 'todo_list[userAccess]' => [1]]);
        $client->followRedirect();
        $this->assertStringContainsString('My test todo list', $client->getCrawler()->text());
        $this->assertSame(
            'User access: gorskimarcin96@gmail.com',
            $client->getCrawler()->filter('.card-footer')->last()->text()
        );
    }

    public function testAddTodoTask(): void
    {
        $client = $this->goTodoPage();
        $form = $client->getCrawler()->filter('form[name="todo_task"]')->last()
            ->selectButton('Save')->form();

        $client->submit($form, ['todo_task[name]' => 'My test todo task name']);
        $client->followRedirect();
        $this->assertStringContainsString('My test todo task name', $client->getCrawler()->text());
    }

    public function testAddTodoTaskWithDescriptionAndFile(): void
    {
        $client = $this->goTodoPage();
        $form = $client->getCrawler()->filter('form[name="todo_task"]')->last()
            ->selectButton('Save')->form();

        $form['todo_task[name]'] = 'My test todo task name 2';
        $form['todo_task[description]'] = 'My test todo task description 2';
        $form['todo_task[fileFn]']->upload(__dir__ . '/../../image_test.jpg');

        $client->submit($form);
        $client->followRedirect();
        $this->assertStringContainsString('My test todo task name 2', $client->getCrawler()->text());

        $uploadDir = __dir__ . '/../../../upload/TodoTask';
        array_map('unlink', glob("$uploadDir/*.*"));
        rmdir($uploadDir);
        rmdir(__dir__ . '/../../../upload');
    }
}
