<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDone;

    public function __construct()
    {
        $this->createdAt = new Datetime();
        $this->isDone = false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\Datetime $createdAt): ?string
    {
        $this->createdAt = $createdAt;
        return null;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): ?string
    {
        $this->title = $title;
        return null;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): ?string
    {
        $this->content = $content;
        return null;
    }

    public function isDone(): bool
    {
        return $this->isDone;
    }

    public function toggle(bool $flag): ?string
    {
        $this->isDone = $flag;
        return null;
    }
}
