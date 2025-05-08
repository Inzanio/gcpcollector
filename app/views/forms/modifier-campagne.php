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
                <h5 class="card-title">Modifier une campagne</h5>
                <form class="row g-3" method="POST" action="">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Libellé de la campagne</label>
                        <input type="text" class="form-control" id="inputEmail4" name="libelle" value="<?php echo $campagne->getLibelle(); ?>" required>
                    </div>                  
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="inputPassword5" name="lieu" value="<?php echo $campagne->getLieu(); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateDebut" type="date" class="form-control" id="floatingDateDebut" placeholder="Date de Debut"  <?php showEditableDateValue($campagne->getDateDebut()) ?>   required>
                            <label for="floatingDateNaissance">Date de Début</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateFin" type="date" class="form-control" id="floatingDateFin" placeholder="Date de Fin" <?php showEditableDateValue($campagne->getDateFin()) ?> required>
                            <label for="floatingDateNaissance">Date de Fin</label>
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
