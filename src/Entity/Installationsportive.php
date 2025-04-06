<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\InstallationsportiveRepository")]
class Installationsportive
{
    public const TYPE_STADE = 'STADE';
    public const TYPE_SALLE_GYM = 'SALLE_GYM';
    public const TYPE_TERRAIN = 'TERRAIN';
    public const TYPE_PISCINE = 'PISCINE';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "installationsGerees")]
    #[ORM\JoinColumn(name: "manager_id", referencedColumnName: "id", nullable: true, onDelete: "SET NULL")]
    private ?Utilisateur $manager = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $nom;

    #[ORM\Column(type: "string", length: 20, columnDefinition: "ENUM('STADE', 'SALLE_GYM', 'TERRAIN', 'PISCINE')")]
    private string $typeInstallation = self::TYPE_STADE;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $adresse;

    #[ORM\Column(type: "integer")]
    #[Assert\PositiveOrZero]
    private int $capacite = 0;

    #[ORM\Column(type: "boolean")]
    private bool $isDisponible = true;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $imageUrl = null;

    #[ORM\OneToMany(mappedBy: "installationSportive", targetEntity: Equipement::class, orphanRemoval: true)]
    private Collection $equipements;

    #[ORM\OneToMany(mappedBy: "installationSportive", targetEntity: Entrainment::class)]
    private Collection $entrainements;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->entrainements = new ArrayCollection();
    }

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
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
        $validTypes = [self::TYPE_STADE, self::TYPE_SALLE_GYM, self::TYPE_TERRAIN, self::TYPE_PISCINE];
        if (!in_array($typeInstallation, $validTypes)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid installation type. Valid types are: %s',
                implode(', ', $validTypes)
            ));
        }
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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements->add($equipement);
            $equipement->setInstallationSportive($this);
        }
        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        if ($this->equipements->removeElement($equipement)) {
            if ($equipement->getInstallationSportive() === $this) {
                $equipement->setInstallationSportive(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Entrainment>
     */
    public function getEntrainements(): Collection
    {
        return $this->entrainements;
    }

    public function addEntrainement(Entrainment $entrainement): self
    {
        if (!$this->entrainements->contains($entrainement)) {
            $this->entrainements->add($entrainement);
            $entrainement->setInstallationSportive($this);
        }
        return $this;
    }

    public function removeEntrainement(Entrainment $entrainement): self
    {
        if ($this->entrainements->removeElement($entrainement)) {
            if ($entrainement->getInstallationSportive() === $this) {
                $entrainement->setInstallationSportive(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}