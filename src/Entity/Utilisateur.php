<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Equipe;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Utilisateur
{

    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    private int $id;

        #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "utilisateurs")]
    #[ORM\JoinColumn(name: 'equipe_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Equipe $equipe_id;

    #[ORM\Column(type: "string", length: 255)]
    private string $nom;

    #[ORM\Column(type: "string", length: 255)]
    private string $prenom;

    #[ORM\Column(type: "string")]
    private string $role;

    #[ORM\Column(type: "string", length: 255)]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    private string $hashedPassword;

    #[ORM\Column(type: "string", length: 255)]
    private string $adresse;

    #[ORM\Column(type: "string", length: 255)]
    private string $telephone;

    #[ORM\Column(type: "string")]
    private string $status;

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

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($value)
    {
        $this->prenom = $value;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($value)
    {
        $this->role = $value;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function getHashedPassword()
    {
        return $this->hashedPassword;
    }

    public function setHashedPassword($value)
    {
        $this->hashedPassword = $value;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($value)
    {
        $this->adresse = $value;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($value)
    {
        $this->telephone = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function getImage_url()
    {
        return $this->image_url;
    }

    public function setImage_url($value)
    {
        $this->image_url = $value;
    }

    #[ORM\OneToMany(mappedBy: "manager_id", targetEntity: Installationsportive::class)]
    private Collection $installationsportives;

    #[ORM\OneToMany(mappedBy: "coach_id", targetEntity: Equipe::class)]
    private Collection $equipes;

    #[ORM\OneToMany(mappedBy: "athlete_id", targetEntity: Dossiermedical::class)]
    private Collection $dossiermedicals;

        public function getDossiermedicals(): Collection
        {
            return $this->dossiermedicals;
        }
    
        public function addDossiermedical(Dossiermedical $dossiermedical): self
        {
            if (!$this->dossiermedicals->contains($dossiermedical)) {
                $this->dossiermedicals[] = $dossiermedical;
                $dossiermedical->setAthlete_id($this);
            }
    
            return $this;
        }
    
        public function removeDossiermedical(Dossiermedical $dossiermedical): self
        {
            if ($this->dossiermedicals->removeElement($dossiermedical)) {
                // set the owning side to null (unless already changed)
                if ($dossiermedical->getAthlete_id() === $this) {
                    $dossiermedical->setAthlete_id(null);
                }
            }
    
            return $this;
        }

    #[ORM\OneToMany(mappedBy: "athlete_id", targetEntity: Blessure::class)]
    private Collection $blessures;

    #[ORM\OneToMany(mappedBy: "athlete_id", targetEntity: Performanceathlete::class)]
    private Collection $performanceathletes;
}
