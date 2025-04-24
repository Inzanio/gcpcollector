<div class="pagetitle">
  <h1>Tableau de Bord</h1>
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

        <!-- Carte Prospects -->
        <div class="col-md-6">
          <div class="card info-card prospects-card">
            <div class="card-body">
              <h5 class="card-title">Prospects <span>| Ce mois</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>84</h6>
                  <span class="text-success small pt-1 fw-bold">12%</span>
                  <span class="text-muted small pt-2 ps-1">augmentation</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Prospects Card -->

        <!-- Carte Rendez-vous -->
        <div class="col-md-6">
          <div class="card info-card meetings-card">
            <div class="card-body">
              <h5 class="card-title">Rendez-vous <span>| Cette semaine</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-check"></i>
                </div>
                <div class="ps-3">
                  <h6>15</h6>
                  <span class="text-success small pt-1 fw-bold">8%</span>
                  <span class="text-muted small pt-2 ps-1">augmentation</span>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Meetings Card -->

        <!-- Graphique Activité -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Activité récente <span>| 30 derniers jours</span></h5>
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
                    <th>Entreprise</th>
                    <th>Statut</th>
                    <th>Prochaine action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Martin Dupont</td>
                    <td>ABC Corp</td>
                    <td><span class="badge bg-warning">En cours</span></td>
                    <td>Relance téléphonique</td>
                  </tr>
                  <tr>
                    <td>Sophie Lambert</td>
                    <td>XYZ SA</td>
                    <td><span class="badge bg-success">Converti</span></td>
                    <td>Envoi contrat</td>
                  </tr>
                  <tr>
                    <td>Pierre Moreau</td>
                    <td>123 Industries</td>
                    <td><span class="badge bg-primary">RDV pris</span></td>
                    <td>Préparation présentation</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- End Recent Prospects -->

      </div>
    </div><!-- End Left column -->

    <!-- Colonne secondaire -->
    <div class="col-lg-4">

      <!-- Agenda -->
      <div class="card">
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
      </div><!-- End Agenda -->

      <!-- Objectifs -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Mes objectifs</h5>
          <div class="progress mb-3">
            <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
              Prospects (75%)
            </div>
          </div>
          <div class="progress mb-3">
            <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
              Rendez-vous (60%)
            </div>
          </div>
          <div class="progress">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">
              Conversions (45%)
            </div>
          </div>
        </div>
      </div><!-- End Goals -->

    </div><!-- End Right column -->

  </div>
</section>

<!-- Script pour le graphique -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  new ApexCharts(document.querySelector("#activityChart"), {
    series: [{
      name: 'Prospects',
      data: [10, 15, 12, 18, 22, 25, 30, 28, 35, 32, 40, 38]
    }],
    chart: {
      type: 'bar',
      height: 350
    },
    colors: ['#4154f1'],
    xaxis: {
      categories: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec']
    }
  }).render();
});
</script>