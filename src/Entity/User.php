<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="user")
     */
    private Collection $articles;

    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="user")
     */
    private Collection $offers;

    /**
     * @ORM\OneToMany(targetEntity="Slider", mappedBy="user")
     */
    private Collection $sliders;

    /**
     * @ORM\OneToMany(targetEntity="Realization", mappedBy="user")
     */
    private Collection $realizations;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="user")
     */
    private Collection $tasks;

    /**
     * @ORM\OneToMany(targetEntity=TodoList::class, mappedBy="user")
     */
    private Collection $todoLists;

    /**
     * @ORM\OneToMany(targetEntity=TodoTask::class, mappedBy="user")
     */
    private Collection $todoTasks;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->offers = new ArrayCollection();
        $this->sliders = new ArrayCollection();
        $this->realizations = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->todoLists = new ArrayCollection();
        $this->todoTasks = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article) && $article->getUser() === $this) {
            $article->setUser(null);
        }

        return $this;
    }

    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offer $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setUser($this);
        }

        return $this;
    }

    public function removeOffer(Offer $offer): self
    {
        if ($this->offers->removeElement($offer) && $offer->getUser() === $this) {
            $offer->setUser(null);
        }

        return $this;
    }

    public function getSliders(): Collection
    {
        return $this->sliders;
    }

    public function addSlider(Slider $slider): self
    {
        if (!$this->sliders->contains($slider)) {
            $this->sliders[] = $slider;
            $slider->setUser($this);
        }

        return $this;
    }

    public function removeSlider(Slider $slider): self
    {
        if ($this->sliders->removeElement($slider) && $slider->getUser() === $this) {
            $slider->setUser(null);
        }

        return $this;
    }

    public function getRealizations(): Collection
    {
        return $this->realizations;
    }

    public function addRealization(Realization $realization): self
    {
        if (!$this->realizations->contains($realization)) {
            $this->realizations[] = $realization;
            $realization->setUser($this);
        }

        return $this;
    }

    public function removeRealization(Realization $realization): self
    {
        if ($this->realizations->removeElement($realization) && $realization->getUser() === $this) {
            $realization->setUser(null);
        }

        return $this;
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTasks(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setUser($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task) && $task->getUser() === $this) {
            $task->setUser(null);
        }

        return $this;
    }

    public function getTodoLists(): Collection
    {
        return $this->todoLists;
    }

    public function addTodoList(TodoList $todoList): self
    {
        if (!$this->todoLists->contains($todoList)) {
            $this->todoLists[] = $todoList;
            $todoList->setUser($this);
        }

        return $this;
    }

    public function removeTodoList(TodoList $todoList): self
    {
        if ($this->todoLists->removeElement($todoList) && $todoList->getuser() === $this) {
            $todoList->setUser(null);
        }

        return $this;
    }

    public function getTodoList(): Collection
    {
        return $this->todoTasks;
    }

    public function getTodoTasks(): Collection
    {
        return $this->todoTasks;
    }

    public function addTodoTask(TodoTask $todoTask): self
    {
        if (!$this->todoTasks->contains($todoTask)) {
            $this->todoTasks[] = $todoTask;
            $todoTask->setUser($this);
        }

        return $this;
    }

    public function removeTodoTask(TodoTask $todoTask): self
    {
        if ($this->todoTasks->removeElement($todoTask) && $todoTask->getuser() === $this) {
            $todoTask->setUser(null);
        }

        return $this;
    }
}
