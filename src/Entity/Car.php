<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $nce = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $kilometrage = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Showroom $showroom = null;

    public function getNce(): ?string
    {
        return $this->nce;
    }
    public function setNce(string $nce): self
    {
        $this->nce = $nce;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKilometrage(): ?float
    {
        return $this->kilometrage;
    }

    public function setKilometrage(float $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getShowroom(): ?Showroom
    {
        return $this->showroom;
    }

    public function setShowroom(?Showroom $showroom): self
    {
        $this->showroom = $showroom;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getNce();
    }
}
