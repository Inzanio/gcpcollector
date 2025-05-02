<?php

namespace App\Services;

use \MrShan0\PHPFirestore\FireStoreApiClient;
use \MrShan0\PHPFirestore\FireStoreDocument;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;

use Datetime;
use Exception;

/**
 * Classe qui gère les interactions avec la base de données Firestore via l'API REST
 * @package MrShan0\PHPFirestore
 */
class Database
{
    //private static $GOOGLE_APPLICATION_CREDENTIALS = ;
    private static $credentials;
    private static $firestoreClient;
    /**
     * Retourne une Instance de l'api Firestore
     * @param string $GOOGLE_APPLICATION_CREDENTIALS Chemin d'accès aux informations d'identification pour l'accès au compte Firebase
     * @return \MrShan0\PHPFirestore\FireStoreApiClient
     */
    public static function getFirestore()
    {
        if (!self::$firestoreClient) {
            //echo "Initialisation de l'API Firestore";
            $json = file_get_contents(FIREBASE_CREDENTIALS_PATH);
            self::$credentials = json_decode($json, true);
            self::$firestoreClient = new FireStoreApiClient(self::$credentials["project_id"], self::$credentials["apiKey"], [
                'database' => '(default)',
            ]);
        }
        return self::$firestoreClient;
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
    public static function createDocument($collectionName, $documentId, $data)
    {
        $data['dateCreation'] = new FireStoreTimestamp('now');
        $data['dateModification'] = new FireStoreTimestamp('now');

        $result = self::getFirestore()->addDocument($collectionName, $data, $documentId);
        return $result;
    }

    /**
     * Récupère un document spécifique dans une collection de la base de données Firestore
     * @param string $collectionName Nom de la collection
     * @param string $documentId ID du document
     * @return array|null Données du document ou null si le document n'existe pas
     */
    public static function getDocument($collectionName, $documentId)
    {
        $result = self::getFirestore()->getDocument($collectionName, $documentId);
        return $result; // $document->exists() ? $document->data() : null;
    }

    /**
     * Met à jour un document spécifique dans une collection de la base de données Firestore
     * @param string $collectionName Nom de la collection
     * @param string $documentId ID du document
     * @param array $data Données à mettre à jour
     */
    public static function updateDocument($collectionName, $documentId, $data, $documentExist = True)
    {
        $data['dateModification'] = new FireStoreTimestamp('now');
        $champs = array_chunk($data, 10, true);
        $success = true;

        foreach ($champs as $chunk) {
            try {
                $firestoreClient = self::getFirestore();
                $response = $firestoreClient->updateDocument($collectionName, $documentId, $chunk, $documentExist);
                if (!self::isSuccessfullRequest($response)) {
                    $success = false;
                    break;
                }
            } catch (\Exception $e) {
                $success = false;
                break;
            }
        }
        return $success ? $response : false;
    }

    /**
     * Supprime un document spécifique dans une collection de la base de données Firestore
     * @param string $collectionName Nom de la collection
     * @param string $documentId ID du document
     */
    public static function deleteDocument($collectionName, $documentId)
    {
        $firestoreClient = self::getFirestore();
        return $firestoreClient->deleteDocument($collectionName, $documentId);
    }

    public static function runAggregationQuery($query)
    {
        $url = 'https://firestore.googleapis.com/v1/projects/' . self::$credentials["project_id"] . '/databases/(default)/documents:runAggregationQuery';
        $body = json_encode($query);
        $headers = [
            'Content-Type: application/json',
            #'Authorization: Bearer ' . self::$credentials["apiKey"],
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
    public static function query($query)
    {
        $url = 'https://firestore.googleapis.com/v1/projects/' . self::$credentials["project_id"] . '/databases/(default)/documents:runQuery';
        $body = json_encode(['structuredQuery' => $query]);
        $headers = [
            'Content-Type: application/json',
            #'Authorization: Bearer ' . self::$credentials["apiKey"],
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);
        if (!self::isSuccessfullRequest($response)) {
            return false;
        }
        return self::toArrayDocument($response);
    }

    public static function queryBuilder($collectionName)
    {
        return new FirestoreQueryBuilder($collectionName);
    }

    /**
     * Convertit la réponse de Firestore en tableau d'objets
     * @param string $response La réponse de Firestore au format JSON
     * @return \MrShan0\PHPFirestore\FireStoreDocument Un tableau d'objets représentant les documents
     */
    public static function toDocument($object)
    {
        return new FireStoreDocument($object);
    }

    /**
     * Convertit la réponse de Firestore en tableau d'objets
     * @param string $response La réponse de Firestore au format JSON
     * @return MrShan0\PHPFirestore\FireStoreDocument[]
     */
    public static function firestoreQueryResponseToObject($response)
    {
        $response = json_decode($response, true);

        $result = [];
        foreach ($response as $object) {

            if (isset($object['document'])) {
                $document = $object['document'];
                if (FireStoreDocument::isValidDocument($document)) {
                    $result[] = self::toDocument($document);
                }
            }
        }
        return $result;
    }

    private static function firestoreArrayValueToArray($arrayValue)
    {
        $result = [];
        foreach ($arrayValue['values'] as $value) {
            if (isset($value['stringValue'])) {
                $result[] = $value['stringValue'];
            } elseif (isset($value['integerValue'])) {
                $result[] = (int) $value['integerValue'];
            } elseif (isset($value['booleanValue'])) {
                $result[] = (bool) $value['booleanValue'];
            } elseif (isset($value['doubleValue'])) {
                $result[] = (float) $value['doubleValue'];
            }
        }
        return $result;
    }

    // public static function decode($response)
    // {
    //     return FireStoreHelper::decode($response);
    // }

    /**
     * Convertit la réponse de Firestore en tableau associatif
     * @param string $response La réponse de Firestore au format JSON
     * @return MrShan0\PHPFirestore\FireStoreDocument[]
     */
    public static function toArrayDocument($response)
    {
        //var_dump($response);
        $docs = self::firestoreQueryResponseToObject($response);

        // if ( FireStoreDocument::isValidDocument($object) ) {
        //     return new FireStoreDocument($object);
        // };
        // return null;
        return $docs;
    }
    public static function getDocumentIdFromName($name)
    {
        $parts = explode('/', $name);
        return end($parts);
    }
    /**
     * Vérifie si la requête a réussi
     * @param string $response La réponse de Firestore au format JSON
     * @return bool true si la requête a réussi, false sinon
     */
    public static function isSuccessfullRequest($response)
    {
        $error = json_decode($response, true);
        if (isset($error["error"])) {
            var_dump($error["error"]);
            return false;
        }
        return true;
    }

    function readAggregationResponse($response, $aggregationType = 'count')
    {
        $supportedTypes = ['count', 'sum', 'avg'];
        if (!in_array($aggregationType, $supportedTypes)) {
            throw new Exception("Type d'agrégation non supporté : $aggregationType");
        }
        if (isset($response[0]['result']['aggregateFields'][$aggregationType]['integerValue'])) {
            return $response[0]['result']['aggregateFields'][$aggregationType]['integerValue'];
        } elseif (isset($response[0]['result']['aggregateFields'][$aggregationType]['readTime'])) {
            return null; // ou vous pouvez lever une exception
        }
        return null;
    }
}
/**
 * Classe pour construire des requêtes Firestore.
 */
class FirestoreQueryBuilder
{
    /**
     * Nom de la collection Firestore à interroger.
     *
     * @var string
     */
    private $collectionName;

    /**
     * Champs à sélectionner dans la requête.
     *
     * @var array
     */
    private $fields;

    /**
     * Conditions de filtrage pour la requête.
     *
     * @var array
     */
    private $where;

    /**
     * Critères de tri pour les résultats.
     *
     * @var array
     */
    private $orderBy;

    /**
     * Nombre maximum de documents à retourner.
     *
     * @var int
     */
    private $limit;

    /**
     * Constructeur de la classe.
     *
     * @param string $collectionName Nom de la collection Firestore à interroger.
     */
    public function __construct($collectionName)
    {
        $this->collectionName = $collectionName;
    }

    /**
     * Spécifie les champs à inclure dans les résultats.
     *
     * @param array $fields Champs à sélectionner.
     *
     * @return FirestoreQueryBuilder
     */
    public function select($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * Ajoute une condition de filtrage.
     *
     * @param string $field Champ à filtrer.
     * @param string $op Opérateur de comparaison.
     * @param mixed $value Valeur à comparer.
     *
     * @return FirestoreQueryBuilder
     */
    public function where($field, $op, $value)
    {
        // Initialise le tableau de conditions si nécessaire
        if (!isset($this->where)) {
            $this->where = [];
        }
        // Ajoute la condition au tableau
        $this->where[] = ['field' => $field, 'op' => $op, 'value' => $value];
        return $this;
    }

    /**
     * Spécifie le champ et la direction du tri.
     *
     * @param string $field Champ à trier.
     * @param string $direction Direction du tri (asc ou desc).
     *
     * @return FirestoreQueryBuilder
     */
    public function orderBy($field, $direction)
    {
        $this->orderBy = ['field' => $field, 'direction' => $direction];
        return $this;
    }

    /**
     * Fixe le nombre maximum de documents à retourner.
     *
     * @param int $limit Nombre maximum de documents.
     *
     * @return FirestoreQueryBuilder
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Construit la requête Firestore.
     *
     * @return array Requête Firestore structurée.
     */
    public function build()
    {
        // Initialise la requête avec la collection
        $query = [
            'from' => [
                [
                    'collectionId' => $this->collectionName,
                ],
            ],
        ];

        // Ajoute les champs sélectionnés si spécifiés
        if (isset($this->fields)) {
            $query['select'] = [
                'fields' => $this->fields,
            ];
        }

        // Ajoute les conditions de filtrage si spécifiées
        if (isset($this->where)) {
            $filters = [];
            foreach ($this->where as $filter) {
                $filters[] = [
                    'fieldFilter' => [
                        'field' => [
                            'fieldPath' => $filter['field'],
                        ],
                        'op' => strtoupper($filter['op']),
                        'value' => [
                            'stringValue' => $filter['value'],
                        ],
                    ],
                ];
            }

            // Utilise un filtre composite si plusieurs conditions
            if (count($filters) == 1) {
                $query['where'] = $filters[0];
            } else {
                $query['where'] = [
                    'compositeFilter' => [
                        'op' => 'AND',
                        'filters' => $filters,
                    ],
                ];
            }
        }

        // Ajoute les critères de tri si spécifiés
        if (isset($this->orderBy)) {
            $query['orderBy'] = [
                [
                    'field' => [
                        'fieldPath' => $this->orderBy['field'],
                    ],
                    'direction' => strtoupper($this->orderBy['direction']),
                ],
            ];
        }

        // Ajoute la limite si spécifiée
        if (isset($this->limit)) {
            $query['limit'] = $this->limit;
        }

        return $query;
    }
}
# initialisation de l'API Firestore
Database::getFirestore();
