<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name :'users')]
class User
{
#[ORM\Id]
#[ORM\Column(type: Types::INTEGER)]
#[ORM\GeneratedValue]
private int $id;

#[ORM\Column(length: 30)]
private string $login;


    public function __construct(string $login)
    {
        $this->login = $login;
}

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }
}