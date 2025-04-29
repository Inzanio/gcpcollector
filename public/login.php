<?php
//require_once("routes.php");
require_once("db.php");
require_once("models/utilisateur.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $login = $_POST["login"];
  $password = $_POST["password"];
  // N'oubliez pas de sécuriser les données en utilisant des méthodes telles que
  // htmlspecialchars() ou filter_var() pour éviter les attaques XSS
  $login = htmlspecialchars($login);
  $password = htmlspecialchars($password);

  // Vous pouvez ensuite utiliser ces variables pour authentifier l'utilisateur
  // par exemple, en les comparant à des valeurs stockées dans une base de données
  $login_result = Utilisateur::login($login, $password);
  //var_dump($login_result);
  if ($login_result != false) {
    //var_dump($login_result);
    session_start();
    $_SESSION['user_role'] = $login_result->getRole();
    $_SESSION['user_matricule'] = $login_result->getMatricule();
    $_SESSION['user_login'] = $login_result->getLogin();
    $_SESSION['user_id'] = $login_result->getUid();
    $_SESSION['user_nom'] = $login_result->getNom();
    $_SESSION['user_prenom'] = $login_result->getPrenom();
    //$_SESSION['user_date_naissance'] = $login_result->getDateNaissance()->format('Y-m-d');
    //var_dump($_SESSION['user_role']);
    header('Location: /');
  }


  // Authentification de l'utilisateur
  // ...
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>GCPCollector</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="./assets/img/favicon.png" rel="icon">
  <link href="./assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="./assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="./assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="./assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="./assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="./assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="./assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">GCPCollector</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Connectez-vous</h5>
                    <p class="text-center small">Entrez votre login et votre mot de passe.</p>
                    
                  </div>

                  <form method="POST" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="login" class="form-label">Login</label>
                      <div class="input-group has-validation">
                        <input type="text" name="login" class="form-control" id="login" required>
                        <div class="invalid-feedback">Entrez votre login.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mot de passe</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Entrez votre mot de passe!</div>
                      <?php 
                        
                        if (isset($login_result) && $login_result == false) {
                          //var_dump($login_result);
                            ?>
                              <p class="text-center small text-danger">Login ou mot de passe incorrect.</p>
                            <?php
                        } 
                      ?>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php
  require_once("/pages/footer.php");
  ?>

</body>

</html>