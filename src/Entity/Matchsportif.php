<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Equipe;
use Doctrine\Common\Collections\Collection;
use App\Entity\Performanceathlete;

#[ORM\Entity]
class Matchsportif
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Tournois::class, inversedBy: "matchsportifs")]
    #[ORM\JoinColumn(name: 'tournois_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Tournois $tournois_id;

        #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "matchsportifs")]
    #[ORM\JoinColumn(name: 'equipe1_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Equipe $equipe1_id;

        #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "matchsportifs")]
    #[ORM\JoinColumn(name: 'equipe2_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Equipe $equipe2_id;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $date;

    #[ORM\Column(type: "string", length: 255)]
    private string $lieu;

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getTournois_id()
    {
        return $this->tournois_id;
    }

    public function setTournois_id($value)
    {
        $this->tournois_id = $value;
    }

    public function getEquipe1_id()
    {
        return $this->equipe1_id;
    }

    public function setEquipe1_id($value)
    {
        $this->equipe1_id = $value;
    }

    public function getEquipe2_id()
    {
        return $this->equipe2_id;
    }

    public function setEquipe2_id($value)
    {
        $this->equipe2_id = $value;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($value)
    {
        $this->date = $value;
    }

    public function getLieu()
    {
        return $this->lieu;
    }

    public function setLieu($value)
    {
        $this->lieu = $value;
    }

    #[ORM\OneToMany(mappedBy: "match_id", targetEntity: Performanceathlete::class)]
    private Collection $performanceathletes;
}
