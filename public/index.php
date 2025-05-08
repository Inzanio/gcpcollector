<?php
require_once '../vendor/autoload.php';
require_once '../config/constants.php';

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ProspectController;
use App\Controllers\SuperviseurController;
use App\Controllers\AgenceController;
use App\Controllers\AgentController;
use App\Controllers\CampagneController;
use App\Controllers\ObjectifController;
use App\Services\AgenceServices;
use App\Services\CampagneServices;
use App\Services\ObjectifServices;
use App\Services\ProspectServices;
use App\Services\UtilisateurServices;

use MrShan0\PHPFirestore\Fields\FireStoreTimestamp;

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

function showEditableDateValue(FireStoreTimestamp $dateFirestore)
{
    $value = (new Datetime(($dateFirestore->parseValue())))->format('Y-m-d');
    echo 'value="' . $value . '"';
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
    case "agents":
        LoginController::must_logged_in();
        AgentController::index();
        break;
    case "ajouter-agent":
        LoginController::must_logged_in();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            AgentController::create();
        } else {
            include '../app/views/forms/ajouter-agent.php';
        }
        break;
    case "editer-agent":
        LoginController::must_logged_in();
        $id = check_id();
        $agent = UtilisateurServices::getUtilisateurById($id);
        check_element($agent);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            AgentController::update($agent);
        } else {
            include '../app/views/forms/modifier-agent.php';
        }
        break;
    case "campagnes":
        LoginController::must_logged_in();
        CampagneController::index();
        break;
    case "ajouter-campagne":
        LoginController::must_logged_in();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            CampagneController::create();
        } else {
            include '../app/views/forms/ajouter-campagne.php';
        }
        break;
    case "editer-campagne":
        LoginController::must_logged_in();
        $id = check_id();
        $campagne = CampagneServices::getCampagneById($id);
        check_element($campagne);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            CampagneController::update($campagne);
        } else {

            include '../app/views/forms/modifier-campagne.php';
        }
        break;
    case "objectifs":
        LoginController::must_logged_in();
        ObjectifController::index();
        break;
    case "ajouter-objectif":
        LoginController::must_logged_in();
        if (isset($_GET['idCampagne'])) {
            $idCampagne = $_GET['idCampagne'];
            $campagnes[] = CampagneServices::getCampagneById($idCampagne);
        } else {
            $campagnes = CampagneServices::getAllCampagnes();
        }
        if ($_SESSION["user_role"] == ROLE_ADMIN) {
            $agences = AgenceServices::getAllAgences();
        } else {
            $agents = UtilisateurServices::getAllUtilisateurs($_SESSION["user_agence_id"], ROLE_AGENT);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ObjectifController::create();
        } else {
            include '../app/views/forms/ajouter-objectif.php';
        }
        break;
    case "editer-objectif":
        LoginController::must_logged_in();
        $id = check_id();
        $objectif = ObjectifServices::getObjectifById($id);
        
        check_element($objectif);
        $campagnes = CampagneServices::getAllCampagnes();
        if ($_SESSION["user_role"] == ROLE_ADMIN) {
            $agences = AgenceServices::getAllAgences();
        } else {
            $agents = UtilisateurServices::getAllUtilisateurs($_SESSION["user_agence_id"], ROLE_AGENT);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ObjectifController::update($objectif);
        } else {

            include '../app/views/forms/modifier-objectif.php';
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
