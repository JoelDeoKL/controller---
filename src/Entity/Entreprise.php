<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_entreprise = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_entreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_entreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone_entreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $etat_entreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $secteur_entreprise = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_validation = null;

    #[ORM\Column(length: 255)]
    private ?string $email_entreprise = null;

    #[ORM\Column]
    private ?int $nombre_place = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Cote::class)]
    private Collection $cote;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Validation::class)]
    private Collection $validations;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Demande::class)]
    private Collection $demandes;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Departement::class)]
    private Collection $departements;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    public function __construct()
    {
        $this->cote = new ArrayCollection();
        $this->validations = new ArrayCollection();
        $this->demandes = new ArrayCollection();
        $this->departements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): static
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }

    public function getDescriptionEntreprise(): ?string
    {
        return $this->description_entreprise;
    }

    public function setDescriptionEntreprise(string $description_entreprise): static
    {
        $this->description_entreprise = $description_entreprise;

        return $this;
    }

    public function getAdresseEntreprise(): ?string
    {
        return $this->adresse_entreprise;
    }

    public function setAdresseEntreprise(string $adresse_entreprise): static
    {
        $this->adresse_entreprise = $adresse_entreprise;

        return $this;
    }

    public function getTelephoneEntreprise(): ?string
    {
        return $this->telephone_entreprise;
    }

    public function setTelephoneEntreprise(string $telephone_entreprise): static
    {
        $this->telephone_entreprise = $telephone_entreprise;

        return $this;
    }

    public function getEtatEntreprise(): ?string
    {
        return $this->etat_entreprise;
    }

    public function setEtatEntreprise(string $etat_entreprise): static
    {
        $this->etat_entreprise = $etat_entreprise;

        return $this;
    }

    public function getSecteurEntreprise(): ?string
    {
        return $this->secteur_entreprise;
    }

    public function setSecteurEntreprise(string $secteur_entreprise): static
    {
        $this->secteur_entreprise = $secteur_entreprise;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->date_validation;
    }

    public function setDateValidation(\DateTimeInterface $date_validation): static
    {
        $this->date_validation = $date_validation;

        return $this;
    }

    public function getEmailEntreprise(): ?string
    {
        return $this->email_entreprise;
    }

    public function setEmailEntreprise(string $email_entreprise): static
    {
        $this->email_entreprise = $email_entreprise;

        return $this;
    }

    public function getNombrePlace(): ?int
    {
        return $this->nombre_place;
    }

    public function setNombrePlace(int $nombre_place): static
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

    public function addCote(Cote $cote): static
    {
        if (!$this->cote->contains($cote)) {
            $this->cote->add($cote);
            $cote->setEntreprise($this);
        }

        return $this;
    }

    public function removeCote(Cote $cote): static
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

    public function addValidation(Validation $validation): static
    {
        if (!$this->validations->contains($validation)) {
            $this->validations->add($validation);
            $validation->setEntreprise($this);
        }

        return $this;
    }

    public function removeValidation(Validation $validation): static
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

    public function addDemande(Demande $demande): static
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setEntreprise($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): static
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

    public function addDepartement(Departement $departement): static
    {
        if (!$this->departements->contains($departement)) {
            $this->departements->add($departement);
            $departement->setEntreprise($this);
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): static
    {
        if ($this->departements->removeElement($departement)) {
            // set the owning side to null (unless already changed)
            if ($departement->getEntreprise() === $this) {
                $departement->setEntreprise(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom_entreprise;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }
}
