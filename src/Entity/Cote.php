<?php

namespace App\Entity;

use App\Repository\CoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoteRepository::class)]
class Cote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cote')]
    private ?Entreprise $entreprise = null;

    #[ORM\Column]
    private ?float $cote = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_etudiant = null;

    #[ORM\Column(length: 255)]
    private ?string $postnom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $promotion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_cotation = null;

    #[ORM\Column(length: 255)]
    private ?string $provenance = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCote(): ?float
    {
        return $this->cote;
    }

    public function setCote(float $cote): static
    {
        $this->cote = $cote;

        return $this;
    }

    public function getNomEtudiant(): ?string
    {
        return $this->nom_etudiant;
    }

    public function setNomEtudiant(string $nom_etudiant): static
    {
        $this->nom_etudiant = $nom_etudiant;

        return $this;
    }

    public function getPostnom(): ?string
    {
        return $this->postnom;
    }

    public function setPostnom(string $postnom): static
    {
        $this->postnom = $postnom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(string $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getDateCotation(): ?\DateTimeInterface
    {
        return $this->date_cotation;
    }

    public function setDateCotation(\DateTimeInterface $date_cotation): static
    {
        $this->date_cotation = $date_cotation;

        return $this;
    }

    public function getProvenance(): ?string
    {
        return $this->provenance;
    }

    public function setProvenance(string $provenance): static
    {
        $this->provenance = $provenance;

        return $this;
    }
}
