<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Tournois
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom du tournoi est obligatoire")]
    private string $nom;

    #[ORM\Column(type: "string", columnDefinition: "ENUM('FOOTBALL', 'BASKETBALL', 'HANDBALL')")]
    private string $sport = 'FOOTBALL';

    #[ORM\Column(type: "datetime")]
    #[Assert\NotNull(message: "La date de début est obligatoire")]
    private \DateTimeInterface $dateDebut;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotNull(message: "La date de fin est obligatoire")]
    #[Assert\GreaterThan(propertyPath: "dateDebut", message: "La date de fin doit être après la date de début")]
    private \DateTimeInterface $dateFin;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "L'adresse est obligatoire")]
    private string $adresse;

    #[ORM\OneToMany(mappedBy: "tournois", targetEntity: Performanceequipe::class, orphanRemoval: true)]
    private Collection $performancesEquipes;

    #[ORM\OneToMany(mappedBy: "tournois", targetEntity: Matchsportif::class, orphanRemoval: true)]
    private Collection $matchs;

    public function __construct()
    {
        $this->performancesEquipes = new ArrayCollection();
        $this->matchs = new ArrayCollection();
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

    public function getSport(): string
    {
        return $this->sport;
    }

    public function setSport(string $sport): self
    {
        if (!in_array($sport, ['FOOTBALL', 'BASKETBALL', 'HANDBALL'])) {
            throw new \InvalidArgumentException("Sport invalide");
        }
        $this->sport = $sport;
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

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return Collection|Performanceequipe[]
     */
    public function getPerformancesEquipes(): Collection
    {
        return $this->performancesEquipes;
    }

    public function addPerformanceEquipe(Performanceequipe $performanceEquipe): self
    {
        if (!$this->performancesEquipes->contains($performanceEquipe)) {
            $this->performancesEquipes[] = $performanceEquipe;
            $performanceEquipe->setTournois($this);
        }
        return $this;
    }

    public function removePerformanceEquipe(Performanceequipe $performanceEquipe): self
    {
        if ($this->performancesEquipes->removeElement($performanceEquipe)) {
            if ($performanceEquipe->getTournois() === $this) {
                $performanceEquipe->setTournois(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Matchsportif[]
     */
    public function getMatchs(): Collection
    {
        return $this->matchs;
    }

    public function addMatch(Matchsportif $match): self
    {
        if (!$this->matchs->contains($match)) {
            $this->matchs[] = $match;
            $match->setTournois($this);
        }
        return $this;
    }

    public function removeMatch(Matchsportif $match): self
    {
        if ($this->matchs->removeElement($match)) {
            if ($match->getTournois() === $this) {
                $match->setTournois(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->nom . ' (' . $this->dateDebut->format('Y') . ')';
    }
}