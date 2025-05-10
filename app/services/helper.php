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
}
