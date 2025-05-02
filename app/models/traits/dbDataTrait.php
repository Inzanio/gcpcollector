<?php

namespace App\Models\Traits;

use DateTimeImmutable;

trait DbDataTrait
{
    /**
     * @var DateTimeImmutable|null La date de création
     */
    protected ?DateTimeImmutable $dateCreation = null;

    /**
     * @var DateTimeImmutable|null La date de modification
     */
    protected ?DateTimeImmutable $dateModification = null;


    /**
     * id prospect
     */
    private string $docId;

    /**
     * Récupère l'ID du prospect
     * @return string
     */
    public function getDocId(): string
    {
        return $this->docId;
    }

    /**
     * Modifie l'ID du prospect
     * @param string $id Nouvel ID du prospect
     */
    public function setDocId(string $getDocId): void
    {
        $this->docId = $getDocId;
    }
    /**
     * Obtient la date de création
     * 
     * @return DateTimeImmutable|null
     */
    public function getDateCreation(): ?DateTimeImmutable
    {
        return $this->dateCreation;
    }

    /**
     * Définit la date de création
     * 
     * @param string|null $dateCreation
     * @return void
     */
    public function setDateCreation(?string $dateCreation): void
    {
        if ($dateCreation !== null) {
            $this->dateCreation = new DateTimeImmutable($dateCreation);
        } else {
            $this->dateCreation = null;
        }
    }

    /**
     * Obtient la date de modification
     * 
     * @return DateTimeImmutable|null
     */
    public function getDateModification(): ?DateTimeImmutable
    {
        return $this->dateModification;
    }

    /**
     * Définit la date de modification
     * 
     * @param string|null $dateModification
     * @return void
     */
    public function setDateModification(?string $dateModification): void
    {
        if ($dateModification !== null) {
            $this->dateModification = new DateTimeImmutable($dateModification);
        } else {
            $this->dateModification = null;
        }
    }
}
