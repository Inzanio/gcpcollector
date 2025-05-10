<?php

namespace App\Services;

/**
 * Classe pour construire des requêtes d'agrégation Firestore.
 */
class FirestoreAggregationQueryBuilder
{
    /**
     * Nom de la collection Firestore à interroger.
     *
     * @var string
     */
    private $collectionName;

    /**
     * Conditions de filtrage pour la requête.
     *
     * @var array
     */
    private $where;

    /**
     * Type d'agrégation (par exemple, 'COUNT').
     *
     * @var string
     */
    private $aggregationType;


    private $upto;


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
     * Ajoute une condition de filtrage à la requête.
     *
     * @param string $field Champ à filtrer.
     * @param string $op Opérateur de comparaison.
     * @param mixed $value Valeur à comparer.
     *
     * @return FirestoreAggregationQueryBuilder
     */
    public function where($field, $op, $value)
    {
        if (!isset($this->where)) {
            $this->where = [];
        }
        $this->where[] = ['field' => $field, 'op' => $op, 'value' => $value];
        return $this;
    }

    /**
     * Construit une requête d'agrégation pour compter les documents.
     *
     * @return array Requête d'agrégation Firestore structurée.
     */
    public function count()
    {
        $this->aggregationType = 'count';
        return $this->build();
    }

    public function upto($value)
    {
        $this->upto = $value;
        return $this;
    }
    /**
     * Construit la requête d'agrégation Firestore.
     *
     * @return array Requête d'agrégation Firestore structurée.
     */
    private function build()
    {
        // Construit la requête structurée Firestore
        $structuredQuery = [
            'from' => [
                [
                    'collectionId' => $this->collectionName,
                ],
            ],
        ];

        // Ajoute les conditions de filtrage si spécifiées
        if (isset($this->where)) {
            $filters = [];
            foreach ($this->where as $filter) {
                $value = $filter['value'];
                $valueType = Database::getFirestoreValueType($value);
        
                $filters[] = [
                    'fieldFilter' => [
                        'field' => [
                            'fieldPath' => $filter['field'],
                        ],
                        'op' => strtoupper($filter['op']),
                        'value' => [
                            $valueType => $value,
                        ],
                    ],
                ];
            }

            // Utilise un filtre composite si plusieurs conditions
            if (count($filters) == 1) {
                $structuredQuery['where'] = $filters[0];
            } else {
                $structuredQuery['where'] = [
                    'compositeFilter' => [
                        'op' => 'AND',
                        'filters' => $filters,
                    ],
                ];
            }
        }

        $aggregation = [
            $this->aggregationType => ($this->aggregationType == 'count') ? [
                'upTo' => $this->upto,
            ] : [
                'field' => [
                    'fieldPath' => '*',
                ],
            ],
            'alias' => strtolower($this->aggregationType),
        ];

        $aggregationQuery = [
            'structuredAggregationQuery' => [
                'structuredQuery' => $structuredQuery,
                'aggregations' => [
                    $aggregation,
                ],
            ],
        ];

        return $aggregationQuery;
    }
}
