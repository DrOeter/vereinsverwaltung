<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $accountNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $accountHolderName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $accountType;

    /**
     * @ORM\Column(type="integer")
     */
    private $statusOfAccount;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="account", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=AccountActivity::class, mappedBy="account")
     */
    private $accountActivities;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $iban;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bic;

    public function __construct()
    {
        $this->accountActivities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountNumber(): ?int
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(int $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getAccountHolderName(): ?string
    {
        return $this->accountHolderName;
    }

    public function setAccountHolderName(string $accountHolderName): self
    {
        $this->accountHolderName = $accountHolderName;

        return $this;
    }

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }

    public function setAccountType(string $accountType): self
    {
        $this->accountType = $accountType;

        return $this;
    }

    public function getStatusOfAccount(): ?int
    {
        return $this->statusOfAccount;
    }

    public function setStatusOfAccount(int $statusOfAccount): self
    {
        $this->statusOfAccount = $statusOfAccount;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setAccount(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getAccount() !== $this) {
            $user->setAccount($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, AccountActivity>
     */
    public function getAccountActivities(): Collection
    {
        return $this->accountActivities;
    }

    public function addAccountActivity(AccountActivity $accountActivity): self
    {
        if (!$this->accountActivities->contains($accountActivity)) {
            $this->accountActivities[] = $accountActivity;
            $accountActivity->setAccount($this);
        }

        return $this;
    }

    public function removeAccountActivity(AccountActivity $accountActivity): self
    {
        if ($this->accountActivities->removeElement($accountActivity)) {
            // set the owning side to null (unless already changed)
            if ($accountActivity->getAccount() === $this) {
                $accountActivity->setAccount(null);
            }
        }

        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(string $bic): self
    {
        $this->bic = $bic;

        return $this;
    }
}
