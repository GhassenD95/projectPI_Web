<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Utilisateur;

#[ORM\Entity]
class Dossiermedical
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "dossiermedicals")]
    #[ORM\JoinColumn(name: 'athlete_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Utilisateur $athlete_id;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dernierCheckup;

    #[ORM\Column(type: "string", length: 255)]
    private string $allergies;

    #[ORM\Column(type: "string", length: 255)]
    private string $vaccinations;

    #[ORM\Column(type: "string")]
    private string $etatAthlete;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getAthlete_id()
    {
        return $this->athlete_id;
    }

    public function setAthlete_id($value)
    {
        $this->athlete_id = $value;
    }

    public function getDernierCheckup()
    {
        return $this->dernierCheckup;
    }

    public function setDernierCheckup($value)
    {
        $this->dernierCheckup = $value;
    }

    public function getAllergies()
    {
        return $this->allergies;
    }

    public function setAllergies($value)
    {
        $this->allergies = $value;
    }

    public function getVaccinations()
    {
        return $this->vaccinations;
    }

    public function setVaccinations($value)
    {
        $this->vaccinations = $value;
    }

    public function getEtatAthlete()
    {
        return $this->etatAthlete;
    }

    public function setEtatAthlete($value)
    {
        $this->etatAthlete = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }
}
