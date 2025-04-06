<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Performanceequipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "performances")]
    #[ORM\JoinColumn(name: "equipe_id", referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\NotNull(message: "L'équipe est obligatoire")]
    private ?Equipe $equipe = null;

    #[ORM\ManyToOne(targetEntity: Tournois::class, inversedBy: "performancesEquipes")]
    #[ORM\JoinColumn(name: "tournois_id", referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\NotNull(message: "Le tournois est obligatoire")]
    private ?Tournois $tournois = null;

    #[ORM\Column(type: "integer")]
    #[Assert\NotNull(message: "Le nombre de victoires est obligatoire")]
    #[Assert\GreaterThanOrEqual(0, message: "Le nombre de victoires ne peut pas être négatif")]
    private int $victoires = 0;

    #[ORM\Column(type: "integer")]
    #[Assert\NotNull(message: "Le nombre de pertes est obligatoire")]
    #[Assert\GreaterThanOrEqual(0, message: "Le nombre de pertes ne peut pas être négatif")]
    private int $pertes = 0;

    #[ORM\Column(type: "integer")]
    #[Assert\NotNull(message: "Le rang est obligatoire")]
    #[Assert\Positive(message: "Le rang doit être un nombre positif")]
    private int $rang = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        $this->equipe = $equipe;
        return $this;
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

    public function getVictoires(): int
    {
        return $this->victoires;
    }

    public function setVictoires(int $victoires): self
    {
        $this->victoires = $victoires;
        return $this;
    }

    public function getPertes(): int
    {
        return $this->pertes;
    }

    public function setPertes(int $pertes): self
    {
        $this->pertes = $pertes;
        return $this;
    }

    public function getRang(): int
    {
        return $this->rang;
    }

    public function setRang(int $rang): self
    {
        $this->rang = $rang;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf('Performance de %s au tournoi %s',
            $this->equipe ? $this->equipe->getNom() : '?',
            $this->tournois ? $this->tournois->getNom() : '?'
        );
    }
}