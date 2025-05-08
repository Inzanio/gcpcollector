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
                            <h5 class="card-title">LISTE DES OBJECTIFS</h5>      
                            <a href="/ajouter-objectif" type="button" class="btn btn-primary"><i class="bi bi-plus"></i> Ajouter </a>                                   
                            <p></p> 
                            <!-- Table with stripped rows -->
    
                             <div class="col-12">       
                                <div class="card recent-objectifs">
                                    <div class="card-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Libelle</th>
                                                    <th>Cible</th>
                                                    <th>Valeur</th>
                                                    <th>Valeur Faite</th>
                                                    <th>Atteint</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($objectifs as $objectif): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($objectif->getLibelle()) ?></td>
                                                        <td><?= htmlspecialchars($objectif->getCible()) ?></td>
                                                        <td><?= htmlspecialchars($objectif->getValeur()) ?></td>
                                                        <td><?= htmlspecialchars($objectif->getValeurFaite()) ?></td>
                                                        <td><?= htmlspecialchars(($objectif->getAtteint())?"Oui" :"Non") ?></td>
                                                        <td>
                                                            <a href="editer-objectif?id=<?= urlencode($objectif->getDocId() ?? '') ?>" 
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

