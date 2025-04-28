<?php
//require_once("routes.php");
session_start();
//var_dump($_SESSION['user_role']);
if (!isset($_SESSION['user_role'])) header('Location: /login');
//   if ( $_SESSION['user_role'] != "agent") {
//       header('Location: /login');
//       exit();
//   }
?>
<!DOCTYPE html>
<html lang="en">

<?php
require_once("pages/head.php");
?>

<body>


    <!-- ======= Header ======= -->
    <?php
    require_once("pages/header.php");
    ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <?php

    require_once("pages/sidebar.php");
    ?>
    <!-- End Sidebar-->

    <!-- ======= Main ======= -->
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Liste des Prospects</h5>
                            <p></p>

                            <!-- Table with stripped rows -->
                            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                                <div class="datatable-top">
                                    <div class="datatable-dropdown">
                                        <label>
                                            <select class="datatable-selector" name="per-page">
                                                <option value="5">5</option>
                                                <option value="10" selected="">10</option>
                                                <option value="15">15</option>
                                                <option value="-1">All</option>
                                            </select> entries per page
                                        </label>
                                    </div>
                                    <div class="datatable-search">
                                        <input class="datatable-input" placeholder="Search..." type="search" name="search" title="Search within table">
                                    </div>
                                    <a href="/forms/ajouter-prospect.php" type="button" class="btn btn-primary"><i class="bi bi-star me-1"></i> Ajouter </a>

                                </div>
                                <div class="datatable-container">
                                    <table class="table datatable datatable-table">
                                        <thead>
                                            <tr>
                                                <?php
                                                $columns = [
                                                    ['label' => '<b>N</b>ame', 'sortable' => true, 'style' => 'width: 20.825852782764812%;'],
                                                    ['label' => 'Ext.', 'sortable' => true, 'style' => 'width: 11.131059245960502%;'],
                                                    ['label' => 'City', 'sortable' => true, 'style' => 'width: 26.750448833034113%;'],
                                                    ['label' => 'Start Date', 'sortable' => true, 'style' => 'width: 18.850987432675044%;', 'format' => 'YYYY/DD/MM', 'type' => 'date'],
                                                    ['label' => 'Completion', 'sortable' => true, 'style' => 'width: 22.44165170556553%;', 'class' => 'red']
                                                ];

                                                foreach ($columns as $column) {
                                                    $sortable = $column['sortable'] ? 'data-sortable="true"' : '';
                                                    $style = isset($column['style']) ? "style=\"{$column['style']}\"" : '';
                                                    $format = isset($column['format']) ? "data-format=\"{$column['format']}\"" : '';
                                                    $type = isset($column['type']) ? "data-type=\"{$column['type']}\"" : '';
                                                    $class = isset($column['class']) ? "class=\"{$column['class']}\"" : '';

                                                    echo "<th $sortable $style $format $type $class>
                                                            <button class=\"datatable-sorter\">{$column['label']}</button>
                                                          </th>";
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $prospects = [
                                                ['name' => 'Unity Pugh', 'ext' => '9958', 'city' => 'Curicó', 'start_date' => '2005/02/11', 'completion' => '37%'],
                                                ['name' => 'Theodore Duran', 'ext' => '8971', 'city' => 'Dhanbad', 'start_date' => '1999/04/07', 'completion' => '97%'],
                                                ['name' => 'Kylie Bishop', 'ext' => '3147', 'city' => 'Norman', 'start_date' => '2005/09/08', 'completion' => '63%'],
                                                ['name' => 'Willow Gilliam', 'ext' => '3497', 'city' => 'Amqui', 'start_date' => '2009/29/11', 'completion' => '30%'],
                                                ['name' => 'Blossom Dickerson', 'ext' => '5018', 'city' => 'Kempten', 'start_date' => '2006/11/09', 'completion' => '17%'],
                                                ['name' => 'Elliott Snyder', 'ext' => '3925', 'city' => 'Enines', 'start_date' => '2006/03/08', 'completion' => '57%'],
                                                ['name' => 'Castor Pugh', 'ext' => '9488', 'city' => 'Neath', 'start_date' => '2014/23/12', 'completion' => '93%'],
                                                ['name' => 'Pearl Carlson', 'ext' => '6231', 'city' => 'Cobourg', 'start_date' => '2014/31/08', 'completion' => '100%'],
                                                ['name' => 'Deirdre Bridges', 'ext' => '1579', 'city' => 'Eberswalde-Finow', 'start_date' => '2014/26/08', 'completion' => '44%'],
                                                ['name' => 'Daniel Baldwin', 'ext' => '6095', 'city' => 'Moircy', 'start_date' => '2000/11/01', 'completion' => '33%'],
                                            ];

                                            foreach ($prospects as $index => $prospect) {
                                                echo "<tr data-index=\"$index\">
                                                        <td>{$prospect['name']}</td>
                                                        <td>{$prospect['ext']}</td>
                                                        <td>{$prospect['city']}</td>
                                                        <td>{$prospect['start_date']}</td>
                                                        <td class=\"green\">{$prospect['completion']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="datatable-bottom">
                                    <div class="datatable-info">
                                        <?php
                                        $currentPage = 1;
                                        $perPage = 10;
                                        $totalEntries = 100;
                                        $startEntry = ($currentPage - 1) * $perPage + 1;
                                        $endEntry = min($startEntry + $perPage - 1, $totalEntries);
                                        echo "Showing $startEntry to $endEntry of $totalEntries entries";
                                        ?>
                                    </div>
                                    <nav class="datatable-pagination">
                                        <ul class="datatable-pagination-list">
                                            <?php
                                            $totalPages = ceil($totalEntries / $perPage);
                                            $prevPage = max(1, $currentPage - 1);
                                            $nextPage = min($totalPages, $currentPage + 1);

                                            // Previous button
                                            $prevDisabled = $currentPage == 1 ? 'datatable-disabled' : '';
                                            echo "<li class=\"datatable-pagination-list-item $prevDisabled\">
                                                    <button data-page=\"$prevPage\" class=\"datatable-pagination-list-item-link\" aria-label=\"Page $prevPage\">‹</button>
                                                  </li>";

                                            // Page numbers
                                            for ($page = 1; $page <= $totalPages; $page++) {
                                                $activeClass = $page == $currentPage ? 'datatable-active' : '';
                                                echo "<li class=\"datatable-pagination-list-item $activeClass\">
                                                        <button data-page=\"$page\" class=\"datatable-pagination-list-item-link\" aria-label=\"Page $page\">$page</button>
                                                      </li>";
                                            }

                                            // Next button
                                            $nextDisabled = $currentPage == $totalPages ? 'datatable-disabled' : '';
                                            echo "<li class=\"datatable-pagination-list-item $nextDisabled\">
                                                    <button data-page=\"$nextPage\" class=\"datatable-pagination-list-item-link\" aria-label=\"Page $nextPage\">›</button>
                                                  </li>";
                                            ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php
    require_once("pages/footer.php");
    ?>
    <!-- End Footer -->

</body>

</html>