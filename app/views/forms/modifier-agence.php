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
                <h5 class="card-title">Ajouter une agence</h5>
                <form class="row g-3" method="POST" action="">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Code de l'agence</label>
                        <input type="text" class="form-control" id="inputEmail4" name="code" value="<?php echo $agence->getCode(); ?>" required disabled >
                    </div>          
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="inputPassword4" name="nom" value="<?php echo $agence->getNom(); ?>" required>        
                    </div>          
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="inputPassword5" name="lieu" value="<?php echo $agence->getLieu(); ?>" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Enregister</button>         

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
