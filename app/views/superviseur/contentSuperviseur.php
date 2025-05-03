<section class="section dashboard">
    <div class="row">
        <!-- Carte Prospects Totaux -->
        <div class="col-xxl-3 col-md-6">
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

        <!-- Carte Taux de Conversion -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Conversion Globale <span>| Taux</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div class="ps-3">
                            <h6>34.7%</h6>
                            <span class="text-success small pt-1 fw-bold">+2.1%</span>
                            <span class="text-muted small pt-2 ps-1">amélioration</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Produits Populaires -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Produit Phare <span>| Top 1</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div class="ps-3">
                            <h6>Crédits Pro</h6>
                            <span class="text-muted small pt-2 ps-1">42% des conversions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Zone Géographique -->
        <div class="col-xxl-3 col-md-6">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">Zone Active <span>| Top 1</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="ps-3">
                            <h6>Quartier Affaires</h6>
                            <span class="text-muted small pt-2 ps-1">28% des prospects</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques Secteur Activité -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Prospects par Secteur</h5>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="sectorChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Taux Conversion par Secteur</h5>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="conversionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analyse Démographique -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Répartition par Tranche d'Âge</h5>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Attractivité des Produits</h5>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="productChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ChartJS Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prospects par secteur
    new Chart(document.getElementById('sectorChart'), {
        type: 'bar',
        data: {
            labels: ['Commerce', 'Services', 'Industrie', 'Agriculture', 'TI'],
            datasets: [{
                label: 'Prospects',
                data: [320, 180, 420, 90, 210],
                backgroundColor: '#4154f1'
            }]
        }
    });

    // Taux conversion par secteur
    new Chart(document.getElementById('conversionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Commerce', 'Services', 'Industrie', 'Agriculture', 'TI'],
            datasets: [{
                data: [28, 42, 35, 19, 50],
                backgroundColor: ['#2eca6a', '#ff771d', '#f83245', '#2b7be4', '#7d3af2']
            }]
        }
    });

    // Tranche d'âge
    new Chart(document.getElementById('ageChart'), {
        type: 'polarArea',
        data: {
            labels: ['18-25', '26-35', '36-45', '46-55', '56+'],
            datasets: [{
                data: [15, 35, 30, 15, 5],
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff']
            }]
        }
    });

    // Produits
    new Chart(document.getElementById('productChart'), {
        type: 'radar',
        data: {
            labels: ['Crédits Pro', 'Épargne', 'Assurances', 'Investissements', 'Cartes'],
            datasets: [{
                label: 'Demande',
                data: [65, 59, 90, 81, 56],
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgb(75, 192, 192)'
            }]
        }
    });
});
</script>