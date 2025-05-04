<?php

namespace App\Controllers;

use App\Services\UtilisateurServices;

class SuperviseurController
{
    public static function index()
    {
        // il faut récupérer la liste des superviseurs et des agences
        $superviseurs = UtilisateurServices::getAllUtilisateurs(null, ROLE_SUPERVISEUR);
        include '../app/views/liste-superviseur.php';
    }
}