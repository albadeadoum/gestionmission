<?php


namespace App\Entity;

use App\Repository\MotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotoRepository::class)]
class Moto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $utilisateur = null;

    #[ORM\OneToMany(targetEntity: Assurance::class, mappedBy: 'moto', cascade: ['persist', 'remove'])]
    private Collection $assurances;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAffec = null; // ✅ Relation OneToMany avec Assurance

    public function __construct()
    {
        $this->assurances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getUtilisateur(): ?string
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?string $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Assurance>
     */
    public function getAssurances(): Collection
    {
        return $this->assurances;
    }

    public function addAssurance(Assurance $assurance): static
    {
        if (!$this->assurances->contains($assurance)) {
            $this->assurances->add($assurance);
            $assurance->setMoto($this); // ✅ Ajuste la relation côté Assurance
        }

        return $this;
    }

    public function removeAssurance(Assurance $assurance): static
    {
        if ($this->assurances->removeElement($assurance)) {
            if ($assurance->getMoto() === $this) {
                $assurance->setMoto(null); // ✅ Supprime la relation proprement
            }
        }

        return $this;
    }

    public function __toString()
    {

        $retoure =$this->immatriculation. ' '.  $this->marque  ;
        return $retoure;  
    }

    public function getDateAffec(): ?\DateTimeInterface
    {
        return $this->dateAffec;
    }

    public function setDateAffec(?\DateTimeInterface $dateAffec): static
    {
        $this->dateAffec = $dateAffec;

        return $this;
    }
}
