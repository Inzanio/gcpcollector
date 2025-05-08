<?php

namespace App\Models\Traits;

use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;

trait TemporalTrait
{
    protected FireStoreTimestamp $dateDebut;
    protected FireStoreTimestamp $dateDeFin;

    public function getDateDebut(): FireStoreTimestamp
    {
        return $this->dateDebut;
    }

    public function setDateDebut(FireStoreTimestamp $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): FireStoreTimestamp
    {
        return $this->dateDeFin;
    }

    public function setDateFin(FireStoreTimestamp $dateDeFin): self
    {
        $this->dateDeFin = $dateDeFin;
        return $this;
    }

    // public function isActif(FireStoreTimestamp $now): bool
    // {
    //     return $this->dateDebut->toDateTime() <= $now->toDateTime() && $this->dateFin->toDateTime() >= $now->toDateTime();
    // }

    // public function isFutur(FireStoreTimestamp $now): bool
    // {
    //     return $this->dateDebut->toDateTime() > $now->toDateTime();
    // }

    // public function isPasse(FireStoreTimestamp $now): bool
    // {
    //     return $this->dateFin->toDateTime() < $now->toDateTime();
    // }
}