<?php

namespace App\Controllers;

use App\Models\Campagne;
use App\Services\CampagneServices;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;
use Datetime;

class CampagneController
{
    public static function index()
    {
        // il faut récupérer la liste des superviseurs et des agences
        global $campagnes;
        include '../app/views/liste-campagne.php';
    }

    public static function create()
    {

        $libelle = trim(htmlspecialchars($_POST['libelle'] ?? ''));
        $lieu = trim(htmlspecialchars($_POST['lieu'] ?? ''));

        $dateDebut = !empty($_POST['dateDebut']) ? new Datetime($_POST['dateDebut']) : null;
        $dateFin = !empty($_POST['dateFin']) ? new Datetime($_POST['dateFin']) : null;

        $campagne = new Campagne();
        $campagne->setLibelle($libelle);
        $campagne->setLieu($lieu);

        $campagne->setDateDebut(new FireStoreTimestamp($dateDebut));
        $campagne->setDateFin(new FireStoreTimestamp($dateFin));
        $campagne->setIdCreator($_SESSION["user_id"]);
        $result = CampagneServices::createCampagne($campagne);
        if ($result) {
            header('Location: /campagnes');
        } else {
            $error_message = "Une ereur est survennue lors de la création de la campagne";
            include '../app/views/forms/ajouter-campagne.php';
        }
    }

    public static function update(Campagne $campagne)
    {
        if (isset($_POST['libelle'])) {
            $campagne->setLibelle(trim(htmlspecialchars($_POST['libelle'])));
        }
        if (isset($_POST['lieu'])) {
            $campagne->setLieu(trim(htmlspecialchars($_POST['lieu'])));
        }

        if (isset($_POST['dateDebut']) && !empty($_POST['dateDebut'])) {
            $campagne->setDateDebut(new FireStoreTimestamp(new Datetime($_POST['dateDebut'])));
        }
        if (isset($_POST['dateFin']) && !empty($_POST['dateFin'])) {
            $campagne->setDateFin(new FireStoreTimestamp(new Datetime($_POST['dateFin'])));
        }

        $result = CampagneServices::updateCampagne($campagne);
        if ($result) {
            header('Location: /campagnes');
        } else {
            $error_message = "Une erreur est survenue lors de la modification de la campagne";
            include '../app/views/forms/modifier-campagne.php';
        }
    }
}
