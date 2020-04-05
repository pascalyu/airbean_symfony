<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RentRepository")
 */
class Rent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDateAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDateAt;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rents")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="rents")
     */
    private $Property;

    /**
     * @ORM\Column(type="integer")
     */
    private $personNbr;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDateAt(): ?\DateTimeInterface
    {
        return $this->startDateAt;
    }

    public function setStartDateAt(\DateTimeInterface $startDateAt): self
    {
        $this->startDateAt = $startDateAt;

        return $this;
    }

    public function getEndDateAt(): ?\DateTimeInterface
    {
        return $this->endDateAt;
    }

    public function setEndDateAt(\DateTimeInterface $endDateAt): self
    {
        $this->endDateAt = $endDateAt;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->Property;
    }

    public function setProperty(?Property $Property): self
    {
        $this->Property = $Property;

        return $this;
    }

    public function getPersonNbr(): ?int
    {
        return $this->personNbr;
    }

    public function setPersonNbr(int $personNbr): self
    {
        $this->personNbr = $personNbr;

        return $this;
    }
}
