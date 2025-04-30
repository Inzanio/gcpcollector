<?php
//require_once("routes.php");
session_start();
//var_dump($_SESSION['user_role']);
if (!isset($_SESSION['user_role'])) header('Location: /login');
//   if ( $_SESSION['user_role'] != "agent") {
//       header('Location: /login');
//       exit();
//   }

// Fonction pour récupérer les prospects depuis Firebase
require_once "db.php";
require_once("./models/prospect.php");
if ($_SESSION['user_role'] == ROLE_AGENT) {
    $prospects = ProspectService::getAllProspects($idAgentProspecteur = $_SESSION['user_id'], $idAgence = $_SESSION['user_agence_id']);
}
if ($_SESSION['user_role'] == ROLE_SUPERVISEUR) {
    $prospects = ProspectService::getAllProspects($idAgentProspecteur = null, $idAgence = $_SESSION['user_agence_id']);
}
if ($_SESSION['user_role'] == ROLE_ADMIN) {
    $prospects = ProspectService::getAllProspects($idAgentProspecteur = null, $idAgence = null);
}
//var_dump($prospects);
?>
<!DOCTYPE html>
<html lang="en">

<?php
require_once("pages/head.php");
?>

<body>


    <!-- ======= Header ======= -->
    <?php
    require_once("pages/header.php");
    ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php

    require_once("pages/sidebar.php");
    ?>
    <!-- End Sidebar-->

    <!-- ======= Main ======= -->
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">LISTE DES PROSPECTS</h5>
                            <a href="/forms/ajouter-prospect.php" type="button" class="btn btn-primary"><i class="bi bi-plus"></i> Ajouter </a>
                            <p></p>

                            <!-- Table with stripped rows -->

                            <div class="col-12">
                                <div class="card recent-prospects">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Profession</th>
                                                    <th>Numéro Téléphone</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($prospects as $prospect): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($prospect->getNom()) ?></td>
                                                        <td><?= htmlspecialchars($prospect->getProfession()) ?></td>
                                                        <td><?= htmlspecialchars($prospect->getTelephone()[0]) ?></td>
                                                        <td>
                                                            <a href="/forms/modifier-prospect.php?id=<?= urlencode($prospect->getDocId() ?? '') ?>"
                                                                class="btn btn-outline-warning">
                                                                <i class="bi bi-pencil me-2"></i>Modifier
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php
    require_once("pages/footer.php");
    ?>
    <!-- End Footer -->

</body>

</html>