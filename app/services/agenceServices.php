<?php

namespace App\Services;

use App\Models\Agence;

class AgenceService
{
    /**
     * Nom de la collection Firestore pour les agences
     */
    private static $collectionName = "agences";

    /**
     * Crée une nouvelle agence dans la base de données
     * @param Agence $agence - l'objet Agence à créer
     * @return mixed - le résultat de la création
     */
    public static function createAgence(Agence $agence)
    {
        // Génération d'un ID unique pour le document
        $documentId = $agence->getCode();

        // Appel de la méthode de création de document dans la classe Database
        $result = Database::createDocument(self::$collectionName, $documentId, $agence->toArray());
        return $result;
    }

    /**
     * Met à jour une agence existante
     * @param Agence $agence - l'objet Agence mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function updateAgence(Agence $agence)
    {
        // Appel de la méthode de mise à jour de document dans la classe Database
        return Database::updateDocument(self::$collectionName, $agence->getDocId(), $agence->toArray());
    }

    // /**
    //  * Supprime une agence à partir de son ID
    //  * @param string $documentId - l'ID de l'agence
    //  * @return mixed - le résultat de la suppression
    //  */
    // public static function deleteAgence($documentId)
    // {
    //     // Appel de la méthode de suppression de document dans la classe Database
    //     $result = Database::deleteDocument(self::$collectionName, $documentId);
    //     return $result;
    // }

    /**
     * Récupère toutes les agences
     * @return mixed - le résultat de la requête
     */
    public static function getAllAgences()
    {
        // Appel de la méthode de récupération de tous les documents dans la classe
        $queryBuilder = Database::queryBuilder(self::$collectionName);

        $query = $queryBuilder->build();
        $result = Database::query($query);
        return $result;
    }

    /**
     * Récupère une agence par son ID
     * @param string $documentId - l'ID de l'agence
     * @return mixed - le résultat de la requête
     */
    public static function getAgenceById($documentId)
    {
        // Appel de la méthode de récupération d'un document par ID dans la classe Database
        $result = Database::getDocument(self::$collectionName, $documentId);
        return $result;
    }
}
