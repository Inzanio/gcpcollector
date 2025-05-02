<?php
namespace App\Controllers;

// controllers/HomeController.php

class HomeController
{
    /**
     * Gère la page d'accueil de l'application.
     * 
     * Redirige vers le tableau de bord approprié en fonction de son rôle.
     * 
     * @return void
     */
    public static function index()
    {
        //header("Location: /dashboard");
        // Incluez la vue de la page d'accueil
        include '../app/views/dashboard.php';
        exit;
    }
}
