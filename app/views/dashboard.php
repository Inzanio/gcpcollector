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
        <?php
        $userRole = $_SESSION['user_role'];

        switch ($userRole) {
            case ROLE_ADMIN:
                require_once("admin/contentAdmin.php");
                break;
            case ROLE_SUPERVISEUR:
                require_once("superviseur/contentSuperviseur.php");
                break;
            case ROLE_AGENT:
                require_once("agent/contentAgent.php");
                break;
            default:
                // Gérez les cas où le rôle n'est pas reconnu
                header('Location: /login');
                break;
        }
        ?>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php
    require_once("footer.php");
    ?>
    <!-- End Footer -->

</body>

</html>