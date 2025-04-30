<?php

    require_once(__DIR__ . '/../config.php');

    $currentUri = $_SERVER['REQUEST_URI'];
    $dashboardActivity = ($currentUri === '/') ? 'active' : 'collapsed';

    $gestProspectActivity = (strpos(strtolower($currentUri), "prospect")) ? 'active' : 'collapsed';
    //$gestProspectActivity = (strpos($currentUri, "rospect")) ? 'active' : 'collapsed';

    $performancesActivity = ($currentUri === '/performances.php') ? 'active' : 'collapsed';

    $gestAgentsActivity = ($currentUri === '/agents.php') ? 'active' : 'collapsed';

    $gestSuperviseursActivity = (strpos(strtolower($currentUri), "superviseur")) ? 'active' : 'collapsed';

    $gestAgencesActivity = (strpos(strtolower($currentUri), "agence")) ? 'active' : 'collapsed';

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

         <!-- Menu pour les AGENTS -->
        <?php if ($_SESSION['user_role'] === ROLE_AGENT): ?>
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

        <?php endif; ?>
           
        <!-- Menu pour les SUPERVISEURS -->
        <?php if ($_SESSION['user_role'] === ROLE_SUPERVISEUR): ?>
            <!-- Gestion des agents -->
            <li class="nav-item">
                <a class="nav-link <?php echo $gestAgentsActivity; ?>" href="">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Gérer les agents</span>
                </a>
            </li>

            <!-- Performances de l'agent -->
            <li class="nav-item">
                <a class="nav-link <?php echo $performancesActivity; ?>" href="">
                    <i class="bi bi-graph-up"></i>
                    <span>Performances des agents</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- Menu pour les ADMINISTRATEURS -->
        <?php if ($_SESSION['user_role'] === ROLE_ADMIN): ?>
            <!-- Gestion des superviseurs -->
            <li class="nav-item">
                <a class="nav-link <?php echo $gestSuperviseursActivity; ?>" href="">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Gérer les superviseurs</span>
                </a>
            </li>

            <!-- Gestion des agences -->
            <li class="nav-item">
                <a class="nav-link <?php echo $gestAgencesActivity; ?>" href="">
                    <i class="bi bi-building"></i>
                    <span>Gérer les agences</span>
                </a>
            </li>
        <?php endif; ?>

         <!-- Séparateur (commun à tous) -->
         <li class="nav-heading">Compte</li>

        <!-- Déconnexion (commun à tous) -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>
        </li>

    </ul>
</aside>