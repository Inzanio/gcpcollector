
<!DOCTYPE html>
<html lang="en">

<?php
require_once("head.php");
?>

<body>


    <!-- ======= Header ======= -->
    <?php
    require_once("header.php");
    ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php

    require_once("sidebar.php");
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
                            <a href="/ajouter-prospect" type="button" class="btn btn-primary"><i class="bi bi-plus"></i> Ajouter </a>
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
                                                        <td ><?= htmlspecialchars($prospect->getNom()) ?></td>
                                                        <td><?= htmlspecialchars($prospect->getProfession()) ?></td>
                                                        <td><?= htmlspecialchars($prospect->getTelephone()[0]) ?></td>
                                                        <td>
                                                            <a href="/editer-prospect?id=<?= urlencode($prospect->getDocId() ?? '') ?>"
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
    require_once("footer.php");
    ?>
    <!-- End Footer -->

</body>

</html>