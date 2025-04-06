<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Installationsportive;

#[ORM\Entity]
class Equipement
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    #[ORM\Column(type: "string")]
    private string $etat;

    #[ORM\Column(type: "string")]
    private string $typeEquipement;

    #[ORM\Column(type: "string", length: 255)]
    private string $image_url;

    #[ORM\Column(type: "integer")]
    private int $quantite;

        #[ORM\ManyToOne(targetEntity: Installationsportive::class, inversedBy: "equipements")]
    #[ORM\JoinColumn(name: 'installationSportive_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Installationsportive $installationSportive_id;

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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat($value)
    {
        $this->etat = $value;
    }

    public function getTypeEquipement()
    {
        return $this->typeEquipement;
    }

    public function setTypeEquipement($value)
    {
        $this->typeEquipement = $value;
    }

    public function getImage_url()
    {
        return $this->image_url;
    }

    public function setImage_url($value)
    {
        $this->image_url = $value;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function setQuantite($value)
    {
        $this->quantite = $value;
    }

    public function getInstallationSportive_id()
    {
        return $this->installationSportive_id;
    }

    public function setInstallationSportive_id($value)
    {
        $this->installationSportive_id = $value;
    }
}
