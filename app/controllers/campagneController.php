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
        $campagnes = CampagneServices::getAllCampagnes($_SESSION["user_agence_id"]);
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

    public static function update(Campagne $campagne) {
        $libelle = trim(htmlspecialchars($_POST['libelle'] ?? ''));
        $lieu = trim(htmlspecialchars($_POST['lieu'] ?? ''));

        $dateDebut = !empty($_POST['dateDebut']) ? new Datetime($_POST['dateDebut']) : null;
        $dateFin = !empty($_POST['dateFin']) ? new Datetime($_POST['dateFin']) : null;

        //$campagne = new Campagne();
        $campagne->setLibelle($libelle);
        $campagne->setLieu($lieu);

        $campagne->setDateDebut(new FireStoreTimestamp($dateDebut));
        $campagne->setDateFin(new FireStoreTimestamp($dateFin));
        //$campagne->setIdCreator($_SESSION["user_id"]);
        $result = CampagneServices::updatecampagne($campagne);
        if ($result) {
            header('Location: /campagnes');
        } else {
            $error_message = "Une ereur est survennue lors de la modification de la campagne";
            include '../app/views/forms/modifier-campagne.php';
        }
    }
}
