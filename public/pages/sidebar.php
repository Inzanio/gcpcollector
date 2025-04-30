<?php
    $currentUri = $_SERVER['REQUEST_URI'];
    $dashboardActivity = ($currentUri === '/') ? 'active' : 'collapsed';

    $gestProspectActivity = (strpos(strtolower($currentUri), "prospect")) ? 'active' : 'collapsed';
    //$gestProspectActivity = (strpos($currentUri, "rospect")) ? 'active' : 'collapsed';
    $performancesActivity = ($currentUri === '/performances.php') ? 'active' : 'collapsed';


?>


<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Tableau de bord (commun à tous)  -->
        <li class="nav-item">
            
            <a class="nav-link <?php echo $dashboardActivity; ?>" href="/">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord </span>
            </a>
        </li>

            <!-- Prospects -->
        <li class="nav-item">
            <a class="nav-link <?php echo $gestProspectActivity; ?>" href="/gestionProspects.php">
                <i class="bi bi-people-fill"></i>
                <span>Gestion des prospects</span>
            </a>
        </li>

         <!-- Performances -->
        <li class="nav-item">
            <a class="nav-link <?php echo $performancesActivity; ?>" href="">
                <i class="bi bi-graph-up"></i>
                <span>Mes performances</span>
            </a>
        </li>

        <!-- Séparateur -->
        <li class="nav-heading">Compte</li>

        <!-- Déconnexion -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>
        </li>

    </ul>
</aside>