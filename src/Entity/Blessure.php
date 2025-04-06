<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Utilisateur;

#[ORM\Entity]
class Blessure
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "blessures")]
    #[ORM\JoinColumn(name: 'athlete_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Utilisateur $athlete_id;

    #[ORM\Column(type: "string")]
    private string $typeBlessure;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateBlessure;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateReprise;

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

    public function getTypeBlessure()
    {
        return $this->typeBlessure;
    }

    public function setTypeBlessure($value)
    {
        $this->typeBlessure = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getDateBlessure()
    {
        return $this->dateBlessure;
    }

    public function setDateBlessure($value)
    {
        $this->dateBlessure = $value;
    }

    public function getDateReprise()
    {
        return $this->dateReprise;
    }

    public function setDateReprise($value)
    {
        $this->dateReprise = $value;
    }
}
