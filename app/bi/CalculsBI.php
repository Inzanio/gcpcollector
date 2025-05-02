<?php

namespace App\Bi;

class CalculsBI {

    public static function tauxConversion ($nbProspects, $nbClients) {
        if ($nbProspects == 0) {
            return 0;
        }
        return round(($nbClients / $nbProspects) * 100, 2);
    }
}