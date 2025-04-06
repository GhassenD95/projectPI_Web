<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Tournois;

#[ORM\Entity]
class Performanceequipe
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "performanceequipes")]
    #[ORM\JoinColumn(name: 'equipe_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Equipe $equipe_id;

        #[ORM\ManyToOne(targetEntity: Tournois::class, inversedBy: "performanceequipes")]
    #[ORM\JoinColumn(name: 'tournois_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Tournois $tournois_id;

    #[ORM\Column(type: "integer")]
    private int $victoires;

    #[ORM\Column(type: "integer")]
    private int $pertes;

    #[ORM\Column(type: "integer")]
    private int $rang;

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

    public function getTournois_id()
    {
        return $this->tournois_id;
    }

    public function setTournois_id($value)
    {
        $this->tournois_id = $value;
    }

    public function getVictoires()
    {
        return $this->victoires;
    }

    public function setVictoires($value)
    {
        $this->victoires = $value;
    }

    public function getPertes()
    {
        return $this->pertes;
    }

    public function setPertes($value)
    {
        $this->pertes = $value;
    }

    public function getRang()
    {
        return $this->rang;
    }

    public function setRang($value)
    {
        $this->rang = $value;
    }
}
