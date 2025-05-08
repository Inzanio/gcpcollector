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
                <h5 class="card-title">Ajouter un objectif</h5>
                <form class="row g-3" method="POST" action="">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select name="idCampagne" class="form-select" id="campagne">

                                <option value="" disabled selected>Libre</option>
                                <?php foreach ($campagnes as $campagne) : ?>
                                    <option value="<?php echo $campagne->getDocId(); ?>" <?php echo ($objectif->getIdCampagne() == $campagne->getDocId()) ? 'selected' : ''; ?>>
                                        <?php echo $campagne->getLibelle(); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                            <label for="campagne">Campagne</label>
                        </div>
                    </div>
                    <?php if ($_SESSION["user_role"] == ROLE_ADMIN) : ?>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="idAgence" class="form-select" id="agence">
                                    <option value="" disabled selected>Global</option>
                                    <?php foreach ($agences as $agence) : ?>
                                        <option value="<?php echo $agence->getDocId(); ?>" <?php echo ($objectif->getIdAgence() == $agence->getDocId()) ? 'selected' : ''; ?>>
                                            <?php echo $agence->getNom(); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="agence">Agence</label>
                            </div>
                        </div>
                    <?php elseif ($_SESSION["user_role"] == ROLE_SUPERVISEUR) : ?>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select name="idAgent" class="form-select" id="agent">
                                    <?php foreach ($agents as $agent) : ?>
                                        <option value="<?php echo $agent->getDocId(); ?>" <?php echo ($objectif->getIdAgent() == $agent->getDocId()) ? 'selected' : ''; ?>>
                                            <?php echo $agent->getNom(); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="agent">Agent</label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="libelle" name="libelle" value="<?php echo $objectif->getLibelle(); ?>" required>

                            <label for="libelle" class="form-label">Libellé de l'objectif</label>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="valeur" name="valeur" value="<?php echo $objectif->getValeur(); ?>" required>

                            <label for="valeur" class="form-label">Valeur de l'objectif</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <select name="cible" class="form-select" id="cible">
                                <!-- <option value="" disabled selected>Libre</option> -->
                                <?php foreach (CIBLES_OBJECTIFS as $cible) : ?>
                                    <option value="<?php echo $cible; ?>" <?php echo ($objectif->getCible() == $cible) ? 'selected' : ''; ?>>
                                        <?php echo $cible; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="cible">Cible</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateDebut" type="date" class="form-control" id="floatingDateDebut" placeholder="Date de Debut" <?php showEditableDateValue($objectif->getDateDebut()) ?> required>
                            <label for="floatingDateDebut">Date de Début</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateFin" type="date" class="form-control" id="floatingDateDebut" placeholder="Date de Fin" <?php showEditableDateValue($objectif->getDateFin()) ?> required>
                            <label for="floatingDateDebut">Date de Fin</label>
                        </div>
                    </div>

                    <?php
                    if (isset($error_message)) {
                        check_error_message($error_message);
                    }
                    ?>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Modifier</button>

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