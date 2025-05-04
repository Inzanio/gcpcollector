<?php

$currentUri = $_SERVER['REQUEST_URI'];
$dashboardActivity = ($currentUri === '/') ? 'active' : 'collapsed';

$gestProspectActivity = (strpos(strtolower($currentUri), "prospect")) ? 'active' : 'collapsed';
//$gestProspectActivity = (strpos($currentUri, "rospect")) ? 'active' : 'collapsed';

$performancesActivity = ($currentUri === '/performances.php') ? 'active' : 'collapsed';

$gestAgentsActivity = ($currentUri === '/agents.php') ? 'active' : 'collapsed';

$gestSuperviseursActivity = (strpos(strtolower($currentUri), "superviseur")) ? 'active' : 'collapsed';

$gestAgencesActivity = (strpos(strtolower($currentUri), "agence")) ? 'active' : 'collapsed';

$validerCompteActivity = (strpos(strtolower($currentUri), "compte")) ? 'active' : 'collapsed';

$campaignsActivity = (strpos(strtolower($currentUri), "campagne")) ? 'active' : 'collapsed';
$newCampaignActivity = (strpos(strtolower($currentUri), "campagne/nouvelle")) ? 'active' : 'collapsed';
$listCampaignActivity = (strpos(strtolower($currentUri), "campagne/liste")) ? 'active' : 'collapsed';
$reportsCampaignActivity = (strpos(strtolower($currentUri), "campagne/rapports")) ? 'active' : 'collapsed';

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
                <a class="nav-link <?php echo $gestProspectActivity; ?>" href="/prospects">
                    <i class="bi bi-people-fill"></i>
                    <span>Gestion des prospects</span>
                </a>
            </li>

            <!-- Performances -->
            <!-- <li class="nav-item">
                <a class="nav-link <?php echo $performancesActivity; ?>" href="">
                    <i class="bi bi-graph-up"></i>
                    <span>Mes performances</span>
                </a>
            </li> -->

        <?php endif; ?>

        <!-- Menu pour les SUPERVISEURS -->
        <?php if ($_SESSION['user_role'] === ROLE_SUPERVISEUR): ?>
            <!-- Gestion des agents -->
            <li class="nav-item">
                <a class="nav-link <?php echo $gestAgentsActivity; ?>" href="/agents">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Gérer les agents</span>
                </a>
            </li>

            <!-- Performances de l'agent -->
            <!-- <li class="nav-item">
                <a class="nav-link <?php echo $performancesActivity; ?>" href="">
                    <i class="bi bi-graph-up"></i>
                    <span>Performances des agents</span>
                </a>
            </li> -->
        <?php endif; ?>

        <!-- Menu pour les ADMINISTRATEURS -->
        <?php if ($_SESSION['user_role'] === ROLE_ADMIN): ?>
            <!-- Gestion des agences -->
            <li class="nav-item">
                <a class="nav-link <?php echo $gestAgencesActivity; ?>" href="/agences">
                    <i class="bi bi-building"></i>
                    <span>Gérer les agences</span>
                </a>
            </li>
            <!-- Gestion des superviseurs -->
            <li class="nav-item">
                <a class="nav-link <?php echo $gestSuperviseursActivity; ?>" href="/superviseurs">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Gérer les superviseurs</span>
                </a>
            </li>

        <?php endif; ?>

        <?php if ($_SESSION['user_role'] !== ROLE_AGENT): ?>
            <!-- Validation ouverture compte -->
            <li class="nav-item">
                <a class="nav-link <?php echo $validerCompteActivity; ?>" href="/comptes">
                    <i class="bi bi-shield-check"></i>
                    <span>Ouverture de Compte</span>
                </a>
            </li>

            <!-- Campagnes -->
            <li class="nav-item">
                <a class="nav-link collapsed <?php echo $campaignsActivity; ?>" data-bs-toggle="collapse" href="#campaignsCollapse">
                    <i class="bi bi-megaphone"></i>
                    <span>Campagnes</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div id="campaignsCollapse" class="collapse">
                    <ul class="nav-content">
                        <li>
                            <a href="/campagnes/nouvelle" class="<?php echo $newCampaignActivity; ?>">
                                <i class="bi bi-plus-circle"></i>
                                <span>Nouvelle campagne</span>
                            </a>
                        </li>
                        <li>
                            <a href="/campagnes/liste" class="<?php echo $listCampaignActivity; ?>">
                                <i class="bi bi-list-ul"></i>
                                <span>Liste des campagnes</span>
                            </a>
                        </li>
                        <li>
                            <a href="/campagnes/rapports" class="<?php echo $reportsCampaignActivity; ?>">
                                <i class="bi bi-bar-chart"></i>
                                <span>Analyses</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <!-- Validation ouverture compte -->
            <li class="nav-item">
                <a class="nav-link <?php echo $validerCompteActivity; ?>" href="/comptes">
                    <i class="bi bi-shield-check"></i>
                    <span>Valider Préouverture</span>
                </a>
                
        <?php endif; ?>
         <!-- Séparateur (commun à tous) -->
         <li class="nav-heading">Compte</li>

        <!-- Déconnexion (commun à tous) -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>
        </li>

    </ul>
</aside>