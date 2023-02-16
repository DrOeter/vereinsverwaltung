<?php

namespace App\Entity;

use App\Repository\SepaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SepaRepository::class)
 */
class Sepa
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
    private $iban;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bic;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $beneficiaryName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $purposeOfThePayment;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currency;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mandateReference;

    /**
     * @ORM\Column(type="integer")
     */
    private $creditorId;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="sepa", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBeneficiaryName(): ?string
    {
        return $this->beneficiaryName;
    }

    public function setBeneficiaryName(string $beneficiaryName): self
    {
        $this->beneficiaryName = $beneficiaryName;

        return $this;
    }

    public function getPurposeOfThePayment(): ?string
    {
        return $this->purposeOfThePayment;
    }

    public function setPurposeOfThePayment(string $purposeOfThePayment): self
    {
        $this->purposeOfThePayment = $purposeOfThePayment;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getMandateReference(): ?string
    {
        return $this->mandateReference;
    }

    public function setMandateReference(string $mandateReference): self
    {
        $this->mandateReference = $mandateReference;

        return $this;
    }

    public function getCreditorId(): ?int
    {
        return $this->creditorId;
    }

    public function setCreditorId(int $creditorId): self
    {
        $this->creditorId = $creditorId;

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
            $this->user->setSepa(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getSepa() !== $this) {
            $user->setSepa($this);
        }

        $this->user = $user;

        return $this;
    }
}
