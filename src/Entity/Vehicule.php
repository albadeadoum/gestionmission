<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
#[Vich\Uploadable]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Imatriculation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Marque = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $NBChassis = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $NBMoteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Puissace = null;

    #[ORM\Column(length: 255)]
    private ?string $Etat = null;

    #[ORM\Column(length: 255)]
    private ?string $Compteur = null;

    #[ORM\OneToMany(mappedBy: 'Vehicule', targetEntity: Piece::class, cascade: ['persist', 'remove'])]
    private Collection $Nom;

    #[ORM\OneToMany(mappedBy: 'Vehicule', targetEntity: Evenement::class, cascade: ['persist', 'remove'])]
    private Collection $evenements;

    #[ORM\Column(nullable: true)]
    private ?float $vidange = null;

    #[ORM\Column(nullable: true)]
    private ?float $pneus = null;

     // NOTE: This is not a mapped field of entity metadata, just a simple property.
     #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
     private ?File $imageFile = null;
 
     #[ORM\Column(nullable: true)]
     private ?string $imageName = null;

     #[ORM\Column(nullable: true)]
     private ?\DateTimeImmutable $updatedAt = null;

    

     #[ORM\OneToMany(mappedBy: 'vehicule', targetEntity: Assurance::class, cascade: ['persist', 'remove'])]
     private Collection $assurances;

     #[ORM\Column(length: 255, nullable: true)]
     private ?string $direction = null;



 
    public function __construct()
    {
        
        $this->evenements = new ArrayCollection();
        $this->assurances = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImatriculation(): ?string
    {
        return $this->Imatriculation;
    }

    public function setImatriculation(string $Imatriculation): self
    {
        $this->Imatriculation = $Imatriculation;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->Marque;
    }

    public function setMarque(?string $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }

    public function getNBChassis(): ?string
    {
        return $this->NBChassis;
    }

    public function setNBChassis(?string $NBChassis): self
    {
        $this->NBChassis = $NBChassis;

        return $this;
    }

    public function getNBMoteur(): ?string
    {
        return $this->NBMoteur;
    }

    public function setNBMoteur(?string $NBMoteur): self
    {
        $this->NBMoteur = $NBMoteur;

        return $this;
    }

    public function getPuissace(): ?string
    {
        return $this->Puissace;
    }

    public function setPuissace(?string $Puissace): self
    {
        $this->Puissace = $Puissace;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->Etat;
    }

    public function setEtat(string $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    public function getCompteur(): ?string
    {
        return $this->Compteur;
    }

    public function setCompteur(string $Compteur): self
    {
        $this->Compteur = $Compteur;

        return $this;
    }

    /**
     * @return Collection<int, Piece>
     */
    public function getNom(): Collection
    {
        return $this->Nom;
    }

    public function addNom(Piece $nom): self
    {
        if (!$this->Nom->contains($nom)) {
            $this->Nom->add($nom);
            $nom->setVehicule($this);
        }

        return $this;
    }

    public function removeNom(Piece $nom): self
    {
        if ($this->Nom->removeElement($nom)) {
            // set the owning side to null (unless already changed)
            if ($nom->getVehicule() === $this) {
                $nom->setVehicule(null);
            }
        }

        return $this;
    }

    public function __toString()
    {

        $retoure =$this->Imatriculation. ' '.  $this->Marque  ;
        return $retoure;  
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
            $evenement->setVehicule($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getVehicule() === $this) {
                $evenement->setVehicule(null);
            }
        }

        return $this;
    }

    public function getVidange(): ?float
    {
        return $this->vidange;
    }

    public function setVidange(?float $vidange): self
    {
        $this->vidange = $vidange;

        return $this;
    }

    public function getPneus(): ?float
    {
        return $this->pneus;
    }

    public function setPneus(?float $pneus): self
    {
        $this->pneus = $pneus;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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
            $assurance->setVehicule($this); // ✅ Ajout du setter pour garantir la relation
        }

        return $this;
    }

    public function removeAssurance(Assurance $assurance): static
    {
        if ($this->assurances->removeElement($assurance)) {
            if ($assurance->getVehicule() === $this) {
                $assurance->setVehicule(null); // ✅ Nettoyage de la relation
            }
        }

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(?string $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    
}
