<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a class="logo d-flex align-items-center">
      <img src="<?php echo $static_files_uri; ?>/img/logo.png" alt="">
      <span class="d-none d-lg-block"><?php echo APP_NAME ?></span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <?php require_once("filters.php"); ?>
      
      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" data-bs-toggle="dropdown">
          <img src="<?php echo $static_files_uri; ?>/img/profile-img.png" alt="Profile" class="rounded-circle">
          <?php
          if ($_SESSION["user_role"] == "agent") {
            echo '<span class="d-none d-md-block dropdown-toggle ps-2">' . htmlspecialchars($_SESSION['user_prenom']) . ' ' . htmlspecialchars($_SESSION['user_nom']) . '</span>';
          } else {
            echo '<span class="d-none d-md-block dropdown-toggle ps-2" href=#>' . htmlspecialchars($_SESSION['user_prenom']) . ' ' . htmlspecialchars($_SESSION['user_nom'])  . '</span>';
          }

          ?>
        </a>

        <!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h5><?= htmlspecialchars($_SESSION['user_login']); ?></h5>
            <span><?= htmlspecialchars($_SESSION['user_role']); ?></span>
            <br>
            <h7><?= $_SESSION['user_role'] === ROLE_ADMIN ? '' : htmlspecialchars($_SESSION['user_agence_name']); ?></h7>
          </li>

        </ul>
        <!-- End Profile Dropdown Items -->
      </li>
      <!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header>