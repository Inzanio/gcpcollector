<?php

namespace App\Bi;

class ProspectBI {
    
    public static function getTotalProspects($idAgent=null, $idAgence=null, $idCampagne= null, $dateDebut=null, $dateFin=null) {
        return ProspectServices::getTotalProspects($idAgent, $idAgence, $dateDebut, $dateFin);
    }

}