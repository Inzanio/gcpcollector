<?php

namespace App\Services;

use App\Models\ProduitBanqueChoisi;

class ProduitBanqueChoisiServices extends BaseServices
{

    private static $collectionName = "produitsBanqueChoisi";
    /**
     * Transforme un document Firestore en un objet Utilisateur
     * @param \MrShan0\PHPFirestore\FireStoreDocument $doc - le document Firestore à transformer
     * @return ProduitBanqueChoisi
     */
    public static function fromFirestoreDocument($doc)
    {
        //var_dump($doc);
        $data = $doc->toArray();
        $id = Database::getDocumentIdFromName($doc->getName());
        $produit = (new ProduitBanqueChoisi())->fromArray($data);
        $produit->setDocId($id);
        return $produit;
    }

    /**
     * Crée un nouveau produit dans la base de données
     * @param ProduitBanqueChoisi $produitBanqueChosi - le choix du produit à enregistrer
     * @return mixed - le résultat de la création
     */
    public static function create(ProduitBanqueChoisi $produit)
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
    public static function getAll($idProspect = null, $idProduitChoisi = null)
    {
        // Appel de la méthode de récupération de tous les documents dans la classe
        $queryBuilder = Database::queryBuilder(self::$collectionName);

        if ($idProspect) {
            $queryBuilder->where('idProspect', 'EQUAL', $idProspect);
        }
        if ($idProduitChoisi != null) {
            $queryBuilder->where('idProduitBanque', 'EQUAL', $idProduitChoisi);
        }

        $query = $queryBuilder->build();
        $result = Database::query($query);

        $objects = array_map(function ($doc) {
            return self::fromFirestoreDocument($doc);
        }, $result);
        return $objects;
    }


}
