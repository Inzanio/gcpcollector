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
                <h5 class="card-title">Ajouter une campagne</h5>
                <form class="row g-3" method="POST" action="">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Libellé de la campagne</label>
                        <input type="text" class="form-control" id="inputEmail4" name="libelle" required>
                    </div>                  
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="inputPassword5" name="lieu" required>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateDebut" type="date" class="form-control" id="floatingDateDebut" placeholder="Date de Debut" required>
                            <label for="floatingDateNaissance">Date de Début</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input name="dateFin" type="date" class="form-control" id="floatingDateFin" placeholder="Date de Fin" required>
                            <label for="floatingDateNaissance">Date de Fin</label>
                        </div>
                    </div>
                    <?php
                    if (isset($error_message)) {
                        check_error_message($error_message);
                    }
                    ?>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Ajouter</button>         

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
