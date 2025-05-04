<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Services\UtilisateurServices;
use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;
use Datetime;

class AgentController
{
    public static function index()
    {
        // il faut récupérer la liste des superviseurs et des agences
        $agents = UtilisateurServices::getAllUtilisateurs($_SESSION["user_agence_id"], ROLE_AGENT);
        include '../app/views/liste-agent.php';
    }

    public static function create()
    {

        $password = trim(htmlspecialchars($_POST['password'] ?? ''));
        $confirmationpassword = trim(htmlspecialchars($_POST['confirmationpassword'] ?? ''));

        $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
        $prenom = trim(htmlspecialchars($_POST['prenom'] ?? ''));
        $telephone = trim(htmlspecialchars($_POST['telephone'] ?? ''));

        $dateNaissance = !empty($_POST['dateNaissance']) ? new Datetime($_POST['dateNaissance']) : null; 

        $matricule =trim (htmlspecialchars($_POST['matricule'] ?? ''));
        $login = trim(htmlspecialchars($_POST['login'] ?? ''));
        if ($password !== $confirmationpassword) {
            $error_message = "La confimation de mot de passe et le mot de passe ne correspondent pas";
            return include "../app/views/forms/ajouter-superviseur.php";
        }
        //$password = password_hash($password, PASSWORD_DEFAULT);
        $agent = new Utilisateur(
            $nom,
            $prenom,
            new FireStoreTimestamp($dateNaissance),
            $matricule,
            $login,
            $password,
            ROLE_AGENT,
            [$telephone],
            ""
        );
        $agent->setIdAgence($_SESSION["user_agence_id"]);
        $agent->setIdCreator($_SESSION["user_id"]);
        
        $result = UtilisateurServices::createUtilisateur($agent);
        if ($result) {
            header("Location: /agents");
        } else {
            $error_message = "Une erreur est survenue lors de la création du superviseur";
            include "../app/views/forms/ajouter-agent.php";
        }
    }

    public static function update(Utilisateur $utilisateur) {
        
    }
}
