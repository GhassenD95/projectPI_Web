<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\ExerciceRepository")]
class Exercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'exercice est obligatoire")]
    private string $nom;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(message: "Le type d'exercice est obligatoire")]
    private string $typeExercice;

    #[ORM\Column(type: "integer")]
    #[Assert\Positive(message: "La durée doit être positive")]
    private int $dureeMinutes;

    #[ORM\Column(type: "integer")]
    #[Assert\PositiveOrZero(message: "Le nombre de sets doit être positif ou zéro")]
    private int $sets;

    #[ORM\Column(type: "integer")]
    #[Assert\PositiveOrZero(message: "Le nombre de répétitions doit être positif ou zéro")]
    private int $reps;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\OneToMany(mappedBy: "exercice", targetEntity: ExerciceEntrainment::class, orphanRemoval: true)]
    private Collection $exerciceEntrainments;

    public function __construct()
    {
        $this->exerciceEntrainments = new ArrayCollection();
    }

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

    public function getTypeExercice(): string
    {
        return $this->typeExercice;
    }

    public function setTypeExercice(string $typeExercice): self
    {
        $this->typeExercice = $typeExercice;
        return $this;
    }

    public function getDureeMinutes(): int
    {
        return $this->dureeMinutes;
    }

    public function setDureeMinutes(int $dureeMinutes): self
    {
        $this->dureeMinutes = $dureeMinutes;
        return $this;
    }

    public function getSets(): int
    {
        return $this->sets;
    }

    public function setSets(int $sets): self
    {
        $this->sets = $sets;
        return $this;
    }

    public function getReps(): int
    {
        return $this->reps;
    }

    public function setReps(int $reps): self
    {
        $this->reps = $reps;
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
     * @return Collection<int, ExerciceEntrainment>
     */
    public function getExerciceEntrainments(): Collection
    {
        return $this->exerciceEntrainments;
    }

    public function addExerciceEntrainment(ExerciceEntrainment $exerciceEntrainment): self
    {
        if (!$this->exerciceEntrainments->contains($exerciceEntrainment)) {
            $this->exerciceEntrainments->add($exerciceEntrainment);
            $exerciceEntrainment->setExercice($this);
        }
        return $this;
    }

    public function removeExerciceEntrainment(ExerciceEntrainment $exerciceEntrainment): self
    {
        if ($this->exerciceEntrainments->removeElement($exerciceEntrainment)) {
            if ($exerciceEntrainment->getExercice() === $this) {
                $exerciceEntrainment->setExercice(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}