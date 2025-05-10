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
            $prospects = ProspectServices::getAll(false,$_SESSION['user_id'], $_SESSION['user_agence_id'],$_SESSION[FILTER_DATE_DEBUT],$_SESSION[FILTER_DATE_FIN],$_SESSION[FILTER_ID_CAMPAGNE],$_SESSION[FILTER_PROFESSION]);
        }
        if ($_SESSION['user_role'] == ROLE_SUPERVISEUR) {
            $prospects = ProspectServices::getAll(false,$_SESSION[FILTER_ID_AGENT],$_SESSION['user_agence_id'],$_SESSION[FILTER_DATE_DEBUT],$_SESSION[FILTER_DATE_FIN],$_SESSION[FILTER_ID_CAMPAGNE],$_SESSION[FILTER_PROFESSION]);
        }
        if ($_SESSION['user_role'] == ROLE_ADMIN) {
            $prospects = ProspectServices::getAll(false,$_SESSION[FILTER_ID_AGENT], $_SESSION[FILTER_ID_AGENCE],$_SESSION[FILTER_DATE_DEBUT],$_SESSION[FILTER_DATE_FIN],$_SESSION[FILTER_ID_CAMPAGNE],$_SESSION[FILTER_PROFESSION]);
        }
        $clients = [];

        foreach ($prospects as $prospect) {
            if ($prospect->isClient()) {
                $clients[] = $prospect;
            }
        }
        $prospectBI = new ProspectBI();
        $prospectBI->buildRequest(
            ($_SESSION['user_role']===ROLE_AGENT )?$_SESSION['user_id'] : $_SESSION[FILTER_ID_AGENT] ,
            ($_SESSION['user_role']!==ROLE_ADMIN )?$_SESSION['user_agence_id'] : $_SESSION[FILTER_ID_AGENCE] ,
            $_SESSION[FILTER_ID_CAMPAGNE],
            $_SESSION[FILTER_DATE_DEBUT],
            $_SESSION[FILTER_DATE_FIN],
            $_SESSION[FILTER_PROFESSION]
        );
       
        if ($_SESSION["user_role"] !== ROLE_AGENT){
            $_SESSION["total_compte_en_attente_ouverture"] = ProspectBI::getTotalProspectsWaitingForAccountOpening(
                ($_SESSION['user_role']===ROLE_AGENT )?$_SESSION['user_id'] : null,
                $_SESSION['user_agence_id'],$_SESSION[FILTER_ID_CAMPAGNE],$_SESSION[FILTER_DATE_DEBUT],$_SESSION[FILTER_DATE_FIN],$_SESSION[FILTER_PROFESSION]

            );
        }
        $totalProspects = $prospectBI->totalProspect();
        $totalClients = $prospectBI->totalClient();
        $tauxConversion = $prospectBI->tauxDeConversion();


        //header("Location: /dashboard");
        // Incluez la vue de la page d'accueil
        include '../app/views/dashboard.php';
        exit;
    }
}
