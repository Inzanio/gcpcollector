<?php

namespace App\Controllers;

use App\Services\UtilisateurServices;

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

        $login_result = UtilisateurServices::login($login, $password);

        if ($login_result != false) {
            session_start();
            $_SESSION['user_role'] = $login_result->getRole();
            $_SESSION['user_matricule'] = $login_result->getMatricule();
            $_SESSION['user_login'] = $login_result->getLogin();
            $_SESSION['user_id'] = $login_result->getUid();
            $_SESSION['user_nom'] = $login_result->getNom();
            $_SESSION['user_prenom'] = $login_result->getPrenom();
            $_SESSION['user_agence_id'] = null;

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
}
