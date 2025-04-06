<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Utilisateur;
use Doctrine\Common\Collections\Collection;
use App\Entity\Equipement;

#[ORM\Entity]
class Installationsportive
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "installationsportives")]
    #[ORM\JoinColumn(name: 'manager_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Utilisateur $manager_id;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "string")]
    private string $typeInstallation;

    #[ORM\Column(type: "string", length: 255)]
    private string $adresse;

    #[ORM\Column(type: "integer")]
    private int $capacite;

    #[ORM\Column(type: "boolean")]
    private bool $isDisponible;

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

    public function getManager_id()
    {
        return $this->manager_id;
    }

    public function setManager_id($value)
    {
        $this->manager_id = $value;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($value)
    {
        $this->nom = $value;
    }

    public function getTypeInstallation()
    {
        return $this->typeInstallation;
    }

    public function setTypeInstallation($value)
    {
        $this->typeInstallation = $value;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($value)
    {
        $this->adresse = $value;
    }

    public function getCapacite()
    {
        return $this->capacite;
    }

    public function setCapacite($value)
    {
        $this->capacite = $value;
    }

    public function getIsDisponible()
    {
        return $this->isDisponible;
    }

    public function setIsDisponible($value)
    {
        $this->isDisponible = $value;
    }

    public function getImage_url()
    {
        return $this->image_url;
    }

    public function setImage_url($value)
    {
        $this->image_url = $value;
    }

    #[ORM\OneToMany(mappedBy: "installationSportive_id", targetEntity: Equipement::class)]
    private Collection $equipements;

    #[ORM\OneToMany(mappedBy: "installationSportive_id", targetEntity: Entrainment::class)]
    private Collection $entrainments;
}
