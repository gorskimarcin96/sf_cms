<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Offer implements TranslatableInterface
{
    use TranslatableTrait;
    use TimeStampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: "User")]
    #[ORM\JoinColumn(nullable: false)]
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
