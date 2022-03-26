<?php

namespace App\Entity;

use App\Entity\Traits\FileUploadTrait;
use App\Entity\Traits\TimeStampableTrait;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\Cache("NONSTRICT_READ_WRITE")
 * @ORM\HasLifecycleCallbacks()
 */
class Article implements TranslatableInterface
{
    use TranslatableTrait;
    use TimeStampableTrait;
    use FileUploadTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->translate($this->defaultLocale)?->getTitle();
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
}
