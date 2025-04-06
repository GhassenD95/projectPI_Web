<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Installationsportive;
use Doctrine\Common\Collections\Collection;
use App\Entity\Exercice_entrainment;

#[ORM\Entity]
class Entrainment
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "entrainments")]
    #[ORM\JoinColumn(name: 'equipe_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Equipe $equipe_id;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

        #[ORM\ManyToOne(targetEntity: Installationsportive::class, inversedBy: "entrainments")]
    #[ORM\JoinColumn(name: 'installationSportive_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Installationsportive $installationSportive_id;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateDebut;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $dateFin;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getEquipe_id()
    {
        return $this->equipe_id;
    }

    public function setEquipe_id($value)
    {
        $this->equipe_id = $value;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($value)
    {
        $this->nom = $value;
    }

    public function getInstallationSportive_id()
    {
        return $this->installationSportive_id;
    }

    public function setInstallationSportive_id($value)
    {
        $this->installationSportive_id = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
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

    #[ORM\OneToMany(mappedBy: "entrainment_id", targetEntity: Exercice_entrainment::class)]
    private Collection $exercice_entrainments;
}
