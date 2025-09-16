<?php

namespace App\Entity;


use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\Provider\Exception\NoMappingFound;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[Vich\Uploadable]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fin = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $background_color = null;

    #[ORM\Column(length: 255)]
    private ?string $border_color = null;

    #[ORM\Column(length: 255)]
    private ?string $text_color = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    private ?Vehicule $Vehicule = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    private ?Chauffeur $Chauffeur = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $Dotation = null;

    #[ORM\Column(nullable: true)]
    private ?float $Montant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Destination = null;

    #[ORM\OneToMany(mappedBy: 'mission', targetEntity: Carburant::class)]
    private Collection $carburants;

    #[ORM\OneToMany(mappedBy: 'mission', targetEntity: User::class)]
    private Collection $users;

    /**
     * @var Collection<int, Piece>
     */
    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Piece::class)]
    private Collection $pieces;

    /**
     * @var Collection<int, Agent>
     */
    #[ORM\ManyToMany(targetEntity: Agent::class)]
    #[ORM\JoinTable(name: "evenement_agent")]
    private Collection $agents;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    private ?Bailleur $bailleur = null; // nom au singulier et cohérent
    

     // NOTE: This is not a mapped field of entity metadata, just a simple property.
     #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName')]
     private ?File $imageFile = null;
 
     #[ORM\Column(nullable: true)]
     private ?string $imageName = null;

     #[ORM\Column(nullable: true)]
     private ?\DateTimeImmutable $updatedAt = null;

    
    
    public function __construct()
    {
        $this->carburants = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->pieces = new ArrayCollection();
        $this->agents = new ArrayCollection();
        $this->agents = new ArrayCollection();
        
        
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

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

    public function getBackgroundColor(): ?string
    {
        return $this->background_color;
    }

    public function setBackgroundColor(string $background_color): self
    {
        $this->background_color = $background_color;

        return $this;
    }

    public function getBorderColor(): ?string
    {
        return $this->border_color;
    }

    public function setBorderColor(string $border_color): self
    {
        $this->border_color = $border_color;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->text_color;
    }

    public function setTextColor(string $text_color): self
    {
        $this->text_color = $text_color;

        return $this;
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

    public function getChauffeur(): ?Chauffeur
    {
        return $this->Chauffeur;
    }

    public function setChauffeur(?Chauffeur $Chauffeur): self
    {
        $this->Chauffeur = $Chauffeur;

        return $this;
    }

    public function __toString()
    {

        $retoure =  $this->titre;
        return $this->titre; 
    }

    public function getDotation(): ?string
    {
        return $this->Dotation;
    }

    public function setDotation(?string $Dotation): self
    {
        $this->Dotation = $Dotation;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(?float $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->Destination;
    }

    public function setDestination(string $Destination): self
    {
        $this->Destination = $Destination;

        return $this;
    }

    /**
     * @return Collection<int, Carburant>
     */
    public function getCarburants(): Collection
    {
        return $this->carburants;
    }

    public function addCarburant(Carburant $carburant): self
    {
        if (!$this->carburants->contains($carburant)) {
            $this->carburants->add($carburant);
            $carburant->setMission($this);
        }

        return $this;
    }

    public function removeCarburant(Carburant $carburant): self
    {
        if ($this->carburants->removeElement($carburant)) {
            // set the owning side to null (unless already changed)
            if ($carburant->getMission() === $this) {
                $carburant->setMission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setMission($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getMission() === $this) {
                $user->setMission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Piece>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(Piece $piece): static
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces->add($piece);
            $piece->setEvent($this);
        }

        return $this;
    }

    public function removePiece(Piece $piece): static
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getEvent() === $this) {
                $piece->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }


    public function addAgent(Agent $agent): static
    {
        if (!$this->agents->contains($agent)) {
            $this->agents->add($agent);
        }
        return $this;
    }

    public function removeAgent(Agent $agent): static
    {
        $this->agents->removeElement($agent);
        return $this;
    }

    public function getBailleur(): ?Bailleur
    {
        return $this->bailleur;
    }

    public function setBailleur(?Bailleur $bailleur): self
    {
        $this->bailleur = $bailleur;
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


   
}
