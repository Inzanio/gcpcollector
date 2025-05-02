<!DOCTYPE html>
<html lang="en">

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
                <h5 class="card-title">Ajouter un superviseur</h5>
                <form class="row g-3" method="POST" action="ajouter-superviseur.php">
                    <!-- Champ Nom -->
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    
                    <!-- Champ Prénom -->
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    
                    <!-- Champ Date de naissance -->
                    <div class="col-md-6">
                        <label for="date_naissance" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                    </div>
                    
                    <!-- Champ Téléphone -->
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" required>
                    </div>
                    
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