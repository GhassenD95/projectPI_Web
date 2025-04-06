<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Utilisateur;
use Doctrine\Common\Collections\Collection;
use App\Entity\Matchsportif;

#[ORM\Entity]
class Equipe
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "equipes")]
    #[ORM\JoinColumn(name: 'coach_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Utilisateur $coach_id;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "string")]
    private string $division;

    #[ORM\Column(type: "string")]
    private string $sport;

    #[ORM\Column(type: "boolean")]
    private bool $isLocal;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getCoach_id()
    {
        return $this->coach_id;
    }

    public function setCoach_id($value)
    {
        $this->coach_id = $value;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($value)
    {
        $this->nom = $value;
    }

    public function getDivision()
    {
        return $this->division;
    }

    public function setDivision($value)
    {
        $this->division = $value;
    }

    public function getSport()
    {
        return $this->sport;
    }

    public function setSport($value)
    {
        $this->sport = $value;
    }

    public function getIsLocal()
    {
        return $this->isLocal;
    }

    public function setIsLocal($value)
    {
        $this->isLocal = $value;
    }

    #[ORM\OneToMany(mappedBy: "equipe_id", targetEntity: Utilisateur::class)]
    private Collection $utilisateurs;

        public function getUtilisateurs(): Collection
        {
            return $this->utilisateurs;
        }
    
        public function addUtilisateur(Utilisateur $utilisateur): self
        {
            if (!$this->utilisateurs->contains($utilisateur)) {
                $this->utilisateurs[] = $utilisateur;
                $utilisateur->setEquipe_id($this);
            }
    
            return $this;
        }
    
        public function removeUtilisateur(Utilisateur $utilisateur): self
        {
            if ($this->utilisateurs->removeElement($utilisateur)) {
                // set the owning side to null (unless already changed)
                if ($utilisateur->getEquipe_id() === $this) {
                    $utilisateur->setEquipe_id(null);
                }
            }
    
            return $this;
        }

    #[ORM\OneToMany(mappedBy: "equipe_id", targetEntity: Performanceequipe::class)]
    private Collection $performanceequipes;

    #[ORM\OneToMany(mappedBy: "equipe_id", targetEntity: Entrainment::class)]
    private Collection $entrainments;

    #[ORM\OneToMany(mappedBy: "equipe1_id", targetEntity: Matchsportif::class)]
    private Collection $matchsportifs;

        public function getMatchsportifs(): Collection
        {
            return $this->matchsportifs;
        }
    
        public function addMatchsportif(Matchsportif $matchsportif): self
        {
            if (!$this->matchsportifs->contains($matchsportif)) {
                $this->matchsportifs[] = $matchsportif;
                $matchsportif->setEquipe1_id($this);
            }
    
            return $this;
        }
    
        public function removeMatchsportif(Matchsportif $matchsportif): self
        {
            if ($this->matchsportifs->removeElement($matchsportif)) {
                // set the owning side to null (unless already changed)
                if ($matchsportif->getEquipe1_id() === $this) {
                    $matchsportif->setEquipe1_id(null);
                }
            }
    
            return $this;
        }

    #[ORM\OneToMany(mappedBy: "equipe2_id", targetEntity: Matchsportif::class)]
    private Collection $matchsportifs;

        public function getMatchsportifs(): Collection
        {
            return $this->matchsportifs;
        }
    
        public function addMatchsportif(Matchsportif $matchsportif): self
        {
            if (!$this->matchsportifs->contains($matchsportif)) {
                $this->matchsportifs[] = $matchsportif;
                $matchsportif->setEquipe2_id($this);
            }
    
            return $this;
        }
    
        public function removeMatchsportif(Matchsportif $matchsportif): self
        {
            if ($this->matchsportifs->removeElement($matchsportif)) {
                // set the owning side to null (unless already changed)
                if ($matchsportif->getEquipe2_id() === $this) {
                    $matchsportif->setEquipe2_id(null);
                }
            }
    
            return $this;
        }
}
