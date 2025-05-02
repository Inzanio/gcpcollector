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
                            <h5 class="card-title">LISTE DES AGENCES</h5>      
                            <a href="/forms/ajouter-agence.php" type="button" class="btn btn-primary"><i class="bi bi-plus"></i> Ajouter </a>                                   
                            <p></p> 
                            <!-- Table with stripped rows -->
    
                             <div class="col-12">       
                                <div class="card recent-agences">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Nom</th>
                                                    <th>Lieu</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($agences as $agence): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($agence->getCode()) ?></td>
                                                        <td><?= htmlspecialchars($agence->getNom()) ?></td>
                                                        <td><?= htmlspecialchars($agence->Lieu()) ?></td>
                                                        <td>
                                                            <a href="/forms/modifier-agence.php?id=<?= urlencode($agence->getDocId() ?? '') ?>" 
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
                        </div>          
                    </div>  
                </div>
            </div>
        </section>
    </main><!-- End #main -->


    <!-- ======= Footer ======= -->     
    <?php
    require_once("footer.php");         
    ?>          
    <!-- End Footer --> 

</html>                                                                                                     

