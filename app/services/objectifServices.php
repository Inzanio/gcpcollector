<?php

namespace App\Services;

use App\Models\Objectif;

class ObjectifServices extends BaseServices
{
    /**
     * Nom de la collection Firestore pour les objectifs
     */
    private static $collectionName = "objectifs";

    /**
     * Crée une nouvelle objectif dans la base de données
     * @param Objectif $objectif - l'objet objectif à créer
     * @return mixed - le résultat de la création
     */
    public static function createObjectif(Objectif $objectif)
    {
        // Génération d'un ID unique pour le document
        $documentId = null;

        // Appel de la méthode de création de document dans la classe Database
        $result = Database::createDocument(self::$collectionName, $documentId, $objectif->toArray());
        return $result;
    }
    // /**
    //  * Crée une nouvelle objectif dans la base de données
    //  * @param Objectif[] $objectifs - le tableau d'objet objectif à créer
    //  * @return mixed - le résultat de la création
    //  */
    // public static function bulkCreateObjectif(array $objectifs)
    // {
    //     // Génération d'un ID unique pour le document
    //     $documentId = null;

    //     // Appel de la méthode de création de document dans la classe Database
    //     $result = Database::createDocument(self::$collectionName, $documentId, $objectif->toArray());
    //     return $result;
    // }

    /**
     * Met à jour une objectif existante
     * @param Objectif $objectif - l'objet objectif mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function updateobjectif(Objectif $objectif)
    {
        // Appel de la méthode de mise à jour de document dans la classe Database
        return Database::updateDocument(self::$collectionName, $objectif->getDocId(), $objectif->toArray());
    }

    // /**
    //  * Supprime une objectif à partir de son ID
    //  * @param string $documentId - l'ID de l'objectif
    //  * @return mixed - le résultat de la suppression
    //  */
    // public static function deleteobjectif($documentId)
    // {
    //     // Appel de la méthode de suppression de document dans la classe Database
    //     $result = Database::deleteDocument(self::$collectionName, $documentId);
    //     return $result;
    // }

    /**
     * Récupère toutes les objectifs
     * @return Objectif[] - le résultat de la requête
     */
    public static function getAllObjectifs($idAgent,$idAgence,$idCampagne)
    {
        // Appel de la méthode de récupération de tous les documents dans la classe
        $queryBuilder = Database::queryBuilder(self::$collectionName);

        if($idAgent !== null){
            $queryBuilder->where("idAgent","EQUAL",$idAgent);
        }
        if($idAgence !== null){
            $queryBuilder->where("idAgence","EQUAL",$idAgence);
        }
        if($idCampagne !== null){
            $queryBuilder->where("idCampagne","EQUAL",$idCampagne);
        }
        $query = $queryBuilder->build();
        $result = Database::query($query);
        
        $objectifs = array_map(function ($doc) {
            return self::fromFirestoreDocument($doc);
        }, $result);
        return $objectifs;
    }

    /**
     * Récupère une objectif par son ID
     * @param string $documentId - l'ID de l'objectif
     * @return Objectif - le résultat de la requête
     */
    public static function getObjectifById($documentId) : Objectif
    {
        // Appel de la méthode de récupération d'un document par ID dans la classe Database
        $result = Database::getDocument(self::$collectionName, $documentId);
        return self::fromFirestoreDocument($result);
    }

    /**
     * Transforme un document Firestore en un objet Utilisateur
     * @param \MrShan0\PHPFirestore\FireStoreDocument $doc - le document Firestore à transformer
     * @return Objectif
     */
    public static function fromFirestoreDocument($doc) : Objectif
    {
        //var_dump($doc);
        $data = $doc->toArray();
        $id = Database::getDocumentIdFromName($doc->getName());
        $objectif = (new Objectif())->fromArray($data);
        $objectif->setDocId($id);
        
        return $objectif;
    }
}
