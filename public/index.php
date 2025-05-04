<?php
require_once '../vendor/autoload.php';
require_once '../config/constants.php';

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ProspectController;
use App\Controllers\SuperviseurController;
use App\Controllers\AgenceController;
use App\Services\AgenceServices;
use App\Services\ProspectServices;
use App\Services\UtilisateurServices;

function check_id()
{
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    if (!$id) {
?>
        <div class="alert alert-danger">
            <?php echo "Il semblerait qu'il manque un paramètre inmportant pour que cette requête aboutissent (id)"; ?>
        </div>
    <?php
        exit();
    }
    return $id;
}

function check_element($element)
{
    if (!$element) {
    ?>
        <div class="alert alert-danger">
            <?php echo "Aïe, Aïe il semblerait que le prospect que vous souhaitez modifier n'existe pas"; ?>
        </div>
    <?php
        exit();
    }
}

function check_error_message($error_message = null)
{
    /**<?php if (!empty($error_message)) : ?>
        <div class="alert alert-<?php echo $result ? 'success' : 'danger'; ?>">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>**/


    ?>
    <p class="text-center small text-danger"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php

}

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$parts = explode('/', trim($path, '/'));
//echo($parts[0]);
switch ($parts[0]) {
    case '':
        LoginController::must_logged_in();
        // Si l'utilisateur est connecté, redirigez vers la page d'accueil
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
    case "prospects":
        LoginController::must_logged_in();
        ProspectController::index();
        break;
    case "ajouter-prospect":
        LoginController::must_logged_in();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ProspectController::create();
        } else {
            include '../app/views/forms/ajouter-prospect.php';
        }
        break;
    case "editer-prospect":
        LoginController::must_logged_in();
        $id = check_id();

        $prospect = ProspectServices::getProspectById($id);
        check_element($prospect);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ProspectController::update($prospect);
        } else {
            include '../app/views/forms/modifier-prospect.php';
        }

        break;
    case "superviseurs":
        LoginController::must_logged_in();
        SuperviseurController::index();
        break;
    case "agences":
        LoginController::must_logged_in();
        AgenceController::index();
        break;
    case "ajouter-superviseur":
        LoginController::must_logged_in();
        $agences = AgenceServices::getAllAgences();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            SuperviseurController::create();
        } else {
            include '../app/views/forms/ajouter-superviseur.php';
        }
        break;
    case "editer-superviseur":
        LoginController::must_logged_in();
        $id = check_id();
        $superviseur = UtilisateurServices::getUtilisateurById($id);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            SuperviseurController::update($superviseur);
        } else {
            include '../app/views/forms/ajouter-superviseur.php';
        }
        break;
    case "ajouter-agence":
        LoginController::must_logged_in();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            AgenceController::create();
        } else {
            include '../app/views/forms/ajouter-agence.php';
        }
        break;
    case "editer-agence":
        LoginController::must_logged_in();
        $id = check_id();

        $agence = AgenceServices::getAgenceById($id);
        check_element($agence);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            AgenceController::update($agence);
        } else {
            include '../app/views/forms/modifier-agence.php';
        }
        break;

    case "comptes":
        LoginController::must_logged_in();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ProspectController::create();
        } else {
            ProspectController::showPropspectAccountWaitingForOpening(null, null, null, null);
            //include '../app/views/forms/valider-compte.php';
        }
        break;

    case "unittests":
        include '../test_firestore.php';
        break;
    default:
        // Afficher une page d'erreur 404
        header('HTTP/1.1 404 Not Found');
        include '../app/views/404.php';
        exit;
}
