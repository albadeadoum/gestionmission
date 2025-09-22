<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $objet = null;

    /**
     * @var Collection<int, Evenement>
     */
    #[ORM\OneToMany(mappedBy: 'mission', targetEntity: Evenement::class, cascade: ['remove'])]
    private Collection $axe;

    #[ORM\ManyToOne(targetEntity: Bailleur::class, inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Bailleur $bailleur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    public function __construct()
    {
        $this->axe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getAxe(): Collection
    {
        return $this->axe;
    }

    public function addAxe(Evenement $axe): static
    {
        if (!$this->axe->contains($axe)) {
            $this->axe->add($axe);
            $axe->setMission($this);
        }

        return $this;
    }

    public function removeAxe(Evenement $axe): static
    {
        if ($this->axe->removeElement($axe)) {
            // set the owning side to null (unless already changed)
            if ($axe->getMission() === $this) {
                $axe->setMission(null);
            }
        }

        return $this;
    }

    public function getBailleur(): ?Bailleur
    {
        return $this->bailleur;
    }

    public function setBailleur(?Bailleur $bailleur): static
    {
        $this->bailleur = $bailleur;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }
}