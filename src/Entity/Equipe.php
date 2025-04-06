<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "equipesCoachees")]
    #[ORM\JoinColumn(name: "coach_id", referencedColumnName: "id", onDelete: "SET NULL")]
    private ?Utilisateur $coach = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'équipe est obligatoire")]
    private string $nom;

    #[ORM\Column(type: "string", columnDefinition: "ENUM('JEUNES', 'AMATEUR', 'PRO')")]
    private string $division = 'AMATEUR'; // Default value

    #[ORM\Column(type: "string", columnDefinition: "ENUM('FOOTBALL', 'BASKETBALL', 'HANDBALL')")]
    private string $sport = 'FOOTBALL'; // Default value

    #[ORM\Column(type: "boolean")]
    private bool $isLocal = false; // Default value

    #[ORM\OneToMany(mappedBy: "equipe", targetEntity: Utilisateur::class)]
    private Collection $membres;

    #[ORM\OneToMany(mappedBy: "equipe", targetEntity: Performanceequipe::class)]
    private Collection $performances;

    #[ORM\OneToMany(mappedBy: "equipe", targetEntity: Entrainment::class)]
    private Collection $entrainements;

    // In Equipe.php
    #[ORM\OneToMany(mappedBy: "equipe1", targetEntity: Matchsportif::class)]
    private Collection $matchsAsTeam1;  // Changed from matchsEquipe1

    #[ORM\OneToMany(mappedBy: "equipe2", targetEntity: Matchsportif::class)]
    private Collection $matchsAsTeam2;  // Changed from matchsEquipe2

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->performances = new ArrayCollection();
        $this->entrainements = new ArrayCollection();
        $this->matchsEquipe1 = new ArrayCollection();
        $this->matchsEquipe2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoach(): ?Utilisateur
    {
        return $this->coach;
    }

    public function setCoach(?Utilisateur $coach): self
    {
        $this->coach = $coach;
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

    public function getDivision(): string
    {
        return $this->division;
    }

    public function setDivision(string $division): self
    {
        if (!in_array($division, ['JEUNES', 'AMATEUR', 'PRO'])) {
            throw new \InvalidArgumentException("Division invalide");
        }
        $this->division = $division;
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

    public function isLocal(): bool
    {
        return $this->isLocal;
    }

    public function setIsLocal(bool $isLocal): self
    {
        $this->isLocal = $isLocal;
        return $this;
    }

    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Utilisateur $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
            $membre->setEquipe($this);
        }
        return $this;
    }

    public function removeMembre(Utilisateur $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            if ($membre->getEquipe() === $this) {
                $membre->setEquipe(null);
            }
        }
        return $this;
    }

    public function getPerformances(): Collection
    {
        return $this->performances;
    }

    public function addPerformance(Performanceequipe $performance): self
    {
        if (!$this->performances->contains($performance)) {
            $this->performances[] = $performance;
            $performance->setEquipe($this);
        }
        return $this;
    }

    public function removePerformance(Performanceequipe $performance): self
    {
        if ($this->performances->removeElement($performance)) {
            if ($performance->getEquipe() === $this) {
                $performance->setEquipe(null);
            }
        }
        return $this;
    }

    public function getEntrainements(): Collection
    {
        return $this->entrainements;
    }

    public function addEntrainement(Entrainment $entrainement): self
    {
        if (!$this->entrainements->contains($entrainement)) {
            $this->entrainements[] = $entrainement;
            $entrainement->setEquipe($this);
        }
        return $this;
    }

    public function removeEntrainement(Entrainment $entrainement): self
    {
        if ($this->entrainements->removeElement($entrainement)) {
            if ($entrainement->getEquipe() === $this) {
                $entrainement->setEquipe(null);
            }
        }
        return $this;
    }

    public function getMatchsEquipe1(): Collection
    {
        return $this->matchsEquipe1;
    }

    public function addMatchEquipe1(Matchsportif $match): self
    {
        if (!$this->matchsEquipe1->contains($match)) {
            $this->matchsEquipe1[] = $match;
            $match->setEquipe1($this);
        }
        return $this;
    }

    public function removeMatchEquipe1(Matchsportif $match): self
    {
        if ($this->matchsEquipe1->removeElement($match)) {
            if ($match->getEquipe1() === $this) {
                $match->setEquipe1(null);
            }
        }
        return $this;
    }

    public function getMatchsEquipe2(): Collection
    {
        return $this->matchsEquipe2;
    }

    public function addMatchEquipe2(Matchsportif $match): self
    {
        if (!$this->matchsEquipe2->contains($match)) {
            $this->matchsEquipe2[] = $match;
            $match->setEquipe2($this);
        }
        return $this;
    }

    public function removeMatchEquipe2(Matchsportif $match): self
    {
        if ($this->matchsEquipe2->removeElement($match)) {
            if ($match->getEquipe2() === $this) {
                $match->setEquipe2(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}