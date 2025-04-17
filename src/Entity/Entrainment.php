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
    #[Assert\NotBlank]
    private ?Equipe $equipe = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'entraînement est obligatoire")]
    private string $nom;

    #[ORM\ManyToOne(targetEntity: Installationsportive::class, inversedBy: "entrainements")]
    #[ORM\JoinColumn(name: "installation_sportive_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    #[Assert\NotBlank()]
    private ?Installationsportive $installationSportive = null;

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank()]
    private string $description;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotNull()]
    #[Assert\NotBlank(message: "The start date is required.")]
    private \DateTimeInterface $dateDebut;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotNull()]
    #[Assert\NotBlank(message: "The end date is required.")]
    #[Assert\GreaterThan(propertyPath: "dateDebut", message: "Please choose a valid date interval.")]
    private \DateTimeInterface $dateFin;

    #[ORM\OneToMany(mappedBy: "entrainment", targetEntity: ExerciceEntrainment::class, orphanRemoval: true)]
    private Collection $exerciceEntrainments;

    /**
     * @throws \DateMalformedStringException
     */
    public function __construct()
    {
        $this->exerciceEntrainments = new ArrayCollection();
        $this->dateDebut = new \DateTimeImmutable(); // Sets to current datetime
        $this->dateFin = (new \DateTimeImmutable())->modify('+1 hour'); // Sets to 1 hour later
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

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'description' => $this->getDescription(),
            'dateDebut' => $this->getDateDebut()?->format('Y-m-d H:i:s'),
            'dateFin' => $this->getDateFin()?->format('Y-m-d H:i:s'),
            'equipe' => $this->getEquipe()?->getNom(),
            'installationSportive' => $this->getInstallationSportive()?->getNom(),
            // You might want to include IDs of related entities if needed
        ];
    }
}