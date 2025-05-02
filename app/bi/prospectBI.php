<?php

namespace App\Bi;

use App\Services\Database;
use App\Services\FirestoreAggregationQueryBuilder;



class ProspectBI
{
    public $totalProspects;
    public $totalClients;


    public function __construct($idAgent = null, $idAgence = null, $idCampagne = null,$dateDebut = null, $dateFin = null,)
    {
        $this->totalProspects = self::getTotalProspects($idAgent, $idAgence, $idCampagne, $dateDebut, $dateFin);
        $this->totalClients = self::getTotalClients($idAgent, $idAgence, $idCampagne, $dateDebut, $dateFin);
    }

    public function totalProspect()
    {
        return $this->totalProspects;
    }
    public function totalClient()
    {
        return $this->totalClients;
    }
    public function tauxDeConversion()
    {
        return CalculsBI::tauxConversion($this->totalProspects, $this->totalClients);
    }

    public static function getTotalProspects($idAgent = null, $idAgence = null, $idCampagne = null, $dateDebut = null, $dateFin = null)
    {
        $aggregateQuery = new FirestoreAggregationQueryBuilder('prospects');
        $aggregateQuery->where('numeroCompte', 'EQUAL', '');
        if ($idAgent != null) {
            $aggregateQuery->where('idAgentProspecteur', 'EQUAL', $idAgent);
        }
        if ($idAgence != null) {
            $aggregateQuery->where('idAgence', 'EQUAL', $idAgence);
        }
        if ($idCampagne != null) {
            $aggregateQuery->where('idCampagne', 'EQUAL', $idCampagne);
        }
        if ($dateDebut != null) {
            $aggregateQuery->where('dateCreation', 'GREATER_THAN_OR_EQUAL', $dateDebut->format(FIRESTORE_DATE_FORMAT));
        }
        if ($dateFin != null) {
            $aggregateQuery->where('dateCreation', 'LESS_THAN', $dateFin->format(FIRESTORE_DATE_FORMAT));
        }
        $result = Database::runAggregationQuery($aggregateQuery->count());
        return Database::readAggregationResponse($result, 'count');
    }

    public static function getTotalClients($idAgent = null, $idAgence = null, $idCampagne = null, $dateDebut = null, $dateFin = null)
    {
        $aggregateQuery = new FirestoreAggregationQueryBuilder('prospects');
        $aggregateQuery->where('numeroCompte', 'NOT_EQUAL', '');
        if ($idAgent != null) {
            $aggregateQuery->where('idAgentProspecteur', 'EQUAL', $idAgent);
        }
        if ($idAgence != null) {
            $aggregateQuery->where('idAgence', 'EQUAL', $idAgence);
        }
        if ($idCampagne != null) {
            $aggregateQuery->where('idCampagne', 'EQUAL', $idCampagne);
        }
        if ($dateDebut != null) {
            $aggregateQuery->where('dateCreation', 'GREATER_THAN_OR_EQUAL', $dateDebut->format(FIRESTORE_DATE_FORMAT));
        }
        if ($dateFin != null) {
            $aggregateQuery->where('dateCreation', 'LESS_THAN', $dateFin->format(FIRESTORE_DATE_FORMAT));
        }
        $result = Database::runAggregationQuery($aggregateQuery->count());
        return Database::readAggregationResponse($result, 'count');
    }
}
