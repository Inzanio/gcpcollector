<?php

namespace App\Controllers;

use App\Services\AgenceServices;
use App\Services\CampagneServices;
use App\Services\Helper;
use App\Services\UtilisateurServices;


use DateTime;

class LoginController
{
    public static function index()
    {
        include '../app/views/login.php';
    }

    public static function login()
    {

        $login = htmlspecialchars($_POST["login"]);
        $password = htmlspecialchars($_POST["password"]);
        //$password = password_hash($password, PASSWORD_DEFAULT);

        $login_result = UtilisateurServices::login($login, $password);

        if ($login_result != false) {
            session_start();
            $_SESSION['user_role'] = $login_result->getRole();
            $_SESSION['user_matricule'] = $login_result->getMatricule();
            $_SESSION['user_login'] = $login_result->getLogin();
            $_SESSION['user_id'] = $login_result->getDocId();
            $_SESSION['user_nom'] = $login_result->getNom();
            $_SESSION['user_prenom'] = $login_result->getPrenom();

            $_SESSION[FILTER_DATE_DEBUT] = new DateTime('first day of this month');
            $_SESSION[FILTER_DATE_FIN] = new DateTime('last day of this month');

            $_SESSION[FILTER_PROFESSION] = null;
            $_SESSION[FILTER_PRODUIT] = null;
            $_SESSION[FILTER_ID_CAMPAGNE] = null;

            if ($_SESSION['user_role'] !== ROLE_AGENT) {
                $_SESSION[FILTER_ID_AGENT] = null;
            }
            if ($_SESSION['user_role'] !== ROLE_ADMIN) {
                $_SESSION[FILTER_ID_AGENCE] = null;
                $_SESSION['user_agence_id'] = $login_result->getIdAgence();
                $agence = AgenceServices::getAgenceById($login_result->getIdAgence());
                $_SESSION['user_agence_name'] = $agence->getNom();
            } else {
                $_SESSION['user_agence_id'] = null;
                $_SESSION[FILTER_ID_AGENCE] = null;
            }




            header('Location: /');
        } else {
            // Vous pouvez passer une variable à la vue pour afficher un message d'erreur
            //$error = "Login ou mot de passe incorrect.";
            include '../app/views/login.php';
        }
    }
    public static function logout()
    {
        session_start();
        session_destroy();
        header('Location: /');
    }


    public static function must_logged_in()
    {
        // Démarrez la session
        session_start();

        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /login');
            exit;
        }
        Helper::initGlobalVariables();
    }
    public static function is_logged_in()
    {
        session_start();
        if (isset($_SESSION['user_role'])) {
            return true;
        } else {
            return false;
        }
    }
}
