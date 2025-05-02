<?php

namespace App\Models\Traits;

use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;

trait DbDataTrait
{
    /**
     * @var FireStoreTimestamp|null La date de création
     */
    protected ?FireStoreTimestamp $dateCreation = null;

    /**
     * @var FireStoreTimestamp|null La date de modification
     */
    protected ?FireStoreTimestamp $dateModification = null;



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
     * @return FireStoreTimestamp|null
     */
    public function getDateCreation(): ?FireStoreTimestamp
    {
        return $this->dateCreation;
    }

    /**
     * Définit la date de création
     * 
     * @param FireStoreTimestamp|null $dateCreation
     * @return void
     */
    public function setDateCreation(?FireStoreTimestamp $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * Obtient la date de modification
     * 
     * @return FireStoreTimestamp|null
     */
    public function getDateModification(): ?FireStoreTimestamp
    {
        return $this->dateModification;
    }

    /**
     * Définit la date de modification
     * 
     * @param FireStoreTimestamp|null $dateModification
     * @return void
     */
    public function setDateModification(?FireStoreTimestamp $dateModification): void
    {

        $this->dateModification = $dateModification;
    }
}
