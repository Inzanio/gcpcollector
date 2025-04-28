<?php

require __DIR__ . '/vendor/autoload.php';
use \MrShan0\PHPFirestore\FireStoreApiClient;
use \MrShan0\PHPFirestore\FireStoreDocument;


/**
 * Classe qui gère les interactions avec la base de données Firestore via l'API REST
 * @package MrShan0\PHPFirestore
 */
class Database
{
    private static $GOOGLE_APPLICATION_CREDENTIALS = "../application_default_credentials.json";
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
            $json = file_get_contents(self::$GOOGLE_APPLICATION_CREDENTIALS);
            self::$credentials = json_decode($json, true);
            self::$firestoreClient = new FireStoreApiClient(self::$credentials["project_id"], self::$credentials["apiKey"], [
                'database' => '(default)',
            ]);
        }
        return self::$firestoreClient;

    }

    /**
     * Récupère une collection spécifique dans la base de données Firestore
     * @param string $collectionName Nom de la collection
     * @return \Google\Cloud\Firestore\CollectionReference
     */
    // public static function getCollectionRef($collectionName)
    // {
    //     return self::getFirestore()->collection($collectionName);
    // }

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
        $result = self::getFirestore()->addDocument($collectionName, $data ,$documentId);
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
        $result = self::getFirestore()->getDocument($collectionName,$documentId);
        return $result ;// $document->exists() ? $document->data() : null;
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
        $firestoreClient = self::getFirestore();
        return $firestoreClient->updateDocument($collectionName, $documentId, $data);
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
    // /**
    //  * Convertit un objet en tableau associatif
    //  * @param object $object L'objet à convertir
    //  * @return \MrShan0\PHPFirestore\Fields\FireStoreObject Le tableau associatif représentant l'objet
    //  */
    // public static function toFireStoreObject($object)
    // {
    //     return self::toDocument($object)->getObject($object);
    // }

    /**
     * Convertit la réponse de Firestore en tableau d'objets
     * @param string $response La réponse de Firestore au format JSON
     * @return MrShan0\PHPFirestore\FireStoreDocument[]
     */
    public static function firestoreResponseToObject($response)
    {
        $response = json_decode($response, true);
        
        $result = [];
        foreach ($response as $object) {
            // var_dump($object);
            // var_dump(FireStoreDocument::isValidDocument($object));
            
            if (isset($object['document'])) {
                $document = $object['document'];
                if ( FireStoreDocument::isValidDocument($document) ) {
                    $result[] = self::toDocument($document);
                }
                // $name = explode('/', $document['name']);
                // $documentId = end($name);
                // $fields = isset($document['fields']) ? $document['fields'] : [];
                // $data = self::firestoreFieldsToArray($fields);
                // $result[] = (object) [
                //     'id' => $documentId,
                //     'data' => $data,
                //     'createTime' => $document['createTime'],
                //     'updateTime' => $document['updateTime'],
                // ];
            }
        }
        return $result;
    }

    private static function firestoreFieldsToArray($fields)
    {
        $result = [];
        foreach ($fields as $field => $value) {
            if (isset($value['stringValue'])) {
                $result[$field] = $value['stringValue'];
            } elseif (isset($value['integerValue'])) {
                $result[$field] = (int) $value['integerValue'];
            } elseif (isset($value['booleanValue'])) {
                $result[$field] = (bool) $value['booleanValue'];
            } elseif (isset($value['doubleValue'])) {
                $result[$field] = (float) $value['doubleValue'];
            } elseif (isset($value['arrayValue'])) {
                $result[$field] = self::firestoreArrayValueToArray($value['arrayValue']);
            } elseif (isset($value['mapValue'])) {
                $result[$field] = self::firestoreFieldsToArray($value['mapValue']['fields']);
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
        $docs = self::firestoreResponseToObject($response);
        
        // if ( FireStoreDocument::isValidDocument($object) ) {
        //     return new FireStoreDocument($object);
        // };
        // return null;
        return $docs;
    }
   
}
class FirestoreQueryBuilder
{
    private $collectionName;
    private $fields;
    private $where;
    private $orderBy;
    private $limit;

    public function __construct($collectionName)
    {
        $this->collectionName = $collectionName;
    }

    public function select($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function where($field, $op, $value)
    {
        if (!isset($this->where)) {
            $this->where = [];
        }
        $this->where[] = ['field' => $field, 'op' => $op, 'value' => $value];
        return $this;
    }

    public function orderBy($field, $direction)
    {
        $this->orderBy = ['field' => $field, 'direction' => $direction];
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function build()
    {
        $query = [
            'from' => [
                [
                    'collectionId' => $this->collectionName,
                ],
            ],
        ];

        if (isset($this->fields)) {
            $query['select'] = [
                'fields' => $this->fields,
            ];
        }

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

        if (isset($this->limit)) {
            $query['limit'] = $this->limit;
        }

        return $query;
    }
}
# initialisation de l'API Firestore
Database::getFirestore();
?>