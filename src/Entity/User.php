<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name :'users')]
class User
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_VIP = 2;

#[ORM\Id]
#[ORM\Column(type: Types::INTEGER)]
#[ORM\GeneratedValue]
private int $id;

#[ORM\Column(length: 30)]
private string $login;

#[ORM\Column(length: 32)]
private string $password;

#[ORM\Column(type: Types::SMALLINT)]
private int $status = 0;

#[ORM\OneToMany(mappedBy: 'user',targetEntity: Phone::class,fetch: 'LAZY')]
private Collection $phones;

    public function __construct(string $login, string $password, int $status = self::STATUS_DISABLED)
    {
        $this->login = $login;
        $this->changePassword($password);
        $this->status = $status;
        $this->phones = new ArrayCollection();
}

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    public function changePassword(string $password): void
    {
        $this->password = md5($password);
    }
}
