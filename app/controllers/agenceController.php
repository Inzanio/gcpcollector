<?php

namespace App\Controllers;

use App\Services\AgenceServices;
use App\Models\Agence;

class AgenceController
{
    public static function index()
    {
        global $agences;
        // il faut récupérer la liste des agences
        //$agences = AgenceServices::getAllAgences();
        include '../app/views/liste-agence.php';
    }

    public static function create()
    {
        $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
        $lieu = trim(htmlspecialchars($_POST['lieu'] ?? ''));
        $code = trim(htmlspecialchars($_POST['code'] ?? ''));

        $agence = new Agence($code, $nom, $lieu, $_SESSION["user_id"]);

        $result = AgenceServices::createAgence($agence);
        if ($result) {
            header('Location: /agences');
        } else {
            $error_message = "Une ereur est survennue lors de la création de l'agence";
            include '../app/views/forms/ajouter-agence.php';
        }
    }
    /**
     * param 
     */
    public static function update(Agence $agence)
    {
        if (isset($_POST['nom'])) {
            $agence->setNom(trim(htmlspecialchars($_POST['nom'])));
        }
        if (isset($_POST['lieu'])) {
            $agence->setLieu(trim(htmlspecialchars($_POST['lieu'])));
        }
        if (isset($_POST['code'])) {
            $agence->setCode(trim(htmlspecialchars($_POST['code'])));
        }

        $result = AgenceServices::updateAgence($agence);
        if ($result) {
            header('Location: /agences');
        } else {
            $error_message = "Une erreur est survenue lors de la mise à jour de l'agence";
            include '../app/views/forms/modifier-agence.php';
        }
    }
}
