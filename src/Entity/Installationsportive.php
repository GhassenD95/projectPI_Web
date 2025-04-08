<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class Installationsportive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "installationsGerees")]
    #[ORM\JoinColumn(name: 'manager_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ?Utilisateur $manager = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "string", length: 50)]
    private string $typeInstallation;

    #[ORM\Column(type: "string", length: 255)]
    private string $adresse;

    #[ORM\Column(type: "integer")]
    private int $capacite;

    #[ORM\Column(type: "boolean")]
    private bool $isDisponible;

    #[ORM\Column(type: "string", length: 255)]
    private string $image_url;

    #[ORM\OneToMany(mappedBy: "installationSportive", targetEntity: Equipement::class)]
    private Collection $equipements;

    #[ORM\OneToMany(mappedBy: "installationSportive", targetEntity: Entrainment::class)]
    private Collection $entrainments;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->entrainments = new ArrayCollection();
    }

    // Getters and Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getManager(): ?Utilisateur
    {
        return $this->manager;
    }

    public function setManager(?Utilisateur $manager): self
    {
        $this->manager = $manager;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getTypeInstallation(): string
    {
        return $this->typeInstallation;
    }

    public function setTypeInstallation(string $typeInstallation): self
    {
        $this->typeInstallation = $typeInstallation;
        return $this;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getCapacite(): int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;
        return $this;
    }

    public function isDisponible(): bool
    {
        return $this->isDisponible;
    }

    public function setIsDisponible(bool $isDisponible): self
    {
        $this->isDisponible = $isDisponible;
        return $this;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function setImageUrl(string $image_url): self
    {
        $this->image_url = $image_url;
        return $this;
    }

    /**
     * @return Collection|Equipement[]
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
            $equipement->setInstallationSportive($this);
        }
        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getInstallationSportive() === $this) {
                $equipement->setInstallationSportive(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Entrainment[]
     */
    public function getEntrainments(): Collection
    {
        return $this->entrainments;
    }

    public function addEntrainment(Entrainment $entrainment): self
    {
        if (!$this->entrainments->contains($entrainment)) {
            $this->entrainments[] = $entrainment;
            $entrainment->setInstallationSportive($this);
        }
        return $this;
    }

    public function removeEntrainment(Entrainment $entrainment): self
    {
        if ($this->entrainments->removeElement($entrainment)) {
            // set the owning side to null (unless already changed)
            if ($entrainment->getInstallationSportive() === $this) {
                $entrainment->setInstallationSportive(null);
            }
        }
        return $this;
    }
}