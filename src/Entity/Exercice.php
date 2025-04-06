<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use App\Entity\Exercice_entrainment;

#[ORM\Entity]
class Exercice
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "string")]
    private string $typeExercice;

    #[ORM\Column(type: "integer")]
    private int $dureeMinutes;

    #[ORM\Column(type: "integer")]
    private int $sets;

    #[ORM\Column(type: "integer")]
    private int $reps;

    #[ORM\Column(type: "string", length: 255)]
    private string $image_url;

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

    public function getTypeExercice()
    {
        return $this->typeExercice;
    }

    public function setTypeExercice($value)
    {
        $this->typeExercice = $value;
    }

    public function getDureeMinutes()
    {
        return $this->dureeMinutes;
    }

    public function setDureeMinutes($value)
    {
        $this->dureeMinutes = $value;
    }

    public function getSets()
    {
        return $this->sets;
    }

    public function setSets($value)
    {
        $this->sets = $value;
    }

    public function getReps()
    {
        return $this->reps;
    }

    public function setReps($value)
    {
        $this->reps = $value;
    }

    public function getImage_url()
    {
        return $this->image_url;
    }

    public function setImage_url($value)
    {
        $this->image_url = $value;
    }

    #[ORM\OneToMany(mappedBy: "exercice_id", targetEntity: Exercice_entrainment::class)]
    private Collection $exercice_entrainments;

        public function getExercice_entrainments(): Collection
        {
            return $this->exercice_entrainments;
        }
    
        public function addExercice_entrainment(Exercice_entrainment $exercice_entrainment): self
        {
            if (!$this->exercice_entrainments->contains($exercice_entrainment)) {
                $this->exercice_entrainments[] = $exercice_entrainment;
                $exercice_entrainment->setExercice_id($this);
            }
    
            return $this;
        }
    
        public function removeExercice_entrainment(Exercice_entrainment $exercice_entrainment): self
        {
            if ($this->exercice_entrainments->removeElement($exercice_entrainment)) {
                // set the owning side to null (unless already changed)
                if ($exercice_entrainment->getExercice_id() === $this) {
                    $exercice_entrainment->setExercice_id(null);
                }
            }
    
            return $this;
        }
}
