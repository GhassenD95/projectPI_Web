<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use App\Entity\Matchsportif;

#[ORM\Entity]
class Tournois
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "string")]
    private string $sport;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateDebut;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateFin;

    #[ORM\Column(type: "string", length: 255)]
    private string $adresse;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($value)
    {
        $this->nom = $value;
    }

    public function getSport()
    {
        return $this->sport;
    }

    public function setSport($value)
    {
        $this->sport = $value;
    }

    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    public function setDateDebut($value)
    {
        $this->dateDebut = $value;
    }

    public function getDateFin()
    {
        return $this->dateFin;
    }

    public function setDateFin($value)
    {
        $this->dateFin = $value;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($value)
    {
        $this->adresse = $value;
    }

    #[ORM\OneToMany(mappedBy: "tournois_id", targetEntity: Performanceequipe::class)]
    private Collection $performanceequipes;

        public function getPerformanceequipes(): Collection
        {
            return $this->performanceequipes;
        }
    
        public function addPerformanceequipe(Performanceequipe $performanceequipe): self
        {
            if (!$this->performanceequipes->contains($performanceequipe)) {
                $this->performanceequipes[] = $performanceequipe;
                $performanceequipe->setTournois_id($this);
            }
    
            return $this;
        }
    
        public function removePerformanceequipe(Performanceequipe $performanceequipe): self
        {
            if ($this->performanceequipes->removeElement($performanceequipe)) {
                // set the owning side to null (unless already changed)
                if ($performanceequipe->getTournois_id() === $this) {
                    $performanceequipe->setTournois_id(null);
                }
            }
    
            return $this;
        }

    #[ORM\OneToMany(mappedBy: "tournois_id", targetEntity: Matchsportif::class)]
    private Collection $matchsportifs;
}
