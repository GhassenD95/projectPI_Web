<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Matchsportif;

#[ORM\Entity]
class Performanceathlete
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "performanceathletes")]
    #[ORM\JoinColumn(name: 'athlete_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Utilisateur $athlete_id;

        #[ORM\ManyToOne(targetEntity: Matchsportif::class, inversedBy: "performanceathletes")]
    #[ORM\JoinColumn(name: 'match_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Matchsportif $match_id;

    #[ORM\Column(type: "integer")]
    private int $minutesJouees;

    #[ORM\Column(type: "integer")]
    private int $buts;

    #[ORM\Column(type: "integer")]
    private int $passesDecisives;

    #[ORM\Column(type: "integer")]
    private int $tirs;

    #[ORM\Column(type: "integer")]
    private int $interceptions;

    #[ORM\Column(type: "integer")]
    private int $fautes;

    #[ORM\Column(type: "integer")]
    private int $cartonsJaunes;

    #[ORM\Column(type: "integer")]
    private int $cartonsRouges;

    #[ORM\Column(type: "integer")]
    private int $rebonds;

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

    public function getMatch_id()
    {
        return $this->match_id;
    }

    public function setMatch_id($value)
    {
        $this->match_id = $value;
    }

    public function getMinutesJouees()
    {
        return $this->minutesJouees;
    }

    public function setMinutesJouees($value)
    {
        $this->minutesJouees = $value;
    }

    public function getButs()
    {
        return $this->buts;
    }

    public function setButs($value)
    {
        $this->buts = $value;
    }

    public function getPassesDecisives()
    {
        return $this->passesDecisives;
    }

    public function setPassesDecisives($value)
    {
        $this->passesDecisives = $value;
    }

    public function getTirs()
    {
        return $this->tirs;
    }

    public function setTirs($value)
    {
        $this->tirs = $value;
    }

    public function getInterceptions()
    {
        return $this->interceptions;
    }

    public function setInterceptions($value)
    {
        $this->interceptions = $value;
    }

    public function getFautes()
    {
        return $this->fautes;
    }

    public function setFautes($value)
    {
        $this->fautes = $value;
    }

    public function getCartonsJaunes()
    {
        return $this->cartonsJaunes;
    }

    public function setCartonsJaunes($value)
    {
        $this->cartonsJaunes = $value;
    }

    public function getCartonsRouges()
    {
        return $this->cartonsRouges;
    }

    public function setCartonsRouges($value)
    {
        $this->cartonsRouges = $value;
    }

    public function getRebonds()
    {
        return $this->rebonds;
    }

    public function setRebonds($value)
    {
        $this->rebonds = $value;
    }
}
