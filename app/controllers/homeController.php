<?php

namespace App\Controllers;

use App\Services\ProspectServices;
use App\Bi\ProspectBI;
use Datetime;

class HomeController
{
    /**
     * Gère la page d'accueil de l'application.
     * 
     * Redirige vers le tableau de bord approprié en fonction de son rôle.
     * 
     * @return void
     */
    public static function index()
    {


        if ($_SESSION['user_role'] == ROLE_AGENT) {
            $data_prospects = ProspectServices::getAll($_SESSION['user_id'], $_SESSION['user_agence_id']);
        }
        if ($_SESSION['user_role'] == ROLE_SUPERVISEUR) {
            $data_prospects = ProspectServices::getAll(null,$_SESSION['user_agence_id']);
        }
        if ($_SESSION['user_role'] == ROLE_ADMIN) {
            $data_prospects = ProspectServices::getAll(null, null);
        }
        $prospects = [];
        $clients = [];

        foreach ($data_prospects as $prospect) {
            if ($prospect->isClient()) {
                $clients[] = $prospect;
            } else {
                $prospects[] = $prospect;
            }
        }
        $dateCemois = new DateTime('first day of this month');
        $prospectBICemois = new ProspectBI();
        $prospectBICemois->buildRequest(
            ($_SESSION['user_role']===ROLE_AGENT )?$_SESSION['user_id'] : null ,
            $_SESSION['user_agence_id'],
            null,
            $dateCemois,
            null
        );
        $totalProspects = $prospectBICemois->totalProspect();
        if ($_SESSION["user_role"] !== ROLE_AGENT){
            $_SESSION["total_compte_en_attente_ouverture"] = ProspectBI::getTotalProspectsWaitingForAccountOpening(
                ($_SESSION['user_role']===ROLE_AGENT )?$_SESSION['user_id'] : null,
                $_SESSION['user_agence_id'],
            );
        }
        
        $totalClients = $prospectBICemois->totalClient();
        $tauxConversion = $prospectBICemois->tauxDeConversion();


        //header("Location: /dashboard");
        // Incluez la vue de la page d'accueil
        include '../app/views/dashboard.php';
        exit;
    }
}
