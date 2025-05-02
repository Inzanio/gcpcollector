

<!DOCTYPE html>
<html lang="en">

<?php
    require_once("head.php");
?>

<body>

  <main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>404</h1>
        <h2>Oups ! Il semblerait que la page que vous ayez demandé n'existe point... </h2>
        <a class="btn" href="/">Retourner au dashboard</a>
        <img src="<?php echo $static_files_uri; ?>/img/not-found.svg" class="img-fluid py-5" alt="Page Not Found">
      </section>

    </div>
  </main><!-- End #main -->

    <?php
        require_once("footer.php");
      ?>

</body>

</html>