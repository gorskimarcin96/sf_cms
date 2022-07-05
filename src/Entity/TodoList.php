<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\TodoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\FormView;

#[ORM\Entity(repositoryClass: TodoListRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class TodoList
{
    use TimeStampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    #[ORM\Column(type: "boolean")]
    private bool $isDone = false;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "todoLists")]
    private User $user;

    #[ORM\OneToMany(mappedBy: "todoList", targetEntity: TodoTask::class)]
    private Collection $todoTasks;

    #[ORM\ManyToMany(targetEntity: User::class)]
    #[ORM\JoinTable(name: "todo_list_user_access")]
    private Collection $userAccess;

    private ?FormView $formView = null;

    public function __toString(): string
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->todoTasks = new ArrayCollection();
        $this->userAccess = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isDone(): bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        if (!$this->userAccess->contains($user)) {
            $this->userAccess->add($user);
        }

        $this->user = $user;

        return $this;
    }

    public function setFormView(FormView $formView): self
    {
        $this->formView = $formView;

        return $this;
    }

    public function getFormView(): ?FormView
    {
        return $this->formView;
    }

    public function getTodoTasks(): Collection
    {
        return $this->todoTasks;
    }

    public function addTodoTask(TodoTask $todoTask): self
    {
        if (!$this->todoTasks->contains($todoTask)) {
            $this->todoTasks[] = $todoTask;
            $todoTask->setTodoList($this);
        }

        return $this;
    }

    public function removeTodoTask(TodoTask $todoTask): self
    {
        if ($this->todoTasks->removeElement($todoTask) && $todoTask->getTodoList() === $this) {
            $todoTask->setTodoList(null);
        }

        return $this;
    }

    public function hasTasksIsDone(): bool
    {
        $tasks = array_map(static fn (TodoTask $todoTask) => $todoTask->getIsDone(), $this->todoTasks->toArray());

        return !in_array(false, $tasks);
    }

    public function getUserAccess(): Collection
    {
        return $this->userAccess;
    }

    public function setUserAccess(array $users): self
    {
        foreach ($users as $user) {
            $this->addUserAccess($user);
        }

        return $this;
    }

    public function addUserAccess(User $userAccess): self
    {
        if (!$this->userAccess->contains($userAccess)) {
            $this->userAccess[] = $userAccess;
        }

        return $this;
    }

    public function removeUserAccess(User $userAccess): self
    {
        $this->userAccess->removeElement($userAccess);

        return $this;
    }
}
