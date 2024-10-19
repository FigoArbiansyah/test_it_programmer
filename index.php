<?php

include_once "./conn.php";
include_once "./sql-collections.php";

$resultSkorKpi = mysqli_query($link, $sqlSkorKPI);
$resultInfoTask = mysqli_query($link, $sqlTaskOnTimeAndLate);

// Array untuk menyimpan nama dan nilai
$names = [];
$values = [];
$rowSkorKPI = [];

while ($row = mysqli_fetch_array($resultSkorKpi)) {
    $names[] = $row['nama']; // Menyimpan nama untuk label chart
    $values[] = $row['skor_kpi']; // Menyimpan nilai untuk data chart
    $rowSkorKPI[] = $row;
}

$tasks = [];

while ($row = mysqli_fetch_array($resultInfoTask)) {
    $tasks = $row;
}

$tasksData = [$tasks['total_task_ontime'], $tasks['total_task_late']];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard KPI</title>
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <main>
      <div class="container py-md-0 py-5">
        <div class="row justify-content-between align-items-center g-md-0 g-5 min-vh-100">
          <div class="col-md-6">
            <div>
              <h4>Grafik Skor KPI</h4>
              <canvas id="skorKpiChart"></canvas>
            </div>
          </div>
          <div class="col-md-4">
            <div>
              <h4 class="text-center">Grafik Total Task Ontime dan Late</h4>
              <canvas id="totalTaskOntimeAndLateChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="container mt-5 min-vh-100">
        <h2>KPI Marketing Report</h2>
        <div style="overflow-x: auto;">
          <table class="table table-striped table-hover">
              <thead>
                  <tr>
                      <th scope="col">Nama</th>
                      <th scope="col">Target Sales</th>
                      <th scope="col">Aktual Sales</th>
                      <th scope="col">Pencapaian Sales (%)</th>
                      <th scope="col">Bobot Sales</th>
                      <th scope="col">Late Sales</th>
                      <th scope="col">Total Bobot Sales</th>
                      <th scope="col">Target Report</th>
                      <th scope="col">Aktual Report</th>
                      <th scope="col">Pencapaian Report (%)</th>
                      <th scope="col">Bobot Report</th>
                      <th scope="col">Late Report</th>
                      <th scope="col">Total Bobot Report</th>
                      <th scope="col">Skor KPI</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  // Check if there are results and loop through them to populate the table rows
                  if (count($rowSkorKPI) > 0) {
                      foreach ($rowSkorKPI as $key => $row) {
                          ?>
                          <tr>
                              <td><?= htmlspecialchars($row['nama']); ?></td>
                              <td><?= $row['target_sales']; ?></td>
                              <td><?= $row['aktual_sales']; ?></td>
                              <td><?= number_format($row['pencapaian_sales'], 2); ?>%</td>
                              <td><?= $row['bobot_sales']; ?>%</td>
                              <td><?= $row['late_sales']; ?>%</td>
                              <td><?= $row['total_bobot_sales']; ?>%</td>
                              <td><?= $row['target_report']; ?></td>
                              <td><?= $row['aktual_report']; ?></td>
                              <td><?= number_format($row['pencapaian_report'], 2); ?>%</td>
                              <td><?= $row['bobot_report']; ?>%</td>
                              <td><?= $row['late_report']; ?>%</td>
                              <td><?= $row['total_bobot_report']; ?>%</td>
                              <td><?= $row['skor_kpi']; ?>%</td>
                          </tr>
                          <?php
                      }
                  } else {
                      ?>
                      <tr>
                          <td colspan="14" class="text-center">No results found</td>
                      </tr>
                      <?php
                  }
                  ?>
              </tbody>
          </table>
        </div>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
      const labels = <?php echo json_encode($names); ?>;
      const dataValues = <?php echo json_encode($values); ?>;
      const dataTasks = <?php echo json_encode($tasksData); ?>;

      new Chart(document.getElementById('skorKpiChart').getContext('2d'), {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Skor KPI',
            data: dataValues,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: { beginAtZero: true }
          }
        }
      });

      new Chart(document.getElementById('totalTaskOntimeAndLateChart').getContext('2d'), {
        type: 'pie',
        data: {
          labels: ['Task On Time', 'Task Late'],
          datasets: [{
            label: 'Total',
            data: dataTasks,
            backgroundColor: ['#59C3C8', 'rgb(255, 99, 132)'],
            hoverOffset: 4
          }]
        }
      });
    </script>

  </body>
</html>
