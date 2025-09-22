<?php

namespace App\Entity;

use App\Repository\BailleurRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BailleurRepository::class)]
class Bailleur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $taux_ag = null;

    #[ORM\Column]
    private ?float $taux_ox = null;

    
    
    #[ORM\OneToMany(mappedBy: 'Bailleur', targetEntity: Evenement::class)]
    private Collection $evenements;

    #[ORM\OneToMany(mappedBy: 'bailleur', targetEntity: Mission::class)]
    private Collection $missions;

    
    

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->missions = new ArrayCollection();
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

    public function getTauxAg(): ?float
    {
        return $this->taux_ag;
    }

    public function setTauxAg(float $taux_ag): static
    {
        $this->taux_ag = $taux_ag;

        return $this;
    }

    public function getTauxOx(): ?float
    {
        return $this->taux_ox;
    }

    public function setTauxOx(float $taux_ox): static
    {
        $this->taux_ox = $taux_ox;

        return $this;
    }

   /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setChauffeur($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getChauffeur() === $this) {
                $evenement->setChauffeur(null);
            }
        }

        return $this;
    }


    public function __toString(): string
{
    return $this->nom ?? ''; // ou la propriété qui contient le nom du bailleur
}

/**
 * @return Collection<int, Mission>
 */
public function getMissions(): Collection
{
    return $this->missions;
}

public function addMission(Mission $mission): static
{
    if (!$this->missions->contains($mission)) {
        $this->missions->add($mission);
        $mission->setBailleur($this);
    }

    return $this;
}

public function removeMission(Mission $mission): static
{
    if ($this->missions->removeElement($mission)) {
        if ($mission->getBailleur() === $this) {
            $mission->setBailleur(null);
        }
    }

    return $this;
}

}
