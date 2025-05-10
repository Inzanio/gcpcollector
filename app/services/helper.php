<?php

namespace App\Services;

class Helper
{

    public static function updateFilters()
    {
        if (isset($_POST[FILTER_PRODUIT])) {
            $_SESSION[FILTER_PRODUIT] = $_POST[FILTER_PRODUIT];
        }

        if (isset($_POST[FILTER_DATE_DEBUT])) {
            $_SESSION[FILTER_DATE_DEBUT] = $_POST[FILTER_DATE_DEBUT];
        }

        if (isset($_POST[FILTER_DATE_FIN])) {
            $_SESSION[FILTER_DATE_FIN] = $_POST[FILTER_DATE_FIN];
        }

        if (isset($_POST[FILTER_PROFESSION])) {
            $_SESSION[FILTER_PROFESSION] = $_POST[FILTER_PROFESSION];
        }

        if (isset($_POST[FILTER_ID_AGENCE])) {
            $_SESSION[FILTER_ID_AGENCE] = $_POST[FILTER_ID_AGENCE];
        }

        if (isset($_POST[FILTER_ID_AGENT])) {
            $_SESSION[FILTER_ID_AGENT] = $_POST[FILTER_ID_AGENT];
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
