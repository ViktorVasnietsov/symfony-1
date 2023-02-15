<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name :'users')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface,PasswordAuthenticatedUserInterface
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_VIP = 2;

#[ORM\Id]
#[ORM\Column(type: Types::INTEGER)]
#[ORM\GeneratedValue]
private int $id;

#[ORM\Column(type: 'string', length: 180, unique: true)]
private $email;

#[ORM\Column(type: 'json')]
private $roles = [];

#[ORM\Column(length: 30)]
private string $login;

#[ORM\Column(type: 'string')]
private string $password;

#[ORM\Column(type: Types::SMALLINT)]
private int $status = 0;

#[ORM\OneToMany(mappedBy: 'user',targetEntity: Phone::class,fetch: 'LAZY')]
private Collection $phones;

#[ORM\OneToMany(mappedBy: 'url',targetEntity: UrlCodePair::class)]
private Collection $urls;

    public function __construct(string $login= '', string $password = '', int $status = self::STATUS_DISABLED)
    {
        $this->login = $login;
        $this->password = $password;
        $this->status = $status;
        $this->phones = new ArrayCollection();
        $this->urls = new ArrayCollection();
}

    /**
     * @return Collection
     */
    public function getUrls(): Collection
    {
        return $this->urls;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
}
