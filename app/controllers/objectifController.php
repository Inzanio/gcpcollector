<?php

namespace App\Controllers;

use App\Models\Objectif;
use App\Services\ObjectifServices;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;
use Datetime;

class ObjectifController
{
    public static function index()
    {
        // il faut récupérer la liste des superviseurs et des agences
        $objectifs = ObjectifServices::getAllObjectifs(null, $_SESSION["user_agence_id"], null);
        include '../app/views/liste-objectif.php';
    }

    public static function create()
    {

        $libelle = trim(htmlspecialchars($_POST['libelle'] ?? ''));
        $cible = trim(htmlspecialchars($_POST['cible'] ?? null));
        $valeur = trim(htmlspecialchars($_POST['valeur'] ?? ''));
        $dateDebut = !empty($_POST['dateDebut']) ? new Datetime($_POST['dateDebut']) : null;
        $dateFin = !empty($_POST['dateFin']) ? new Datetime($_POST['dateFin']) : null;


        $idCampagne = trim(htmlspecialchars($_POST['idCampagne'] ?? null));
        $idAgent = trim(htmlspecialchars($_POST['idAgent'] ?? null));
        if ($_SESSION["user_role"] == ROLE_SUPERVISEUR) {
            $idAgence = $_SESSION["user_agence_id"];
        } else {
            $idAgence = trim(htmlspecialchars($_POST['idAgence'] ?? null));
        }
        $objectif = new Objectif();
        $objectif->setLibelle($libelle);
        $objectif->setCible($cible);
        $objectif->setValeur($valeur);

        $objectif->setDateDebut(new FireStoreTimestamp($dateDebut));
        $objectif->setDateFin(new FireStoreTimestamp($dateFin));

        $objectif->setIdAgent($idAgent);
        $objectif->setIdAgence($idAgence);
        $objectif->setIdCampagne($idCampagne);
        $objectif->setIdCreator($_SESSION["user_id"]);
        $result = ObjectifServices::createObjectif($objectif);
        if ($result) {
            header('Location: /objectifs');
        } else {
            $error_message = "Une ereur est survennue lors de la création de la objectif";
            include '../app/views/forms/ajouter-objectif.php';
        }
    }

    public static function update(Objectif $objectif)
    {
        if (isset($_POST['libelle'])) {
            $objectif->setLibelle(trim(htmlspecialchars($_POST['libelle'])));
        }
        if (isset($_POST['cible'])) {
            $objectif->setCible(trim(htmlspecialchars($_POST['cible'])));
        }
        if (isset($_POST['valeur'])) {
            $objectif->setValeur(trim(htmlspecialchars($_POST['valeur'])));
        }

        if (isset($_POST['dateDebut']) && !empty($_POST['dateDebut'])) {
            $objectif->setDateDebut(new FireStoreTimestamp(new Datetime($_POST['dateDebut'])));
        }
        if (isset($_POST['dateFin']) && !empty($_POST['dateFin'])) {
            $objectif->setDateFin(new FireStoreTimestamp(new Datetime($_POST['dateFin'])));
        }

        if (isset($_POST['idCampagne'])) {
            $objectif->setIdCampagne(trim(htmlspecialchars($_POST['idCampagne'])));
        }
        if (isset($_POST['idAgent'])) {
            $objectif->setIdAgent(trim(htmlspecialchars($_POST['idAgent'])));
        }
        if ($_SESSION["user_role"] == ROLE_SUPERVISEUR) {
            $objectif->setIdAgence($_SESSION["user_agence_id"]);
        } else {
            if (isset($_POST['idAgence'])) {
                $objectif->setIdAgence(trim(htmlspecialchars($_POST['idAgence'])));
            }
        }

        $result = ObjectifServices::updateObjectif($objectif);
        if ($result) {
            header('Location: /objectifs');
        } else {
            $error_message = "Une erreur est survenue lors de la modification de l'objectif";
            include '../app/views/forms/modifier-objectif.php';
        }
    }
}
