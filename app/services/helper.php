<?php

namespace App\Services;

use DateTime;

class Helper
{

    public static function updateFilters()
    {
        if (isset($_POST[FILTER_PRODUIT])) {

            $_SESSION[FILTER_PRODUIT] = ($_POST[FILTER_PRODUIT] === "") ? null : $_POST[FILTER_PRODUIT];
            
        }

        if (isset($_POST[FILTER_DATE_DEBUT])) {
            $_SESSION[FILTER_DATE_DEBUT] = new DateTime($_POST[FILTER_DATE_DEBUT]);
        }

        if (isset($_POST[FILTER_DATE_FIN])) {
            $_SESSION[FILTER_DATE_FIN] = new DateTime($_POST[FILTER_DATE_FIN]);
        }

        if (isset($_POST[FILTER_PROFESSION])) {
            $_SESSION[FILTER_PROFESSION] = ($_POST[FILTER_PROFESSION] === "") ? null : $_POST[FILTER_PROFESSION];
   
        }

        if (isset($_POST[FILTER_ID_AGENCE])) {
            $_SESSION[FILTER_ID_AGENCE] = ($_POST[FILTER_ID_AGENCE] === "") ? null : $_POST[FILTER_ID_AGENCE];
        }

        if (isset($_POST[FILTER_ID_AGENT])) {
            $_SESSION[FILTER_ID_AGENT] = ($_POST[FILTER_ID_AGENT] === "") ? null : $_POST[FILTER_ID_AGENT];
        }
        if (isset($_POST[FILTER_ID_CAMPAGNE])) {
            $_SESSION[FILTER_ID_CAMPAGNE] = ($_POST[FILTER_ID_CAMPAGNE] === "") ? null : $_POST[FILTER_ID_CAMPAGNE];
        }
    }
    public static function initGlobalVariables()
    {
        global $agences;

        if ($_SESSION["user_role"] === ROLE_ADMIN) {
            $agences = AgenceServices::getAllAgences();
        }
        global $agents;
        if ($_SESSION["user_role"] !== ROLE_AGENT) {
            $agents = UtilisateurServices::getAllUtilisateurs($_SESSION["user_agence_id"], ROLE_AGENT);
        }
        global $campagnes;
        if (isset($_GET['idCampagne'])) {
            $idCampagne = $_GET['idCampagne'];
            $campagnes[] = CampagneServices::getCampagneById($idCampagne);
        } else {
            $campagnes = CampagneServices::getAllCampagnes($_SESSION["user_agence_id"]);
        }
        self::updateFilters();
    }
}
