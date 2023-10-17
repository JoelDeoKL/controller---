<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Entreprise implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_entreprise = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_entreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_entreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone_entreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat_entreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $secteur_entreprise = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date_creation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date_validation = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre_place = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Cote::class)]
    private Collection $cote;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Validation::class)]
    private Collection $validations;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Demande::class)]
    private Collection $demandes;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Departement::class)]
    private Collection $departements;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    private ?string $rccm = null;

    #[ORM\Column(length: 255)]
    private ?string $idnat = null;

    public function __construct()
    {
        $this->cote = new ArrayCollection();
        $this->validations = new ArrayCollection();
        $this->demandes = new ArrayCollection();
        $this->departements = new ArrayCollection();
    }

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    #[ORM\Column]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): self
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }

    public function getDescriptionEntreprise(): ?string
    {
        return $this->description_entreprise;
    }

    public function setDescriptionEntreprise(string $description_entreprise): self
    {
        $this->description_entreprise = $description_entreprise;

        return $this;
    }

    public function getAdresseEntreprise(): ?string
    {
        return $this->adresse_entreprise;
    }

    public function setAdresseEntreprise(string $adresse_entreprise): self
    {
        $this->adresse_entreprise = $adresse_entreprise;

        return $this;
    }

    public function getTelephoneEntreprise(): ?string
    {
        return $this->telephone_entreprise;
    }

    public function setTelephoneEntreprise(string $telephone_entreprise): self
    {
        $this->telephone_entreprise = $telephone_entreprise;

        return $this;
    }

    public function getEtatEntreprise(): ?string
    {
        return $this->etat_entreprise;
    }

    public function setEtatEntreprise(string $etat_entreprise): self
    {
        $this->etat_entreprise = $etat_entreprise;

        return $this;
    }

    public function getSecteurEntreprise(): ?string
    {
        return $this->secteur_entreprise;
    }

    public function setSecteurEntreprise(string $secteur_entreprise): self
    {
        $this->secteur_entreprise = $secteur_entreprise;

        return $this;
    }

    public function getDateValidation(): ?string
    {
        return $this->date_validation;
    }

    public function setDateValidation(string $secteur_entreprise): self
    {
        $this->secteur_entreprise = $secteur_entreprise;

        return $this;
    }

    public function getSetCreation(): ?string
    {
        return $this->date_creation;
    }

    public function setSetCreation(string $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getNombrePlace(): ?int
    {
        return $this->nombre_place;
    }

    public function setNombrePlace(int $nombre_place): self
    {
        $this->nombre_place = $nombre_place;

        return $this;
    }

    /**
     * @return Collection<int, Cote>
     */
    public function getCote(): Collection
    {
        return $this->cote;
    }

    public function addCote(Cote $cote): self
    {
        if (!$this->cote->contains($cote)) {
            $this->cote->add($cote);
            $cote->setEntreprise($this);
        }

        return $this;
    }

    public function removeCote(Cote $cote): self
    {
        if ($this->cote->removeElement($cote)) {
            // set the owning side to null (unless already changed)
            if ($cote->getEntreprise() === $this) {
                $cote->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Validation>
     */
    public function getValidations(): Collection
    {
        return $this->validations;
    }

    public function addValidation(Validation $validation): self
    {
        if (!$this->validations->contains($validation)) {
            $this->validations->add($validation);
            $validation->setEntreprise($this);
        }

        return $this;
    }

    public function removeValidation(Validation $validation): self
    {
        if ($this->validations->removeElement($validation)) {
            // set the owning side to null (unless already changed)
            if ($validation->getEntreprise() === $this) {
                $validation->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setEntreprise($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getEntreprise() === $this) {
                $demande->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Departement>
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departement $departement): self
    {
        if (!$this->departements->contains($departement)) {
            $this->departements->add($departement);
            $departement->setEntreprise($this);
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): self
    {
        if ($this->departements->removeElement($departement)) {
            // set the owning side to null (unless already changed)
            if ($departement->getEntreprise() === $this) {
                $departement->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getRccm(): ?string
    {
        return $this->rccm;
    }

    public function setRccm(string $rccm): self
    {
        $this->rccm = $rccm;

        return $this;
    }

    public function getIdnat(): ?string
    {
        return $this->idnat;
    }

    public function setIdnat(string $idnat): self
    {
        $this->idnat = $idnat;

        return $this;
    }

    public function __toString()
    {
        return $this->nom_entreprise;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
