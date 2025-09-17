<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $service = null;

    #[ORM\Column(length: 255)]
    private ?string $lien_empl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fonction = null;

    #[ORM\ManyToMany(targetEntity: Evenement::class, mappedBy: "agents")]
    private Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): static
    {
        $this->service = $service;
        return $this;
    }

    public function getLienEmpl(): ?string
    {
        return $this->lien_empl;
    }

    public function setLienEmpl(string $lien_empl): static
    {
        $this->lien_empl = $lien_empl;
        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
 * @return Collection<int, Evenement>
 */
public function getEvenements(): Collection
{
    return $this->evenements;
}

public function addEvenement(Evenement $evenement): static
{
    if (!$this->evenements->contains($evenement)) {
        $this->evenements->add($evenement);
        $evenement->addAgent($this); // synchroniser les deux côtés
    }

    return $this;
}

public function removeEvenement(Evenement $evenement): static
{
    if ($this->evenements->removeElement($evenement)) {
        $evenement->removeAgent($this);
    }

    return $this;
}
}