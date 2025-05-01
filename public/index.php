<?php
require_once '../vendor/autoload.php';
require_once '../config/constants.php';
require_once '../config/database.php';


use App\Controllers\HomeController;
use App\Controllers\LoginController;


$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', trim($uri, '/'));

switch ($parts[0]) {
    case '':
        // Afficher la page d'accueil
        HomeController::index();
        break;
    case 'login':

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            LoginController::login();
        } else {
            LoginController::index();
        }
        break;
    case 'logout':  
        LoginController::logout();
        break;
    default:
        // Afficher une page d'erreur 404
        header('HTTP/1.1 404 Not Found');
        include '../app/views/404.php';
        exit;
}
