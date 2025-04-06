<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;
use App\Entity\Matchsportif;

#[ORM\Entity(repositoryClass: "App\Repository\PerformanceathleteRepository")]
class Performanceathlete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "performancesAthlete")]
    #[ORM\JoinColumn(name: "athlete_id", referencedColumnName: "id", nullable: false)]
    private ?Utilisateur $athlete = null;

    #[ORM\ManyToOne(targetEntity: Matchsportif::class, inversedBy: "performances")]
    #[ORM\JoinColumn(name: "match_id", referencedColumnName: "id", nullable: false)]
    private ?Matchsportif $match = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $minutesJouees = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $buts = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $passesDecisives = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $tirs = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $interceptions = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $fautes = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $cartonsJaunes = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $cartonsRouges = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $rebonds = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAthlete(): ?Utilisateur
    {
        return $this->athlete;
    }

    public function setAthlete(?Utilisateur $athlete): self
    {
        $this->athlete = $athlete;
        return $this;
    }

    public function getMatch(): ?Matchsportif
    {
        return $this->match;
    }

    public function setMatch(?Matchsportif $match): self
    {
        $this->match = $match;
        return $this;
    }

    public function getMinutesJouees(): ?int
    {
        return $this->minutesJouees;
    }

    public function setMinutesJouees(?int $minutesJouees): self
    {
        $this->minutesJouees = $minutesJouees;
        return $this;
    }

    public function getButs(): ?int
    {
        return $this->buts;
    }

    public function setButs(?int $buts): self
    {
        $this->buts = $buts;
        return $this;
    }

    public function getPassesDecisives(): ?int
    {
        return $this->passesDecisives;
    }

    public function setPassesDecisives(?int $passesDecisives): self
    {
        $this->passesDecisives = $passesDecisives;
        return $this;
    }

    public function getTirs(): ?int
    {
        return $this->tirs;
    }

    public function setTirs(?int $tirs): self
    {
        $this->tirs = $tirs;
        return $this;
    }

    public function getInterceptions(): ?int
    {
        return $this->interceptions;
    }

    public function setInterceptions(?int $interceptions): self
    {
        $this->interceptions = $interceptions;
        return $this;
    }

    public function getFautes(): ?int
    {
        return $this->fautes;
    }

    public function setFautes(?int $fautes): self
    {
        $this->fautes = $fautes;
        return $this;
    }

    public function getCartonsJaunes(): ?int
    {
        return $this->cartonsJaunes;
    }

    public function setCartonsJaunes(?int $cartonsJaunes): self
    {
        $this->cartonsJaunes = $cartonsJaunes;
        return $this;
    }

    public function getCartonsRouges(): ?int
    {
        return $this->cartonsRouges;
    }

    public function setCartonsRouges(?int $cartonsRouges): self
    {
        $this->cartonsRouges = $cartonsRouges;
        return $this;
    }

    public function getRebonds(): ?int
    {
        return $this->rebonds;
    }

    public function setRebonds(?int $rebonds): self
    {
        $this->rebonds = $rebonds;
        return $this;
    }
}