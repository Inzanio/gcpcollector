<!DOCTYPE html>
<html lang="fr">

<?php
require_once("../app/views/head.php");
?>

<body>

    <!-- ======= Header ======= -->
    <?php
    require_once("../app/views/header.php");
    ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php
    require_once("../app/views/sidebar.php");
    ?>
    <!-- End Sidebar-->

    <!-- ======= Main ======= -->
    <main id="main" class="main">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ajouter un agent</h5>
                <form class="row g-3" method="POST" action="">

                    <!-- Section 2 : Identité -->
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" <?php echo isset($nom) ? "value=\"$nom\"" : ''; ?> required>
                    </div>

                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" <?php echo isset($prenom) ? "value=\"$prenom\"" : ''; ?> required>
                    </div>

                    <!-- Section 3 : Coordonnées -->
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" <?php echo isset($telephone) ? "value=\"$telephone\"" : ''; ?> required>
                    </div>

                    <div class="col-md-6">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="date_naissance" name="dateNaissance" <?php echo isset($dateNaissance) ? 'value="' . $dateNaissance->format('Y-m-d') . '"' : ''; ?> required>
                    </div>
                    <!-- Section 1 : Informations de base -->
                    <div class="col-md-6">
                        <label for="matricule" class="form-label">Matricule</label>
                        <input type="text" class="form-control" id="matricule" name="matricule" <?php echo isset($matricule) ? "value=\"$matricule\"" : ''; ?> required>
                    </div>
                    <!-- Section 4 : Identifiants -->
                    <div class="col-md-6">
                        <label for="login" class="form-label">Login</label>
                        <input type="text" class="form-control" id="login" name="login" <?php echo isset($login) ? "value=\"$login\"" : ''; ?> required>
                    </div>

                    <div class="col-md-6">
                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="password" required>
                        <div class="form-text">8 caractères minimum, avec majuscule et chiffre</div>
                    </div>

                    <div class="col-md-6">
                        <label for="confirmation_mdp" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="confirmation_mdp" name="confirmationpassword" required>
                    </div>
                    <?php
                    if (isset($error_message)) {
                        check_error_message($error_message);
                    }
                    ?>
                    <!-- Bouton de soumission -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php
    require_once("../app/views/footer.php");
    ?>
    <!-- End Footer -->

</body>

</html>