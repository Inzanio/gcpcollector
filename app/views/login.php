<!DOCTYPE html>
<html lang="en">

<?php
require_once("head.php");
?>

<body>


  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="<?php echo $static_files_uri; ?>/img/logo.png" alt="">
                  <span class="d-none d-lg-block">GCPCollector</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Connectez-vous</h5>
                    <p class="text-center small">Entrez votre login et votre mot de passe.</p>

                  </div>

                  <form method="POST" action="/login" class="row g-3 needs-validation" novalidate>

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
                      ?>
                        <p class="text-center small text-danger">Login ou mot de passe incorrect.</p>
                      <?php
                      }
                      ?>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Se connecter</button>
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
  require_once("footer.php");
  ?>

</body>

</html>