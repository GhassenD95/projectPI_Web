<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Installationsportive;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\EquipementRepository")]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'équipement est obligatoire")]
    private string $nom;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "La description est obligatoire")]
    private string $description;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(message: "L'état de l'équipement est obligatoire")]
    private string $etat;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(message: "Le type d'équipement est obligatoire")]
    private string $typeEquipement;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(type: "integer")]
    #[Assert\PositiveOrZero(message: "La quantité doit être positive")]
    private int $quantite = 0;

    #[ORM\ManyToOne(targetEntity: Installationsportive::class, inversedBy: "equipements")]
    #[ORM\JoinColumn(name: "installation_sportive_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Installationsportive $installationSportive = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getEtat(): string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;
        return $this;
    }

    public function getTypeEquipement(): string
    {
        return $this->typeEquipement;
    }

    public function setTypeEquipement(string $typeEquipement): self
    {
        $this->typeEquipement = $typeEquipement;
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

    public function getQuantite(): int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;
        return $this;
    }

    public function getInstallationSportive(): ?Installationsportive
    {
        return $this->installationSportive;
    }

    public function setInstallationSportive(?Installationsportive $installationSportive): self
    {
        $this->installationSportive = $installationSportive;
        return $this;
    }

    // Optional: Add __toString() for better display
    public function __toString(): string
    {
        return $this->nom . ' (' . $this->typeEquipement . ')';
    }
}