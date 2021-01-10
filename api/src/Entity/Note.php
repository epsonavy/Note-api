<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ApiResource
 * @ORM\Entity
 */
class Note
{
    /**
     * @var int The id of a note.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The title of the note.
     *
     * @ORM\Column(type="text", length=50)
     * @Assert\NotBlank
     * @Assert\Length(max="50")
     */
    public $title;

    /**
     * @var string The content of the note.
     *
     * @ORM\Column(type="text", length=1000)
     * @Assert\Length(max="1000")
     */
    public $content;

    /**
     * @var \DateTimeInterface When the note was updated.
     *
     * @ORM\Column(type="datetime")
     */
    public $updatedAt;

    /**
     * @var \DateTimeInterface When the note was created.
     *
     * @ORM\Column(type="datetime")
     */
    public $createdAt;

    /**
     * @param \DateTime $created
     */
    public function setCreatedAt(\DateTime $created): void
    {
        $this->createdAt = $created;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdatedAt(\DateTime $updated): void
    {
        $this->updatedAt = $updated;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->setCreatedAt(new \Datetime());
        $this->setUpdatedAt(new \Datetime());
    }
}
