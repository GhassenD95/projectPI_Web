<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Exercice;

#[ORM\Entity]
class Exercice_entrainment
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Entrainment::class, inversedBy: "exercice_entrainments")]
    #[ORM\JoinColumn(name: 'entrainment_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Entrainment $entrainment_id;

        #[ORM\ManyToOne(targetEntity: Exercice::class, inversedBy: "exercice_entrainments")]
    #[ORM\JoinColumn(name: 'exercice_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Exercice $exercice_id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getEntrainment_id()
    {
        return $this->entrainment_id;
    }

    public function setEntrainment_id($value)
    {
        $this->entrainment_id = $value;
    }

    public function getExercice_id()
    {
        return $this->exercice_id;
    }

    public function setExercice_id($value)
    {
        $this->exercice_id = $value;
    }
}
