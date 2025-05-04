<section class="section dashboard">
    <div class="row">
        <!-- Carte Prospects Totaux -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Prospects Totaux <span>| Ce Mois</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>1,248</h6>
                            <span class="text-success small pt-1 fw-bold">+12%</span>
                            <span class="text-muted small pt-2 ps-1">vs mois dernier</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Nombre de Campagnes -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Campagnes Actives <span>| 30 jours</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning">
                            <i class="bi bi-megaphone"></i>
                        </div>
                        <div class="ps-3">
                            <h6>8 Campagnes</h6>
                            <span class="text-muted small pt-2 ps-1">5 en cours</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Meilleure Campagne -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Top Campagne <span>| Performances</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div class="ps-3">
                            <h6>Offre Été 2024</h6>
                            <span class="text-success small pt-1 fw-bold">214 clients</span>
                            <span class="text-muted small pt-2 ps-1">28% de conversion</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques Campagnes -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rendement des Campagnes</h5>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="campaignPerformanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Évolution Mensuelle</h5>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="monthlyTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analyse Détails -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Conversion par Canal</h5>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="channelChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Coût par Acquisition</h5>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="cpaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ChartJS Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Performance des campagnes
    new Chart(document.getElementById('campaignPerformanceChart'), {
        type: 'bar',
        data: {
            labels: ['Offre Été', 'Promo Crédit', 'Webinaire Pro', 'Parrainage', 'Emailing'],
            datasets: [{
                label: 'Clients acquis',
                data: [214, 187, 92, 156, 78],
                backgroundColor: '#4154f1'
            }, {
                label: 'Taux conversion',
                data: [28, 22, 15, 19, 10],
                backgroundColor: '#2eca6a',
                type: 'line',
                yAxisID: 'y1'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Clients' }
                },
                y1: {
                    position: 'right',
                    beginAtZero: true,
                    max: 100,
                    title: { display: true, text: 'Taux %' },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });

    // Évolution mensuelle
    new Chart(document.getElementById('monthlyTrendChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            datasets: [{
                label: 'Clients',
                data: [420, 380, 510, 490, 620, 730],
                borderColor: '#f83245',
                fill: false
            }, {
                label: 'Campagnes',
                data: [5, 4, 6, 7, 8, 9],
                borderColor: '#2b7be4',
                fill: false,
                yAxisID: 'y1'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    title: { display: true, text: 'Clients' }
                },
                y1: {
                    position: 'right',
                    beginAtZero: true,
                    title: { display: true, text: 'Nb Campagnes' },
                    grid: { drawOnChartArea: false }
                }
            }
        }
    });

    // Conversion par canal
    new Chart(document.getElementById('channelChart'), {
        type: 'doughnut',
        data: {
            labels: ['Email', 'Réseaux sociaux', 'Téléphone', 'RDV physique', 'Site web'],
            datasets: [{
                data: [25, 35, 20, 15, 5],
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff']
            }]
        }
    });

    // Coût par acquisition
    new Chart(document.getElementById('cpaChart'), {
        type: 'radar',
        data: {
            labels: ['Offre Été', 'Promo Crédit', 'Webinaire', 'Parrainage'],
            datasets: [{
                label: 'Coût moyen/client',
                data: [120, 85, 210, 65],
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)'
            }]
        }
    });
});
</script>