<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "membres")]
    #[ORM\JoinColumn(name: "equipe_id", referencedColumnName: "id", onDelete: "SET NULL")]
    private ?Equipe $equipe = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide")]
    private string $nom;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le prénom ne peut pas être vide")]
    private string $prenom;

    #[ORM\Column(type: "string", columnDefinition: "ENUM('ADMIN', 'MANAGER', 'COACH', 'ATHLETE')")]
    private string $role = 'ATHLETE';

    #[ORM\Column(type: "string", length: 255, unique: true)]
    #[Assert\NotBlank(message: "L'email ne peut pas être vide")]
    #[Assert\Email(message: "L'email n'est pas valide")]
    private string $email;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le mot de passe ne peut pas être vide")]
    private string $hashedPassword;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "L'adresse ne peut pas être vide")]
    private string $adresse;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le téléphone ne peut pas être vide")]
    private string $telephone;

    #[ORM\Column(type: "string", columnDefinition: "ENUM('ACTIVE', 'INACTIVE')")]
    private string $status = 'ACTIVE';

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\OneToMany(mappedBy: "manager", targetEntity: Installationsportive::class)]
    private Collection $installationsGerees;

    #[ORM\OneToMany(mappedBy: "coach", targetEntity: Equipe::class)]
    private Collection $equipesCoachees;

    #[ORM\OneToMany(mappedBy: "athlete", targetEntity: Dossiermedical::class)]
    private Collection $dossiersMedicaux;

    #[ORM\OneToMany(mappedBy: "athlete", targetEntity: Blessure::class)]
    private Collection $blessures;

    #[ORM\OneToMany(mappedBy: "athlete", targetEntity: Performanceathlete::class)]
    private Collection $performancesAthlete;

    public function __construct()
    {
        $this->installationsGerees = new ArrayCollection();
        $this->equipesCoachees = new ArrayCollection();
        $this->dossiersMedicaux = new ArrayCollection();
        $this->blessures = new ArrayCollection();
        $this->performancesAthlete = new ArrayCollection();
    }

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

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        if (!in_array($role, ['ADMIN', 'MANAGER', 'COACH', 'ATHLETE'])) {
            throw new \InvalidArgumentException("Invalid role");
        }
        $this->role = $role;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function setHashedPassword(string $hashedPassword): self
    {
        $this->hashedPassword = $hashedPassword;
        return $this;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, ['ACTIVE', 'INACTIVE'])) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function getInstallationsGerees(): Collection
    {
        return $this->installationsGerees;
    }

    public function addInstallationGeree(Installationsportive $installation): self
    {
        if (!$this->installationsGerees->contains($installation)) {
            $this->installationsGerees[] = $installation;
            $installation->setManager($this);
        }
        return $this;
    }

    public function removeInstallationGeree(Installationsportive $installation): self
    {
        if ($this->installationsGerees->removeElement($installation)) {
            if ($installation->getManager() === $this) {
                $installation->setManager(null);
            }
        }
        return $this;
    }

    public function getEquipesCoachees(): Collection
    {
        return $this->equipesCoachees;
    }

    public function addEquipeCoachee(Equipe $equipe): self
    {
        if (!$this->equipesCoachees->contains($equipe)) {
            $this->equipesCoachees[] = $equipe;
            $equipe->setCoach($this);
        }
        return $this;
    }

    public function removeEquipeCoachee(Equipe $equipe): self
    {
        if ($this->equipesCoachees->removeElement($equipe)) {
            if ($equipe->getCoach() === $this) {
                $equipe->setCoach(null);
            }
        }
        return $this;
    }

    public function getDossiersMedicaux(): Collection
    {
        return $this->dossiersMedicaux;
    }

    public function addDossierMedical(Dossiermedical $dossier): self
    {
        if (!$this->dossiersMedicaux->contains($dossier)) {
            $this->dossiersMedicaux[] = $dossier;
            $dossier->setAthlete($this);
        }
        return $this;
    }

    public function removeDossierMedical(Dossiermedical $dossier): self
    {
        if ($this->dossiersMedicaux->removeElement($dossier)) {
            if ($dossier->getAthlete() === $this) {
                $dossier->setAthlete(null);
            }
        }
        return $this;
    }

    public function getBlessures(): Collection
    {
        return $this->blessures;
    }

    public function addBlessure(Blessure $blessure): self
    {
        if (!$this->blessures->contains($blessure)) {
            $this->blessures[] = $blessure;
            $blessure->setAthlete($this);
        }
        return $this;
    }

    public function removeBlessure(Blessure $blessure): self
    {
        if ($this->blessures->removeElement($blessure)) {
            if ($blessure->getAthlete() === $this) {
                $blessure->setAthlete(null);
            }
        }
        return $this;
    }

    public function getPerformancesAthlete(): Collection
    {
        return $this->performancesAthlete;
    }

    public function addPerformanceAthlete(Performanceathlete $performance): self
    {
        if (!$this->performancesAthlete->contains($performance)) {
            $this->performancesAthlete[] = $performance;
            $performance->setAthlete($this);
        }
        return $this;
    }

    public function removePerformanceAthlete(Performanceathlete $performance): self
    {
        if ($this->performancesAthlete->removeElement($performance)) {
            if ($performance->getAthlete() === $this) {
                $performance->setAthlete(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
}