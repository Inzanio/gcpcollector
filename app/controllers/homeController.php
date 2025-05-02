<?php

namespace App\Controllers;

use App\Services\ProspectServices;
// controllers/HomeController.php

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

        //header("Location: /dashboard");
        // Incluez la vue de la page d'accueil
        include '../app/views/dashboard.php';
        exit;
    }
}
