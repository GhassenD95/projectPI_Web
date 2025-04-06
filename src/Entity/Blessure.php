<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;

#[ORM\Entity(repositoryClass: "App\Repository\BlessureRepository")]
class Blessure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "blessures")]
    #[ORM\JoinColumn(name: "athlete_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Utilisateur $athlete = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $typeBlessure;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateBlessure;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateReprise;

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

    public function getTypeBlessure(): string
    {
        return $this->typeBlessure;
    }

    public function setTypeBlessure(string $typeBlessure): self
    {
        $this->typeBlessure = $typeBlessure;
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

    public function getDateBlessure(): \DateTimeInterface
    {
        return $this->dateBlessure;
    }

    public function setDateBlessure(\DateTimeInterface $dateBlessure): self
    {
        $this->dateBlessure = $dateBlessure;
        return $this;
    }

    public function getDateReprise(): \DateTimeInterface
    {
        return $this->dateReprise;
    }

    public function setDateReprise(\DateTimeInterface $dateReprise): self
    {
        $this->dateReprise = $dateReprise;
        return $this;
    }

    // Optional: Add __toString() for better display
    public function __toString(): string
    {
        return $this->typeBlessure . ' (' . $this->dateBlessure->format('Y-m-d') . ')';
    }
}