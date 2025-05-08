<?php

namespace App\Models;

use App\Models\Traits\CreatableByUserTrait;
use App\Models\Traits\DbDataTrait;
use App\Models\Traits\TemporalTrait;
use App\Models\Traits\ToArrayTrait;


class Campagne
{
    use DbDataTrait;
    use ToArrayTrait;
    use TemporalTrait;
    use CreatableByUserTrait;
    /**
     * Liste des champs de la campagne
     */
    private string $libelle;
    private string $lieu;
    private ?string $idAgence;


    public function __construct($idAgence=null)
    {
        $this->setIdAgence($idAgence);
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

    public function getLieu(): string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;
        return $this;
    }
}
