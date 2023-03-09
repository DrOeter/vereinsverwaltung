<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer")
     */
    private $profession;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sepaAllowed = true;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $memePriority = 69;

    /**
     * @ORM\OneToOne(targetEntity=Account::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $account;

    /**
     * @ORM\OneToOne(targetEntity=Sepa::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $sepa;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->userName;
    }

    public function setUsername(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getProfession(): ?int
    {
        return $this->profession;
    }

    public function setProfession(int $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function isSepaAllowed(): ?bool
    {
        return $this->sepaAllowed;
    }

    public function setSepaAllowed(bool $sepaAllowed): self
    {
        $this->sepaAllowed = $sepaAllowed;

        return $this;
    }

    public function getMemePriority(): ?int
    {
        return $this->memePriority;
    }

    public function setMemePriority(?int $memePriority): self
    {
        $this->memePriority = $memePriority;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getSepa(): ?Sepa
    {
        return $this->sepa;
    }

    public function setSepa(?Sepa $sepa): self
    {
        $this->sepa = $sepa;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPlainPassword(string $password): self
    {
        //create Password Hasher
        $passwordHasherFactory = new PasswordHasherFactory([
            // auto hasher with default options for the User class (and children)
            User::class => ['algorithm' => 'auto'],

            // auto hasher with custom options for all PasswordAuthenticatedUserInterface instances
            PasswordAuthenticatedUserInterface::class => [
                'algorithm' => 'auto',
                'cost' => 15,
            ],
        ]);
        $passwordHasher = new UserPasswordHasher($passwordHasherFactory);

        $hashedPassword = $passwordHasher->hashPassword($this, $password);
        $this->setPassword($hashedPassword);

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getImg()
    {
        return null;
    }

    public function getRoles() {
        return ['ROLE_USER'];
    }

    /**
     * Returns the salt that was originally used to hash the password.
     *
     * This can return null if the password was not hashed using a salt.
     *
     * This method is deprecated since Symfony 5.3, implement it from {@link LegacyPasswordAuthenticatedUserInterface} instead.
     *
     * @return string|null
     */
    public function getSalt() {

    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {
        
    }

    public function getUserIdentifier(): string
    {
        return $this->userName;
    }

}
