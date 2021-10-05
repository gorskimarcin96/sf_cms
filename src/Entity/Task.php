<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\TaskRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Cache("NONSTRICT_READ_WRITE")
 * @ORM\HasLifecycleCallbacks()
 */
class Task
{
    use TimeStampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $class;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $executedAt;

    /**
     * @ORM\Column(type="json")
     */
    private array $arguments;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isAdded = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $hasError = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getExecutedAt(): DateTime
    {
        return $this->executedAt;
    }

    public function setExecutedAt(DateTime $executedAt): self
    {
        $this->executedAt = $executedAt;

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

    public function getArguments(): string
    {
        return json_encode($this->arguments);
    }

    public function setArguments(string $arguments): self
    {
        $this->arguments = json_decode($arguments, true);

        return $this;
    }

    public function getIsAdded(): bool
    {
        return $this->isAdded;
    }

    public function setIsAdded(bool $isAdded): self
    {
        $this->isAdded = $isAdded;

        return $this;
    }

    public function getHasError(): bool
    {
        return $this->hasError;
    }

    public function setHasError(bool $hasError): self
    {
        $this->hasError = $hasError;

        return $this;
    }
}
