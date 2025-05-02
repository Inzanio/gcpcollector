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
            $data_prospects = ProspectServices::getAll($idAgentProspecteur = $_SESSION['user_id'], $idAgence = $_SESSION['user_agence_id']);
        }
        if ($_SESSION['user_role'] == ROLE_SUPERVISEUR) {
            $data_prospects = ProspectServices::getAll($idAgentProspecteur = null, $idAgence = $_SESSION['user_agence_id']);
        }
        if ($_SESSION['user_role'] == ROLE_ADMIN) {
            $data_prospects = ProspectServices::getAll($idAgentProspecteur = null, $idAgence = null);
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
        $prospectBICemois = new ProspectBI(
            $_SESSION['user_id'],
            $_SESSION['user_agence_id'],
            null,
            $dateCemois,
            null
        );
        $dateMoisPasse = new DateTime('first day of last month');
        $prospectBIMoisPasse = new ProspectBI(
            $_SESSION['user_id'],
            $_SESSION['user_agence_id'],
            null,
            $dateMoisPasse,
            $dateCemois
        );
        $totalProspectsCeMois = $prospectBICemois->totalProspect();
        $totalClientsCeMois = $prospectBICemois->totalClient();
        $tauxConversionCeMois = $prospectBICemois->tauxDeConversion();

        $totalProspectsMoisPasse = $prospectBIMoisPasse->totalProspect();
        $totalClientsMoisPasse = $prospectBIMoisPasse->totalClient();
        $tauxConversionMoisPasse = $prospectBIMoisPasse->tauxDeConversion();

        //header("Location: /dashboard");
        // Incluez la vue de la page d'accueil
        include '../app/views/dashboard.php';
        exit;
    }
}
