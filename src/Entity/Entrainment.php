<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: "App\Repository\EntrainmentRepository")]
class Entrainment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "entrainements")]
    #[ORM\JoinColumn(name: "equipe_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Equipe $equipe = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'entraînement est obligatoire")]
    private string $nom;

    #[ORM\ManyToOne(targetEntity: Installationsportive::class, inversedBy: "entrainements")]
    #[ORM\JoinColumn(name: "installation_sportive_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private ?Installationsportive $installationSportive = null;

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank(message: "La description est obligatoire")]
    private string $description;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotNull(message: "La date de début est obligatoire")]
    private \DateTimeInterface $dateDebut;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotNull(message: "La date de fin est obligatoire")]
    #[Assert\GreaterThan(propertyPath: "dateDebut", message: "La date de fin doit être après la date de début")]
    private \DateTimeInterface $dateFin;

    #[ORM\OneToMany(mappedBy: "entrainment", targetEntity: ExerciceEntrainment::class, orphanRemoval: true)]
    private Collection $exerciceEntrainments;

    public function __construct()
    {
        $this->exerciceEntrainments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        $this->equipe = $equipe;
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

    public function getInstallationSportive(): ?Installationsportive
    {
        return $this->installationSportive;
    }

    public function setInstallationSportive(?Installationsportive $installationSportive): self
    {
        $this->installationSportive = $installationSportive;
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

    public function getDateDebut(): \DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): \DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;
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
            $exerciceEntrainment->setEntrainment($this);
        }
        return $this;
    }

    public function removeExerciceEntrainment(ExerciceEntrainment $exerciceEntrainment): self
    {
        if ($this->exerciceEntrainments->removeElement($exerciceEntrainment)) {
            if ($exerciceEntrainment->getEntrainment() === $this) {
                $exerciceEntrainment->setEntrainment(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->nom . ' (' . $this->dateDebut->format('d/m/Y H:i') . ')';
    }
}