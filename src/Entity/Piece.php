<?php

namespace App\Entity;

use App\Repository\PieceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PieceRepository::class)]
class Piece
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Nom')]
    private ?Vehicule $Vehicule = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Quantitite = null;

    #[ORM\Column(length: 255)]
    private ?string $Observation = null;

    #[ORM\Column(nullable: true)]
    private ?float $cout = null;

    #[ORM\ManyToOne(inversedBy: 'pieces')]
    private ?Evenement $event = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $garage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->Vehicule;
    }

    public function setVehicule(?Vehicule $Vehicule): self
    {
        $this->Vehicule = $Vehicule;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getQuantitite(): ?string
    {
        return $this->Quantitite;
    }

    public function setQuantitite(?string $Quantitite): self
    {
        $this->Quantitite = $Quantitite;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->Observation;
    }

    public function setObservation(string $Observation): self
    {
        $this->Observation = $Observation;

        return $this;
    }

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(?float $cout): static
    {
        $this->cout = $cout;

        return $this;
    }

    public function getEvent(): ?Evenement
    {
        return $this->event;
    }

    public function setEvent(?Evenement $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getGarage(): ?string
    {
        return $this->garage;
    }

    public function setGarage(?string $garage): static
    {
        $this->garage = $garage;

        return $this;
    }
}
