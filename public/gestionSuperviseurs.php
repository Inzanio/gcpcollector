<?php
//require_once("routes.php");
session_start();
//var_dump($_SESSION['user_role']);
if (!isset($_SESSION['user_role'])) header('Location: /login');
//   if ( $_SESSION['user_role'] != "agent") {
//       header('Location: /login');
//       exit();
//   }

//require_once ("./models/prospect.php");
// Fonction pour récupérer les prospects depuis Firebase

// $prospects_ = ProspectService::getAllProspects();
// var_dump($prospects_);


$superviseurs = [
    [
        'nom' => 'Martin Dupont',
        'profession' => 'ABC Corp',
        'telephone' => 'Relance téléphonique'
    ],
    [
        'nom' => 'Sophie Lambert',
        'profession' => 'XYZ SA',
        'telephone' => 'Envoi contrat'
    ],
    [
        'nom' => 'Pierre Moreau',
        'profession' => '123 Industries',
        'telephone' => 'Préparation présentation'
    ]
];

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
                            <h5 class="card-title">LISTE DES SUPERVISEURS</h5>
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
                                                <?php foreach ($superviseurs as $superviseur): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($superviseur['nom']) ?></td>
                                                        <td><?= htmlspecialchars($superviseur['profession']) ?></td>
                                                        <td><?= htmlspecialchars($superviseur['telephone']) ?></td>
                                                        <td>
                                                            <a href="/forms/modifier-superviseur.php?id=<?= urlencode($superviseur['id'] ?? '') ?>" 
                                                            class="btn btn-outline-warning">
                                                                <i class="bi bi-pencil me-2"></i>Modifier
                                                            </a>
                                                            <a href="/forms/modifier-superviseur.php?id=<?= urlencode($superviseur['id'] ?? '') ?>" 
                                                            class="btn btn-outline-danger">
                                                                <i class="bi bi-pencil me-2"></i>Suspendre
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