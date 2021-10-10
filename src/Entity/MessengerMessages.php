<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * MessengerMessages
 *
 * @ORM\Table(name="messenger_messages", indexes={@ORM\Index(name="idx_75ea56e0fb7336f0", columns={"queue_name"}), @ORM\Index(name="idx_75ea56e0e3bd61ce", columns={"available_at"}), @ORM\Index(name="idx_75ea56e016ba31db", columns={"delivered_at"})})
 * @ORM\Entity
 */
class MessengerMessages
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="messenger_messages_id_seq", allocationSize=1, initialValue=1)
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=false)
     */
    private string $body;

    /**
     * @var string
     *
     * @ORM\Column(name="headers", type="text", nullable=false)
     */
    private string $headers;

    /**
     * @var string
     *
     * @ORM\Column(name="queue_name", type="string", length=255, nullable=false)
     */
    private string $queueName;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private DateTime $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="available_at", type="datetime", nullable=false)
     */
    private DateTime $availableAt;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="delivered_at", type="datetime", nullable=true)
     */
    private ?DateTime $deliveredAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getHeaders(): string
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->queueName;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getAvailableAt(): DateTime
    {
        return $this->availableAt;
    }

    /**
     * @return DateTime|null
     */
    public function getDeliveredAt(): ?DateTime
    {
        return $this->deliveredAt;
    }
}
