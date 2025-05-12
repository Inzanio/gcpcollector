<?php

namespace App\Models;

use App\Models\Traits\CreatableByUserTrait;
use App\Models\Traits\DbDataTrait;
use App\Models\Traits\ToArrayTrait;

class ProduitBanque {
    use DbDataTrait;
    use ToArrayTrait;
    use CreatableByUserTrait;

    private string $nom;
    public function __construct(string $nom = "") {
        $this->nom = $nom;
    }
    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

}