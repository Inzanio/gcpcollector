<?php

namespace App\Services;

use App\Models\Agence;

class AgenceServices extends BaseServices
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
     * @return Agence[] - le résultat de la requête
     */
    public static function getAllAgences()
    {
        // Appel de la méthode de récupération de tous les documents dans la classe
        $queryBuilder = Database::queryBuilder(self::$collectionName);

        $query = $queryBuilder->build();
        $result = Database::query($query);
        
        $agences = array_map(function ($doc) {
            return self::fromFirestoreDocument($doc);
        }, $result);
        return $agences;
    }

    /**
     * Récupère une agence par son ID
     * @param string $documentId - l'ID de l'agence
     * @return Agence - le résultat de la requête
     */
    public static function getAgenceById($documentId) : Agence
    {
        // Appel de la méthode de récupération d'un document par ID dans la classe Database
        $result = Database::getDocument(self::$collectionName, $documentId);
        return self::fromFirestoreDocument($result);
    }

    /**
     * Transforme un document Firestore en un objet Utilisateur
     * @param \MrShan0\PHPFirestore\FireStoreDocument $doc - le document Firestore à transformer
     * @return Agence
     */
    public static function fromFirestoreDocument($doc) : Agence
    {
        //var_dump($doc);
        $data = $doc->toArray();
        $id = Database::getDocumentIdFromName($doc->getName());
        $agence = new Agence(
            $data['code'] ?? "",
            $data['nom'] ?? "",
            $data['lieu'] ?? "",
            $data['idAdmin'] ?? "",

        );
        $agence->setCode($id);
        $agence->setDocId($id);
        return $agence;
    }
}
