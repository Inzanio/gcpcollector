<?php

namespace App\Models;

use App\Models\Traits\CreatableByUserTrait;
use App\Models\Traits\DbDataTrait;
use App\Models\Traits\TemporalTrait;
use App\Models\Traits\ToArrayTrait;


class Objectif
{
    use DbDataTrait;
    use ToArrayTrait;
    use TemporalTrait;
    use CreatableByUserTrait;
    /**
     * Liste des champs de l'objectif
     */
    private string $libelle;
    private string $cible; // clients, prospect, taux de conversion
    private bool $atteint;
    private int $valeur;

    // réfrence
    private ?string $idAgent;
    private ?string $idAgence;
    private ?string $idCampagne;

    public function __construct(string $docId, $idCampagne = null ,$idAgent=null, $idAgence = null)
    {
        $this->setDocId($docId);
        $this->setIdCampagne($idCampagne);
        $this->setIdAgent($idAgent);
        $this->setIdAgence($idAgence);
    }
    public function getIdCampagne(): ?string
    {
        return $this->idCampagne;
    }

    public function setIdCampagne(?string $idCampagne): self
    {
        $this->idCampagne = $idCampagne;
        return $this;
    }

    public function getIdAgent(): ?string
    {
        return $this->idAgent;
    }

    public function setIdAgent(?string $idAgent): self
    {
        $this->idAgent = $idAgent;
        return $this;
    }

    public function getIdAgence(): ?string
    {
        return $this->idAgence;
    }

    public function setIdAgence(?string $idAgence): self
    {
        $this->idAgence = $idAgence;
        return $this;
    }


    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getCible(): string
    {
        return $this->cible;
    }

    public function setCible(string $cible): self
    {
        $this->cible = $cible;
        return $this;
    }

    public function estAtteint(): bool
    {
        return $this->atteint;
    }

    public function setAtteint(bool $atteint): self
    {
        $this->atteint = $atteint;
        return $this;
    }

    public function getValeur(): int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;
        return $this;
    }
}
