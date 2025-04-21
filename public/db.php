<?php
require __DIR__ . '/vendor/autoload.php';
use Kreait\Firebase\Factory;

/**
 * Classe qui gère les interactions avec la base de données Firestore
 */
class Database
{
    private static $GOOGLE_APPLICATION_CREDENTIALS = "../application_default_credentials.json";
    /**
     * Retourne une Instance de Firestore
     * @param string $GOOGLE_APPLICATION_CREDENTIALS Chemin d'accès aux informations d'identification pour l'accès au compte Firebase
     * @return \Google\Cloud\Firestore\FirestoreClient
     */
    public static function getFirestore()
    {
        // Crée une instance de Factory avec les informations d'identification
        $factory = (new Factory())
            ->withServiceAccount(self::$GOOGLE_APPLICATION_CREDENTIALS);
        // Crée une instance de Firestore
        return $factory->createFirestore()->database();
    }

    /**
     * Récupère une collection spécifique dans la base de données Firestore
     * @param string $collectionName Nom de la collection
     * @return \Google\Cloud\Firestore\CollectionReference
     */
    public static function getCollectionRef($collectionName)
    {
        return self::getFirestore()->collection($collectionName);
    }

    /**
     * Ajoute un document à une collection spécifique dans la base de données Firestore
     * @param string $collectionName Nom de la collection
     * @param array $data Données à ajouter au document
     * * Example:
     * ```
     * $document->create([
     *     'name' => 'John',
     *     'country' => 'USA'
     * ]);
     * ```
     * @return string ID du document ajouté
     */
    public static function createDocument($collectionName, $documentId , $data)
    {
        $collection = self::getCollectionRef($collectionName);
        $document = $collection->document($documentId);
        $document->create($data);
        return $document->id();
    }

    /**
     * Récupère un document spécifique dans une collection de la base de données Firestore
     * @param string $collectionName Nom de la collection
     * @param string $documentId ID du document
     * @return array|null Données du document ou null si le document n'existe pas
     */
    public static function getDocument($collectionName, $documentId)
    {
        $collection = self::getCollectionRef($collectionName);
        $document = $collection->document($documentId);
        return $document->snapshot()->data();
    }

    /**
     * Met à jour un document spécifique dans une collection de la base de données Firestore
     * @param string $collectionName Nom de la collection
     * @param string $documentId ID du document
     * @param array $data Données à mettre à jour
     *Example:
     * ```
     * $document->update([
     *     ['path' => 'name', 'value' => 'John'],
     *     ['path' => 'country', 'value' => 'USA'],
     *     ['path' => 'cryptoCurrencies.bitcoin', 'value' => 0.5],
     *     ['path' => 'cryptoCurrencies.ethereum', 'value' => 10],
     *     ['path' => 'cryptoCurrencies.litecoin', 'value' => 5.51]
     * ]);
     * ```
     */
    public static function updateDocument($collectionName, $documentId, $data)
    {
        $collection = self::getCollectionRef($collectionName);
        $document = $collection->document($documentId);
        $document->update($data);
    }

    /**
     * Supprime un document spécifique dans une collection de la base de données Firestore
     * @param string $collectionName Nom de la collection
     * @param string $documentId ID du document
     */
    public static function deleteDocument($collectionName, $documentId)
    {
        $collection = self::getCollectionRef($collectionName);
        $document = $collection->document($documentId);
        $document->delete();
    }

}

?>