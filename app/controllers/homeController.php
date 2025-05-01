<?php
namespace App\Controllers;

// controllers/HomeController.php

class HomeController
{
    /**
     * Gère la page d'accueil de l'application.
     * 
     * Vérifie si l'utilisateur est connecté et redirige vers le tableau de bord approprié en fonction de son rôle.
     * 
     * @return void
     */
    public static function index()
    {
        // Démarrez la session
        session_start();

        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /login');
            exit;
        }
        //header("Location: /dashboard");
        // Incluez la vue de la page d'accueil
        include '../app/views/dashboard.php';
        exit;
    }
}
