<?php

namespace App\Controller\Admin;

use App\EasyAdmin\UrlHelper;
use App\Entity\TodoList;
use App\Entity\TodoTask;
use App\Form\TodoListType;
use App\Form\TodoTaskType;
use App\Repository\TodoListRepository;
use App\Repository\TodoTaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/todolist', name: 'easyadmin_todolist_')]
class TodoController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(TodoListRepository $todoListRepository, UserRepository $userRepository, UrlHelper $urlHelper): Response
    {
        $todoList = new TodoList();
        $todoList->setUser($this->getUser());
        $todoList->setUserAccess($userRepository->findAll());
        $formTodoList = $this->createForm(TodoListType::class, $todoList);
        $todoLists = $todoListRepository->findByUserAccessAndNotIsDone($this->getUser());

        foreach ($todoLists as $todoList) {
            $todoTask = new TodoTask();
            $todoTask->setTodoList($todoList);

            $formTodoTask = $this->createForm(TodoTaskType::class, $todoTask);
            $todoList->setFormView($formTodoTask->createView());
        }

        return $this->render('easyadmin/todo_list.html.twig', [
            'urlHelper' => $urlHelper,
            'todoLists' => $todoLists,
            'form'      => $formTodoList->createView(),
        ]);
    }

    #[Route('/create_list', name: 'create_list')]
    public function createTodoList(Request $request, EntityManagerInterface $entityManager): Response
    {
        $todoList = new TodoList();

        $form = $this->createForm(TodoListType::class, $todoList);
        $form->handleRequest($request);

        $todoList->setUser($this->getUser());
        $entityManager->persist($todoList);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/create_task', name: 'create_task')]
    public function createTodoTask(Request $request, EntityManagerInterface $entityManager, string $projectDir): Response
    {
        $todoTask = new TodoTask();

        $form = $this->createForm(TodoTaskType::class, $todoTask);
        $form->handleRequest($request);

        /** @var UploadedFile $file */
        if (null !== $file = $form['fileFn']->getData()) {
            $fileName = md5($todoTask->getCreatedAt()->format('Y-m-d H:i:s')) . '_' . $file->getClientOriginalName();
            $file->move($todoTask->getUploadDir(), $fileName);
            $todoTask->setFileFn($fileName);
        }

        $todoTask->setUser($this->getUser());

        $entityManager->persist($todoTask);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/change_is_done_list', name: 'change_is_done_list')]
    public function changeIsDoneList(
        Request                $request,
        EntityManagerInterface $entityManager,
        TodoListRepository     $todoListRepository
    ): JsonResponse {
        $todoList = $todoListRepository->find($request->get('id'));

        if (!$todoList) {
            return new JsonResponse(['success' => false], Response::HTTP_NOT_FOUND);
        }

        if ($todoList->getUserAccess()->contains($this->getUser())) {
            $todoList->setIsDone($request->get('isDone', true));

            $entityManager->persist($todoList);
            $entityManager->flush();

            return new JsonResponse($todoList, Response::HTTP_OK);
        }


        return new JsonResponse(['success' => false], Response::HTTP_FORBIDDEN);
    }

    #[Route('/change_is_done_task', name: 'change_is_done_task')]
    public function changeIsDoneTask(
        Request                $request,
        EntityManagerInterface $entityManager,
        TodoTaskRepository     $todoTaskRepository
    ): JsonResponse {
        $todoTask = $todoTaskRepository->find($request->get('id'));

        if (!$todoTask) {
            return new JsonResponse(['success' => false], Response::HTTP_NOT_FOUND);
        }

        if ($todoTask->getTodoList()->getUserAccess()->contains($this->getUser())) {
            $todoTask->setIsDone($request->get('isDone', true));

            $entityManager->persist($todoTask);
            $entityManager->flush();

            return new JsonResponse($todoTask, Response::HTTP_OK);
        }

        return new JsonResponse(['success' => false], Response::HTTP_FORBIDDEN);
    }
}
