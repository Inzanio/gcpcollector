<?php

namespace App\Services;

use App\Models\ProduitBanque;

class ProduitBanqueServices extends BaseServices
{

    private static $collectionName = "produitsBanque";
    /**
     * Transforme un document Firestore en un objet Utilisateur
     * @param \MrShan0\PHPFirestore\FireStoreDocument $doc - le document Firestore à transformer
     * @return ProduitBanque
     */
    public static function fromFirestoreDocument($doc)
    {
        //var_dump($doc);
        $data = $doc->toArray();
        $id = Database::getDocumentIdFromName($doc->getName());
        $produit = (new ProduitBanque())->fromArray($data);
        $produit->setDocId($id);
        return $produit;
    }

    /**
     * Crée un nouveau produit dans la base de données
     * @param ProduitBanque $produit - l'objet Agence à créer
     * @return mixed - le résultat de la création
     */
    public static function create(ProduitBanque $produit)
    {
        // Génération d'un ID unique pour le document
        $documentId = null;

        // Appel de la méthode de création de document dans la classe Database
        $result = Database::createDocument(self::$collectionName, $documentId, $produit->toArray());
        return $result;
    }
    /**
     * Récupère toutes les object
     *  
     */
    public static function getAll()
    {
        // Appel de la méthode de récupération de tous les documents dans la classe
        $queryBuilder = Database::queryBuilder(self::$collectionName);

        $query = $queryBuilder->build();
        $result = Database::query($query);

        $objects = array_map(function ($doc) {
            return self::fromFirestoreDocument($doc);
        }, $result);
        return $objects;
    }
}
