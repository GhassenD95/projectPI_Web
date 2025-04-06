<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\ExerciceEntrainmentRepository")]
class ExerciceEntrainment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Entrainment::class, inversedBy: "exerciceEntrainments")]
    #[ORM\JoinColumn(name: "entrainment_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Entrainment $entrainment = null;

    #[ORM\ManyToOne(targetEntity: Exercice::class, inversedBy: "exerciceEntrainments")]
    #[ORM\JoinColumn(name: "exercice_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Exercice $exercice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntrainment(): ?Entrainment
    {
        return $this->entrainment;
    }

    public function setEntrainment(?Entrainment $entrainment): self
    {
        $this->entrainment = $entrainment;
        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): self
    {
        $this->exercice = $exercice;
        return $this;
    }
}