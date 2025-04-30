<?php
//require_once("routes.php");
session_start();
//var_dump($_SESSION['user_role']);
if (!isset($_SESSION['user_id'])) header('Location: /login');
?>

<?php
$id = isset($_GET['id']) ?$_GET['id'] : null;
if (!$id) {
?>
    <div class="alert alert-danger">
        <?php echo "Il semblerait qu'il manque un paramçtre inmportant pour que cette requête aboutissent (id)"; ?>
    </div>
<?php // Redirect to an error page if ID is missing
    exit();
}

// Fetch prospect details using the ID
require_once("../db.php");
require_once("../models/prospect.php");
$prospect = ProspectService::getProspectById($id);

if (!$prospect) {
    ?>
    <div class="alert alert-danger">
        <?php echo "Aïe, Aïe il semblerait que le prospect que vous souhaitez modifier n'existe pas"; ?>
    </div>
<?php
    exit();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
    $prenom = trim(htmlspecialchars($_POST['prenom'] ?? ''));
    $dateNaissance = !empty($_POST['dateNaissance']) ? new DateTime($_POST['dateNaissance']) : null;
    $telephone = trim(htmlspecialchars($_POST['telephone'] ?? ''));
    $profession = trim(htmlspecialchars($_POST['profession'] ?? ''));
    $connaissanceBanque = isset($_POST['connaissanceBanque']) ? true : false;
    $produitsInteresse = $_POST['produitsInteresse'] ?? [];
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $commentaire = trim(htmlspecialchars($_POST['commentaire'] ?? ''));
    $genre = trim(htmlspecialchars($_POST['genre'] ?? ''));

    // Création d'un objet Prospect
    require_once("../models/Prospect.php");

    $prospect->setNom($nom);
    $prospect->setPrenom($prenom);
    $prospect->setDateNaissance($dateNaissance);
    $prospect->removeTelephone($prospect->getTelephone()[0]); // Remove the old telephone number    
    $prospect->addTelephone($telephone);
    $prospect->setProfession($profession);
    $prospect->setProduitsInteresse($produitsInteresse);
    $prospect->setConnaissanceBanque($connaissanceBanque);

    // Configuration des propriétés supplémentaires du prospect
    //$prospect->setIdAgentProspecteur($_SESSION['user_id']);
    $prospect->setCommentaire($commentaire);
    $prospect->setEmail($email);
    $prospect->setGenre($genre);

    // Enregistrement du prospect
    //var_dump($prospect);

    // var_dump($prospect->toArray());
    $result = ProspectService::updateProspect($id,$prospect);
    //var_dump($result);
    // Traitement du résultat
    if (!$result) {
        $error_message = "Erreur lors de l'enregistrement du prospect.";
    } else {
        $error_message = "Prospect Modifié avec succès.";
        // Redirection ou autre action après l'enregistrement réussi
        // header("Location: /success.php"); // Exemple de redirection
        // exit();
    } 
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
require_once("../pages/head.php");
?>

<body>


    <!-- ======= Header ======= -->
    <?php
    require_once("../pages/header.php");
    ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php
    require_once("../pages/sidebar.php");
    ?>
    <!-- End Sidebar-->

    <!-- ======= Main ======= -->
    <main id="main" class="main">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Modification d'un Prospect</h5>

                <!-- Floating Labels Form -->
                <form class="row g-3" action="" method="POST">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="nom" type="text" class="form-control" id="floatingName" placeholder="Nom du Prospect" value="<?php echo $prospect->getNom(); ?>">
                            <label for="floatingName">Nom</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="prenom" type="text" class="form-control" id="floatingName" placeholder="Prenom du Prospect" value="<?php echo $prospect->getPrenom(); ?>">
                            <label for="floatingName">Prenom</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="email" type="email" class="form-control" id="floatingEmail" placeholder="Email du Prospect" value="<?php echo $prospect->getEmail(); ?>">
                            <label for="floatingEmail">Email</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateNaissance" type="date" class="form-control" id="floatingDateNaissance" placeholder="Date de naissance" value="<?php echo $prospect->getDateNaissance(); ?>" >
                            <label for="floatingDateNaissance">Date de naissance</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="telephone" type="text" class="form-control" id="floatingTelephone" placeholder="Téléphone du Prospect" name="telephone" value="<?php echo $prospect->getTelephone()[0]; ?>">
                            <label for="floatingTelephone">Téléphone</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="genre" class="form-select" id="floatingGenre">
                                <option value="">Sélectionner le genre</option>
                                <option value="Homme" <?php echo $prospect->getGenre() === 'Homme' ? 'selected' : ''; ?>>Homme</option>
                                <option value="Femme" <?php echo $prospect->getGenre() === 'Femme' ? 'selected' : ''; ?>>Femme</option>
                            </select>
                            <label for="floatingGenre">Genre</label>
                        </div>
                    </div>
                    <?php
                    $options = [
                        "Commerçant" => "Commerçant",
                        "Entrepreneur" => "Entrepreneur",
                        "Cadre" => "Cadre",
                        "Employé" => "Employé",
                        "Étudiant" => "Étudiant",
                        "Retraité" => "Retraité",
                        "Autre" => "Autre"
                    ];
                    ?>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select name="profession" class="form-select" aria-label="Default select example">
                                <option selected="">Open this select menu</option>
                                <?php foreach ($options as $value => $text) : ?>
                                    <option value="<?php echo $value; ?>" <?php echo $prospect->getProfession() === $value ? 'selected' : ''; ?>><?php echo $text; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="profession">Profession</label>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" aria-label="State">
                                <option selected="">New York</option>
                                <option value="1">Oregon</option>
                                <option value="2">DC</option>
                            </select>
                            <label for="floatingSelect">State</label>
                        </div>
                    </div> -->
                    <div class="col-md-2">
                        <div class="form-floating">
                            <input name="connaissanceBanque" class="form-check-input" type="checkbox" id="connaissanceBanque" <?php echo $prospect->getConnaissanceBanque() ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="connaissanceBanque">Connaissance de la banque</label>
                        </div>
                    </div>
                    <?php
                    $produits = [
                        "Épargne" => "Épargne",
                        "Investissement" => "Investissement",
                        "Crédit" => "Crédit",
                        "Assurance" => "Assurance",
                        "Gestion de patrimoine" => "Gestion de patrimoine"
                    ];
                    ?>
                    <div class="col-md-12">
                        <label>Produits intéressés</label>
                        <?php foreach ($produits as $value => $text) : ?>
                            <div class="form-check">
                                <input name="produitsInteresse[]" class="form-check-input" type="checkbox" id="<?php echo $value; ?>" value="<?php echo $value; ?>" <?php echo in_array($value, $prospect->getProduitsInteresse()) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="<?php echo $value; ?>"><?php echo $text; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea name="commentaire" class="form-control" placeholder="Commentaire" id="floatingCommentaire" style="height: 100px;"><?php echo $prospect->getCommentaire(); ?></textarea>
                            <label for="floatingCommentaire">Commentaire</label>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <button type="reset" class="btn btn-secondary">Réinitialiser</button>
                    </div>

                </form>
                <!-- End floating Labels Form -->
                <?php if (!empty($error_message)) : ?>
                    <div class="alert alert-<?php echo $result ? 'success' : 'danger'; ?>">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php
    require_once("../pages/footer.php");
    ?>
    <!-- End Footer -->

</body>

</html>