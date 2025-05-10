<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Services\UtilisateurServices;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;
use Datetime;

class SuperviseurController
{
    public static function index()
    {
        // il faut récupérer la liste des superviseurs et des agences
        $superviseurs = UtilisateurServices::getAllUtilisateurs($_SESSION[FILTER_ID_AGENCE], ROLE_SUPERVISEUR);
        include '../app/views/liste-superviseur.php';
    }

    public static function create()
    {

        $password = trim(htmlspecialchars($_POST['password'] ?? ''));
        $confirmationpassword = trim(htmlspecialchars($_POST['confirmationpassword'] ?? ''));

        $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
        $prenom = trim(htmlspecialchars($_POST['prenom'] ?? ''));
        $telephone = trim(htmlspecialchars($_POST['telephone'] ?? ''));

        $dateNaissance = !empty($_POST['dateNaissance']) ? new Datetime($_POST['dateNaissance']) : null;
        $idAgence = trim(htmlspecialchars($_POST['idAgence'] ?? ''));

        $matricule =trim (htmlspecialchars($_POST['matricule'] ?? ''));
        $login = trim(htmlspecialchars($_POST['login'] ?? ''));
        if ($password !== $confirmationpassword) {
            $error_message = "La confimation de mot de passe et le mot de passe ne correspondent pas";
            return include "../app/views/forms/ajouter-superviseur.php";
        }
        //$password = password_hash($password, PASSWORD_DEFAULT);
        $superviseur = new Utilisateur(
            $nom,
            $prenom,
            new FireStoreTimestamp($dateNaissance),
            $matricule,
            $login,
            $password,
            ROLE_SUPERVISEUR,
            [$telephone],
            ""
        );
        $superviseur->setIdAgence($idAgence);
        $superviseur->setIdCreator($_SESSION["user_id"]);
        
        $result = UtilisateurServices::createUtilisateur($superviseur);
        if ($result) {
            header("Location: /superviseurs");
        } else {
            $error_message = "Une erreur est survenue lors de la création du superviseur";
            include "../app/views/forms/ajouter-superviseur.php";
        }
    }

    public static function update(Utilisateur $utilisateur) {}
}
