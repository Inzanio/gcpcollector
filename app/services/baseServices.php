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
    protected static $collectionName;

    /**
     * Crée un nouveau document dans la base de données
     * 
     * @param object $model - l'objet à créer
     * @param string|null $documentId - l'ID du document (facultatif)
     * @return mixed - le résultat de la création
     */
    public static function create($model, $documentId = null)
    {
        return Database::createDocument(static::$collectionName, $documentId, $model->toArray());
    }

    /**
     * Met à jour un document existant dans la base de données
     * 
     * @param object $model - l'objet mis à jour
     * @return mixed - le résultat de la mise à jour
     */
    public static function update($model)
    {
        return Database::updateDocument(static::$collectionName, $model->getDocId(), $model->toArray());
    }

    /**
     * Récupère tous les documents de la collection
     * 
     * @return array - le tableau des objets récupérés
     */
    public static function getAll()
    {
        $queryBuilder = Database::queryBuilder(static::$collectionName);
        $query = $queryBuilder->build();
        $result = Database::query($query);

        $models = array_map(function ($doc) {
            return static::fromFirestoreDocument($doc);
        }, $result);
        return $models;
    }

    /**
     * Récupère un document par son ID
     * 
     * @param string $documentId - l'ID du document
     * @return object - l'objet récupéré
     */
    public static function getById($documentId)
    {
        $result = Database::getDocument(static::$collectionName, $documentId);
        return static::fromFirestoreDocument($result);
    }

    /**
     * Méthode abstraite pour transformer un document Firestore en objet
     * 
     * @param object $doc - le document Firestore
     * @return object - l'objet transformé
     */
    abstract public static function fromFirestoreDocument($doc);
}