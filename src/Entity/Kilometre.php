<?php

namespace App\Entity;

use App\Repository\KilometreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KilometreRepository::class)]
class Kilometre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column]
    private ?float $kilometre = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getKilometre(): ?float
    {
        return $this->kilometre;
    }

    public function setKilometre(float $kilometre): self
    {
        $this->kilometre = $kilometre;

        return $this;
    }
}
