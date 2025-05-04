<?php

namespace App\Controllers;

use App\Services\AgenceServices;

class AgenceController
{
    public static function index()
    {
        // il faut récupérer la liste des agences
        $agences = AgenceServices::getAllAgences();
        include '../app/views/liste-agence.php';
    }


}