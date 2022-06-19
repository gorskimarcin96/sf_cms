<?php

namespace App\Tools\Task;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class TaskManager
{
    public function __construct(
        private LoggerInterface        $queueLogger,
        private TaskRepository         $taskRepository,
        private MessageBusInterface    $bus,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function addAvailableTasksToQueue(): int
    {
        $tasks = $this->taskRepository->findAvailableTaskToExecute();

        if ($countTask = count($tasks) > 0) {
            $this->queueLogger->notice(sprintf('Funded %s tasks.', $countTask));

            foreach ($tasks as $task) {
                $this->addTaskToQueue($task);
            }
        }

        $this->entityManager->flush();

        return $countTask;
    }

    private function addTaskToQueue(Task $task)
    {
        try {
            $arguments = json_decode($task->getArguments(true), true);
            $message = new ($task->getClass())(...$arguments);

            $this->bus->dispatch($message);
        } catch (Error $exception) {
            $this->addError($task, $exception->getMessage());
        }

        $task->setIsAdded(true);
        $this->entityManager->persist($task);
    }

    private function addError(Task $task, string $message)
    {
        $task->setHasError(true);
        $this->queueLogger->error($message, [$task->getId() => $task]);
    }
}
