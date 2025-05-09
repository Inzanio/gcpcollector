<div class="pagetitle">
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="">Accueil</a></li>
      <li class="breadcrumb-item active">Tableau de Bord</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">

    <!-- Colonne principale -->
    <div class="col-lg-8">
      <div class="row">

        <!-- Carte Prospects Personnels -->
        <div class="col-md-6">
          <div class="card info-card prospects-card h-100"> <!-- Ajout de h-100 -->
            <div class="card-body d-flex flex-column"> <!-- Ajout de d-flex flex-column -->
              <h5 class="card-title">Prospects enregistrés <!--<span>| Ce mois</span>--></h5>
              <div class="d-flex align-items-center flex-grow-1"> <!-- Ajout de flex-grow-1 -->
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo $totalProspects; ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Prospects Card -->

        <!-- Carte Taux Conversion Personnel -->
        <div class="col-md-6">
          <div class="card info-card conversion-card h-100"> <!-- Ajout de h-100 -->
            <div class="card-body d-flex flex-column"> <!-- Ajout de d-flex flex-column -->
              <h5 class="card-title">Taux de conversion</h5>
              <div class="d-flex align-items-center flex-grow-1"> <!-- Ajout de flex-grow-1 -->
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-graph-up"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo number_format($tauxConversion, 1); ?>%</h6>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Conversion Card -->

        <div class="col-12 mb-4"></div>

        <!-- Graphique Activité -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Activité récente <!--<span>| 30 derniers jours</span> !--></h5>
              <div id="activityChart" style="min-height: 300px;"></div>
            </div>
          </div>
        </div><!-- End Activity Chart -->

        <!-- Liste Prospects -->
        <div class="col-12">
          <div class="card recent-prospects">
            <div class="card-body">
              <h5 class="card-title">Prospects récents</h5>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Nom</th>
                    <th>Profession</th>
                    <th>Numéro Téléphone</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($prospects as $prospect): ?>
                    <tr>
                      <td><?= htmlspecialchars($prospect->getNom()) ?></td>
                      <td><?= htmlspecialchars($prospect->getProfession()) ?></td>
                      <td><?= htmlspecialchars($prospect->getTelephone()[0]) ?></td>
                      <td>
                        <a href="/editer-prospect?id=<?= urlencode($prospect->getDocId() ?? '') ?>"
                          class="btn btn-outline-warning">
                          <i class="bi bi-pencil me-2"></i>Modifier
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- End Recent Prospects -->

      </div>
    </div><!-- End Left column -->

    <!-- Colonne secondaire -->
    <div class="col-lg-4">

      <!-- Objectifs Prospecteur -->
      <div class="card" style="z-index: 2;">
        <div class="card-body">
          <h5 class="card-title">Mes objectifs</h5>

          <h6 class="card-subtitle mb-2 text-muted">Prospection</h6>
          <div class="progress mb-3">
            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo ($totalProspects / 100) * 100; ?>%" aria-valuenow="<?php echo $totalProspects; ?>" aria-valuemin="0" aria-valuemax="100">
              <?php echo $totalProspects; ?> (<?php echo $totalProspects; ?>/100 prospects)
            </div>
          </div>

          <h6 class="card-subtitle mb-2 text-muted">Taux de conversion</h6>
          <div class="progress mb-3">
            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $tauxConversion; ?>%" aria-valuenow="<?php echo $tauxConversion; ?>" aria-valuemin="0" aria-valuemax="100">
              <?php echo number_format($tauxConversion, 1); ?>% (<?php echo number_format($tauxConversion, 1); ?>% sur objectif 10%)
            </div>
          </div>

          <h6 class="card-subtitle mb-2 text-muted">Objectif agence</h6>
          <div class="progress">
            <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
              75% (6.8% sur objectif 9%)
            </div>
          </div>
        </div>
      </div><!-- End Goals -->

      <!-- Agenda -->
      <!-- <div class="card" style="z-index: 2;">
        <div class="card-body">
          <h5 class="card-title">Mon agenda <span>| Aujourd'hui</span></h5>
          <div class="activity">
            <div class="activity-item d-flex">
              <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
              <div class="activity-content">
                10:00 - Réunion avec ABC Corp
              </div>
            </div>
            <div class="activity-item d-flex">
              <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
              <div class="activity-content">
                14:30 - Appel avec Sophie Lambert
              </div>
            </div>
            <div class="activity-item d-flex">
              <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
              <div class="activity-content">
                16:00 - Visite site XYZ SA
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- End Agenda -->

      <!-- Classement -->
      <div class="card" style="z-index: 2;">
        <div class="card-body">
          <h5 class="card-title">Classement agence <span>| Ce mois</span></h5>
          <div class="ranking-list">
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
              <div class="d-flex align-items-center">
                <span class="badge bg-primary me-2">1</span>
                <span>Marie Durand</span>
              </div>
              <span class="text-success fw-bold">8.2%</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
              <div class="d-flex align-items-center">
                <span class="badge bg-secondary me-2">2</span>
                <span>Jean Petit</span>
              </div>
              <span class="text-success fw-bold">7.5%</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
              <div class="d-flex align-items-center">
                <span class="badge bg-warning me-2">3</span>
                <span>Vous</span>
              </div>
              <span class="text-success fw-bold">5.2%</span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2">
              <div class="d-flex align-items-center">
                <span class="badge bg-light text-dark me-2">4</span>
                <span>Luc Martin</span>
              </div>
              <span class="text-muted">4.8%</span>
            </div>
          </div>
        </div>
      </div><!-- End Ranking -->

      <div id="btn-ajouter-prospect" class="position-fixed" style="bottom: 100px; right: 50px; z-index: 3;">
        <a href="/ajouter-prospect" class="btn btn-primary  btn-lg d-flex align-items-center justify-content-center gap-2 shadow"
          style="border-radius: 15px; padding: 15px 25px; background-color: #4154f1; border-color: #4154f1; color: white;">
          <i class="bi bi-plus"></i>
          Ajouter Prospect
        </a>
      </div>

    </div><!-- End Right column -->

  </div>
</section>

<!-- Script pour le graphique -->

<?php

$prospectsData = array();
foreach ($prospects as $prospect) {
  $date = (new DateTime($prospect->getDateCreation()->parseValue()))->format(DATE_FORMAT_SIMPLE_DISPLAY);
  if (!isset($prospectsData[$date])) {
    $prospectsData[$date] = 0;
  }
  $prospectsData[$date]++;
}

// // Générer les données pour le graphique
// $dates = array_keys($prospectsData);
// $counts = array_values($prospectsData);
?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const prospectsData = <?php echo json_encode($prospectsData); ?>;

    const categories = Object.keys(prospectsData);
    const data = Object.values(prospectsData);

    new ApexCharts(document.querySelector("#activityChart"), {
      series: [{
        name: 'Prospects',
        data: data
      }],
      chart: {
        type: 'bar',
        height: 350
      },
      colors: ['#4154f1'],
      xaxis: {
        categories: categories
      }
    }).render();
  });
</script>