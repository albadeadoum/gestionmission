<?php

namespace App\Entity;

use App\Repository\SignateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SignateurRepository::class)]
class Signateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $fonction = null;

    /**
     * @var Collection<int, Evenement>
     */
    #[ORM\OneToMany(mappedBy: 'signateur', targetEntity: Evenement::class)]
    private Collection $mission;

    public function __construct()
    {
        $this->mission = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(Evenement $mission): static
    {
        if (!$this->mission->contains($mission)) {
            $this->mission->add($mission);
            $mission->setSignateur($this);
        }

        return $this;
    }

    public function removeMission(Evenement $mission): static
    {
        if ($this->mission->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getSignateur() === $this) {
                $mission->setSignateur(null);
            }
        }

        return $this;
    }
}
