<?php
//require_once("routes.php");
session_start();
//var_dump($_SESSION['user_role']);
if (!isset($_SESSION['user_id'])) header('Location: /login');
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
    require_once("../models/Superviseur.php");
    $prospect = new Prospect(
        $nom,
        $prenom,
        $dateNaissance,
        [$telephone],
        "",
        $profession,
        $produitsInteresse,
        $connaissanceBanque
    );

    // Configuration des propriétés supplémentaires du prospect
    $prospect->setIdAgentProspecteur($_SESSION['user_id']);
    $prospect->setCommentaire($commentaire);
    $prospect->setEmail($email);
    $prospect->setGenre($genre);

    // Enregistrement du prospect
    // var_dump($prospect);

    //var_dump($prospect->toArray());
    $result = ProspectService::createProspect($prospect);
    // Traitement du résultat
    if (!$result) {
        $error_message = "Erreur lors de l'enregistrement du prospect.";
    } else {

        $error_message = "Superviseur enregistré avec succès.";
        // Redirection ou autre action après l'enregistrement réussi
        header("Location: /gestionSuperviseurs.php"); // redirection vers la liste des prospects
        exit();
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
                <h5 class="card-title">Enregistrement d'un Superviseur</h5>

                <!-- Floating Labels Form -->
                <form class="row g-3" action="" method="POST">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="nom" type="text" class="form-control" id="floatingName" placeholder="Nom du Superviseur" required>
                            <label for="floatingName">Nom</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="prenom" type="text" class="form-control" id="floatingPrenom" placeholder="Prénom du Superviseur" required>
                            <label for="floatingPrenom">Prénom</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="email" type="email" class="form-control" id="floatingEmail" placeholder="Email du Superviseur" required>
                            <label for="floatingEmail">Email professionnel</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateNaissance" type="date" class="form-control" id="floatingDateNaissance" placeholder="Date de naissance" required>
                            <label for="floatingDateNaissance">Date de naissance</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="telephone" type="tel" class="form-control" id="floatingTelephone" placeholder="Téléphone" required>
                            <label for="floatingTelephone">Téléphone</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateEmbauche" type="date" class="form-control" id="floatingDateEmbauche" placeholder="Date d'embauche" required>
                            <label for="floatingDateEmbauche">Date d'embauche</label>
                        </div>
                    </div>
                    
                    <?php
                    $roles = [
                        "Superviseur Regional" => "Superviseur Régional",
                        "Superviseur National" => "Superviseur National",
                        "Responsable d'agence" => "Responsable d'agence",
                        "Directeur Adjoint" => "Directeur Adjoint",
                        "Directeur" => "Directeur"
                    ];
                    ?>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="role" class="form-select" id="floatingRole" required>
                                <option value="" disabled selected>Sélectionner un rôle</option>
                                <?php foreach ($roles as $value => $text) : ?>
                                    <option value="<?php echo $value; ?>"><?php echo $text; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="floatingRole">Rôle dans l'organisation</label>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="idAgence" type="text" class="form-control" id="floatingAgence" placeholder="ID Agence">
                            <label for="floatingAgence">ID Agence d'affectation</label>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea name="adresse" class="form-control" placeholder="Adresse" id="floatingAdresse" style="height: 100px;"></textarea>
                            <label for="floatingAdresse">Adresse complète</label>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-check">
                            <input name="estActif" class="form-check-input" type="checkbox" id="estActif" checked>
                            <label class="form-check-label" for="estActif">Superviseur actif</label>
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