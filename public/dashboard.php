<?php
  //require_once("routes.php");
  session_start();
  //var_dump($_SESSION['user_role']);
  if (!isset($_SESSION['user_role']) ) header('Location: /login'); 
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
      <?php
      if  ($_SESSION['user_role'] == "agent"){
        require_once("db.php");
        require_once("models/prospect.php");
        require_once("pages/contentAgent.php");
      }
      //elseif($_SESSION['user_role'])
        
      ?>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
      <?php
        require_once("pages/footer.php");
      ?>
  <!-- End Footer -->

</body>

</html>