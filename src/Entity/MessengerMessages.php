<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="messenger_messages", indexes={@ORM\Index(name="idx_75ea56e0fb7336f0", columns={"queue_name"}), @ORM\Index(name="idx_75ea56e0e3bd61ce", columns={"available_at"}), @ORM\Index(name="idx_75ea56e016ba31db", columns={"delivered_at"})})
 */
#[ORM\Entity]
class MessengerMessages
{
    #[ORM\Column(type: "bigint", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "messenger_messages_id_seq", allocationSize: 1, initialValue: 1)]
    private int $id;

    #[ORM\Column(type: "text", nullable: false)]
    private string $body;

    #[ORM\Column(type: "text", nullable: false)]
    private string $headers;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private string $queueName;

    #[ORM\Column(type: "datetime", nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(type: "datetime", nullable: false)]
    private DateTime $availableAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?DateTime $deliveredAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getHeaders(): string
    {
        return $this->headers;
    }

    public function getQueueName(): string
    {
        return $this->queueName;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }


    public function getAvailableAt(): DateTime
    {
        return $this->availableAt;
    }

    public function getDeliveredAt(): ?DateTime
    {
        return $this->deliveredAt;
    }
}
