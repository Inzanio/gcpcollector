<?php

namespace App\Models;

use App\Models\Traits\CreatableByUserTrait;
use App\Models\Traits\DbDataTrait;
use App\Models\Traits\ToArrayTrait;

class ProduitBanqueChoisi {
    use DbDataTrait;
    use ToArrayTrait;
    use CreatableByUserTrait;

    private string $idProspect;
    private string $idProduitBanque;

    public function __construct(string $idProspect = "", string $idProduitBanque ="", $idCreator = "")
    {
        $this->idProspect = $idProspect;
        $this->idProduitBanque = $idProduitBanque;
        $this->idCreator = $idCreator;
    }

    /**
     * Get the value of idProspect
     */
    public function getIdProspect(): string
    {
        return $this->idProspect;
    }

    /**
     * Set the value of idProspect
     */
    public function setIdProspect(string $idProspect): void
    {
        $this->idProspect = $idProspect;
    }

    /**
     * Get the value of idProduitBanque
     */
    public function getIdProduitBanque(): string
    {
        return $this->idProduitBanque;
    }

    /**
     * Set the value of idProduitBanque
     */
    public function setIdProduitBanque(string $idProduitBanque): void
    {
        $this->idProduitBanque = $idProduitBanque;
    }
   

}