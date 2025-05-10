<?php
namespace App\Services;

/**
 * Classe de base pour les services
 * 
 * Cette classe fournit des méthodes communes pour les services,
 * telles que la création, la mise à jour, la récupération de tous les documents
 * et la récupération d'un document par ID.
 */
abstract class BaseServices
{
    /**
     * Nom de la collection Firestore
     * 
     * @var string
     */
    private static $collectionName;

    /**
     * Méthode abstraite pour transformer un document Firestore en objet
     * 
     * @param object $doc - le document Firestore
     * @return object - l'objet transformé
     */
    abstract public static function fromFirestoreDocument($doc);
}