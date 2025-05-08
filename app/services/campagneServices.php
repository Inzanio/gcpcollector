<?php

namespace App\Services;

use App\Models\Campagne;
use App\Models\Objectif;

class CampagneServices
{
    /**
     * Nom de la collection Firestore pour les campagnes
     */
    private static $collectionName = "campagnes";

    /**
     * Crée une nouvelle campagne dans la base de données
     * @param Campagne $campagne - l'objet campagne à créer
     * @return mixed - le résultat de la création
     */
    public static function createCampagne(Campagne $campagne)
    {
        // Génération d'un ID unique pour le document
        $documentId = null;
        
        // Appel de la méthode de création de document dans la classe Database
        $result = Database::createDocument(self::$collectionName, $documentId, $campagne->toArray());
        return $result;
    }
    // /**
    //  * Crée une nouvelle campagne dans la base de données
    //  * @param Campagne[] $campagnes - le tableau d'objet campagne à créer
    //  * @return mixed - le résultat de la création
    //  */
    // public static function bulkCreateCampagne(array $campagnes)
    // {
    //     // Génération d'un ID unique pour le document
    //     $documentId = null;

    //     // Appel de la méthode de création de document dans la classe Database
    //     $result = Database::createDocument(self::$collectionName, $documentId, $campagne->toArray());
    //     return $result;
    // }

    /**
     * Met à jour une campagne existante
     * @param Campagne $campagne - l'objet campagne mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function updateCampagne(Campagne $campagne)
    {
        // Appel de la méthode de mise à jour de document dans la classe Database
        return Database::updateDocument(self::$collectionName, $campagne->getDocId(), $campagne->toArray());
    }

    // /**
    //  * Supprime une campagne à partir de son ID
    //  * @param string $documentId - l'ID de l'campagne
    //  * @return mixed - le résultat de la suppression
    //  */
    // public static function deletecampagne($documentId)
    // {
    //     // Appel de la méthode de suppression de document dans la classe Database
    //     $result = Database::deleteDocument(self::$collectionName, $documentId);
    //     return $result;
    // }

    /**
     * Récupère toutes les campagnes
     * @return Campagne[] - le résultat de la requête
     */
    public static function getAllCampagnes($idAgence=null)
    {
        // Appel de la méthode de récupération de tous les documents dans la classe
        $queryBuilder = Database::queryBuilder(self::$collectionName);
        // if($idAgence !== null){
        //     $queryBuilder->where("idAgence","EQUAL",$idAgence);
        // }
        $query = $queryBuilder->build();
        $result = Database::query($query);
        
        $campagnes = array_map(function ($doc) {
            return self::fromFirestoreDocument($doc);
        }, $result);
        return $campagnes;
    }

    /**
     * Récupère une campagne par son ID
     * @param string $documentId - l'ID de l'campagne
     * @return Campagne - le résultat de la requête
     */
    public static function getCampagneById($documentId) : Campagne
    {
        // Appel de la méthode de récupération d'un document par ID dans la classe Database
        $result = Database::getDocument(self::$collectionName, $documentId);
        return self::fromFirestoreDocument($result);
    }

    /**
     * Transforme un document Firestore en un objet Utilisateur
     * @param \MrShan0\PHPFirestore\FireStoreDocument $doc - le document Firestore à transformer
     * @return Campagne
     */
    public static function fromFirestoreDocument($doc) : Campagne
    {
        //var_dump($doc);
        $data = $doc->toArray();
        $id = Database::getDocumentIdFromName($doc->getName());
        $campagne = (new Campagne())->fromArray($data);
        $campagne->setDocId($id);
        return $campagne;
    }
}
