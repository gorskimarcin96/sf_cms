<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\TodoTaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoTaskRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class TodoTask
{
    use TimeStampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description;

    #[ORM\Column(type: "boolean")]
    private bool $isDone = false;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $fileFn = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "todoTasks")]
    private User $user;

    #[ORM\ManyToOne(targetEntity: TodoList::class, inversedBy: "todoTasks")]
    private TodoList $todoList;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function getUploadDir(): string
    {
        return 'upload/TodoTask';
    }

    public function getFileFn(): ?string
    {
        return $this->fileFn;
    }

    public function getPathFileFn(): string
    {
        return $this->getUploadDir().'/'.$this->fileFn;
    }

    public function setFileFn(string $fileFn): self
    {
        $this->fileFn = $fileFn;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTodoList(): TodoList
    {
        return $this->todoList;
    }

    public function setTodoList(TodoList $todoList): self
    {
        $this->todoList = $todoList;

        return $this;
    }
}
