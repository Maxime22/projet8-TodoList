<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use App\Repository\UserRepository;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLES = [
        'ROLE_ADMIN' => 'ROLE_ADMIN',
        'ROLE_USER' => 'ROLE_USER'
    ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="Votre mot de passe ne peut être vide")
     * @Assert\Regex(
     *   pattern="/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,}$/",
     *   message="Au moins 8 caractères, un chiffre,
     *   une majuscule et un caractère spécial parmi : !@#$%^&*-")
     */
    private string $password;

    /**
     * @ORM\Column(type="string",     length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     * @var array<string>
     */
    private $roles = [];

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
    * @param array<string> $roles
    */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): ?string
    {
        return $this->username;
    }
}
