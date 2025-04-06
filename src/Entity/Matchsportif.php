<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class Matchsportif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tournois::class, inversedBy: "matchs")]
    #[ORM\JoinColumn(name: "tournois_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Tournois $tournois = null;

    // In Matchsportif.php
    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "matchsAsTeam1")]
    private ?Equipe $equipe1 = null;

    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "matchsAsTeam2")]
    private ?Equipe $equipe2 = null;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $date;

    #[ORM\Column(type: "string", length: 255)]
    private string $lieu;

    #[ORM\OneToMany(mappedBy: "match", targetEntity: Performanceathlete::class)]
    private Collection $performances;

    public function __construct()
    {
        $this->performances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTournois(): ?Tournois
    {
        return $this->tournois;
    }

    public function setTournois(?Tournois $tournois): self
    {
        $this->tournois = $tournois;
        return $this;
    }

    public function getEquipe1(): ?Equipe
    {
        return $this->equipe1;
    }

    public function setEquipe1(?Equipe $equipe1): self
    {
        $this->equipe1 = $equipe1;
        return $this;
    }

    public function getEquipe2(): ?Equipe
    {
        return $this->equipe2;
    }

    public function setEquipe2(?Equipe $equipe2): self
    {
        $this->equipe2 = $equipe2;
        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getLieu(): string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;
        return $this;
    }

    /**
     * @return Collection|Performanceathlete[]
     */
    public function getPerformances(): Collection
    {
        return $this->performances;
    }

    public function addPerformance(Performanceathlete $performance): self
    {
        if (!$this->performances->contains($performance)) {
            $this->performances[] = $performance;
            $performance->setMatch($this);
        }
        return $this;
    }

    public function removePerformance(Performanceathlete $performance): self
    {
        if ($this->performances->removeElement($performance)) {
            if ($performance->getMatch() === $this) {
                $performance->setMatch(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return sprintf(
            'Match %s vs %s - %s',
            $this->equipe1 ? $this->equipe1->getNom() : '?',
            $this->equipe2 ? $this->equipe2->getNom() : '?',
            $this->date->format('Y-m-d H:i')
        );
    }
}