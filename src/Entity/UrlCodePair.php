<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
//use DateTime;
#[ORM\Entity()]
#[ORM\Table(name: 'url_codes')]

class UrlCodePair
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(length:255)]
    private string $url;

    #[ORM\Column(length:12)]
    private string $code;

    #[ORM\Column(type: Types::INTEGER)]
    private int $counter = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,nullable: true)]
    private \DateTime $createdAt;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,nullable: true,updatable: true)]
    private \DateTime $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'urls')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;
    public function __construct(string $url, string $code, User $user)
    {
    $this->user = $user;
    $this->url = $url;
    $this->code = $code;
    $this->setCreatedAt();
    $this->setUpdatedAt();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }


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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    public function incrementCounter(): void
    {
        $this->counter++;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt():\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }

}