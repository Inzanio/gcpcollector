<?php
  //require_once("routes.php");
  session_start();
  //var_dump($_SESSION['user_role']);
  if (!isset($_SESSION['user_role']) ) header('Location: /login'); 
//   if ( $_SESSION['user_role'] != "agent") {
//       header('Location: /login');
//       exit();
//   }
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
    <div class="row">
            <div class="col-md-6">
                <a href="forms/ajouter-prospect.php" class="text-decoration-none text-dark">
                    <div class="card h-100">
                        <img src="./assets/img/card.jpg" class="card-img-top" alt="...">
                        <div class="card-img-overlay">
                            <h5 class="card-title">Ajouter un Prospect</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="/" class="text-decoration-none text-dark">
                    <div class="card h-100">
                        <img src="./assets/img/card.jpg" class="card-img-top" alt="...">
                        <div class="card-img-overlay">
                            <h5 class="card-title">Modifier Un Prospect</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
      <?php
        require_once("pages/footer.php");
      ?>
  <!-- End Footer -->

</body>

</html>