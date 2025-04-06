<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;

#[ORM\Entity(repositoryClass: "App\Repository\DossiermedicalRepository")]
class Dossiermedical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "dossiersMedicaux")]
    #[ORM\JoinColumn(name: "athlete_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Utilisateur $athlete = null;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dernierCheckup;

    #[ORM\Column(type: "string", length: 255)]
    private string $allergies;

    #[ORM\Column(type: "string", length: 255)]
    private string $vaccinations;

    #[ORM\Column(type: "string", length: 255)]
    private string $etatAthlete;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAthlete(): ?Utilisateur
    {
        return $this->athlete;
    }

    public function setAthlete(?Utilisateur $athlete): self
    {
        $this->athlete = $athlete;
        return $this;
    }

    public function getDernierCheckup(): \DateTimeInterface
    {
        return $this->dernierCheckup;
    }

    public function setDernierCheckup(\DateTimeInterface $dernierCheckup): self
    {
        $this->dernierCheckup = $dernierCheckup;
        return $this;
    }

    public function getAllergies(): string
    {
        return $this->allergies;
    }

    public function setAllergies(string $allergies): self
    {
        $this->allergies = $allergies;
        return $this;
    }

    public function getVaccinations(): string
    {
        return $this->vaccinations;
    }

    public function setVaccinations(string $vaccinations): self
    {
        $this->vaccinations = $vaccinations;
        return $this;
    }

    public function getEtatAthlete(): string
    {
        return $this->etatAthlete;
    }

    public function setEtatAthlete(string $etatAthlete): self
    {
        $this->etatAthlete = $etatAthlete;
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

    // Optional: Add __toString() for better display
    public function __toString(): string
    {
        return 'Dossier médical #' . $this->id . ' - ' . $this->athlete;
    }
}