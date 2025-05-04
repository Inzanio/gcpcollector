<?php
require_once '../vendor/autoload.php';
require_once '../config/constants.php';

use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ProspectController;
use App\Controllers\SuperviseurController;

use App\Services\ProspectServices;


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
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
?>
            <div class="alert alert-danger">
                <?php echo "Il semblerait qu'il manque un paramètre inmportant pour que cette requête aboutissent (id)"; ?>
            </div>
        <?php
            exit();
        }

        $prospect = ProspectServices::getProspectById($id);

        if (!$prospect) {
        ?>
            <div class="alert alert-danger">
                <?php echo "Aïe, Aïe il semblerait que le prospect que vous souhaitez modifier n'existe pas"; ?>
            </div>
<?php
            exit();
        }
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
        include '../app/views/liste-agence.php';
        break;
    case "ajouter-superviseur":
        LoginController::must_logged_in();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ProspectController::create();
        } else {
            include '../app/views/forms/ajouter-superviseur.php';
        }
        break;
    case "ajouter-agence":
        LoginController::must_logged_in();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ProspectController::create();
        } else {
            include '../app/views/forms/ajouter-agence.php';
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
