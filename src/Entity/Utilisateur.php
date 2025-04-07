<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: "App\Repository\UtilisateurRepository")]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: "membres")]
    #[ORM\JoinColumn(name: "equipe_id", referencedColumnName: "id", onDelete: "SET NULL")]
    private ?Equipe $equipe = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    private string $nom;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    private string $prenom;

    #[ORM\Column(type: "string", length: 20, columnDefinition: "ENUM('ADMIN', 'MANAGER', 'COACH', 'ATHLETE')")]
    private string $role = 'ATHLETE';

    #[ORM\Column(type: "string", length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(name: "hashed_password", type: "string")]
    private string $password;
    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    private string $adresse;

    #[ORM\Column(type: "string", length: 20)]
    #[Assert\NotBlank]
    private string $telephone;

    #[ORM\Column(type: "string", length: 10, columnDefinition: "ENUM('ACTIVE', 'INACTIVE')")]
    private string $status = 'ACTIVE'; // NOT 'ACTIVE' (with extra E)
    #[ORM\Column(name: "image_url", type: "string", length: 255, nullable: true)]
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

    /* Security Interface Methods */
    public function getRoles(): array { return [$this->role]; }
    public function getPassword(): string { return $this->password; }
    public function getSalt(): ?string { return null; }
    public function eraseCredentials() {}
    public function getUsername(): string { return $this->email; }
    public function getUserIdentifier(): string { return $this->email; }

    /* Getters/Setters */
    public function getId(): ?int { return $this->id; }
    public function getEquipe(): ?Equipe { return $this->equipe; }
    public function setEquipe(?Equipe $equipe): self { $this->equipe = $equipe; return $this; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }
    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $prenom): self { $this->prenom = $prenom; return $this; }
    public function getRole(): string { return $this->role; }
    public function setRole(string $role): self {
        if (!in_array($role, ['ADMIN', 'MANAGER', 'COACH', 'ATHLETE'])) {
            throw new \InvalidArgumentException("Invalid role");
        }
        $this->role = $role;
        return $this;
    }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }
    public function getHashedPassword(): string { return $this->password; }
    public function setHashedPassword(string $password): self { $this->password = $password; return $this; }
    public function getAdresse(): string { return $this->adresse; }
    public function setAdresse(string $adresse): self { $this->adresse = $adresse; return $this; }
    public function getTelephone(): string { return $this->telephone; }
    public function setTelephone(string $telephone): self { $this->telephone = $telephone; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self {
        if (!in_array($status, ['ACTIVE', 'INACTIVE'])) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
        return $this;
    }
    public function getImageUrl(): ?string { return $this->imageUrl; }
    public function setImageUrl(?string $imageUrl): self { $this->imageUrl = $imageUrl; return $this; }

    /* Collection Methods */
    public function getInstallationsGerees(): Collection { return $this->installationsGerees; }
    public function getEquipesCoachees(): Collection { return $this->equipesCoachees; }
    public function getDossiersMedicaux(): Collection { return $this->dossiersMedicaux; }
    public function getBlessures(): Collection { return $this->blessures; }
    public function getPerformancesAthlete(): Collection { return $this->performancesAthlete; }

    public function __toString(): string { return $this->prenom . ' ' . $this->nom; }
}