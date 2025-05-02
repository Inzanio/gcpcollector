<?php

namespace App\Bi;

use App\Services\Database;
use App\Services\FirestoreAggregationQueryBuilder;

class ProspectBI
{
    private static $collectionName = "prospects";

    public static function getTotalProspects($idAgent = null, $idAgence = null, $idCampagne = null, $dateDebut = null, $dateFin = null)
    {
        $aggregateQuery = new FirestoreAggregationQueryBuilder(self::$collectionName);
        $aggregateQuery = $aggregateQuery->where('numeroCompte', 'EQUAL', '');

  


        if ($idAgent != null) {
            $aggregateQuery->where('idAgentProspecteur', 'EQUAL', $idAgent);
        }
        if ($idAgence != null) {
            $aggregateQuery->where('idAgence', 'EQUAL', $idAgence);
        }

        $aggregateQuery = $aggregateQuery->count();
        $result = Database::runAggregationQuery($aggregateQuery);
        // // Transformation des documents Firestore en objets Prospect
    

        // // Filtrage des prospects en fonction des dates
        // if ($dateDebut !== null && $dateFin !== null) {
        //     $prospects = array_filter($prospects, function ($prospect) use ($dateDebut, $dateFin) {
        //         return $prospect->getDateCreation() >= $dateDebut && $prospect->getDateCreation() <= $dateFin;
        //     });
        // } elseif ($dateDebut !== null) {
        //     $prospects = array_filter($prospects, function ($prospect) use ($dateDebut) {
        //         return $prospect->getDateCreation() >= $dateDebut;
        //     });
        // } elseif ($dateFin !== null) {
        //     $prospects = array_filter($prospects, function ($prospect) use ($dateFin) {
        //         return $prospect->getDateCreation() <= $dateFin;
        //     });
        // }
    }
}
