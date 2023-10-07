<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_departement = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_departement = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column]
    private ?int $nombre_heure = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\ManyToOne(inversedBy: 'departements')]
    private ?Entreprise $entreprise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDepartement(): ?string
    {
        return $this->nom_departement;
    }

    public function setNomDepartement(string $nom_departement): static
    {
        $this->nom_departement = $nom_departement;

        return $this;
    }

    public function getDescriptionDepartement(): ?string
    {
        return $this->description_departement;
    }

    public function setDescriptionDepartement(string $description_departement): static
    {
        $this->description_departement = $description_departement;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }

    public function getNombreHeure(): ?int
    {
        return $this->nombre_heure;
    }

    public function setNombreHeure(int $nombre_heure): static
    {
        $this->nombre_heure = $nombre_heure;

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

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }
}
