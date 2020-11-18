<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['acclogin']) == 0) {
  header('location:../403');
} else {
  error_reporting(0);
  date_default_timezone_set('Asia/Jakarta'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());
  $parentpage = "index";


  function getPercentageChange($oldNumber, $newNumber)
  {
    $decreaseValue = $newNumber - $oldNumber;

    return ($decreaseValue / $oldNumber) * 100;
    // echo getPercentageChange(500, 234);
  }

  $year = date('Y');
  $semester_ini = date('n');
  if ($semester_ini <= 6) {
    $semester_ini = '2';
  } else {
    $semester_ini = '1';
  }
  $id_fakultas = $_SESSION['id_fakultas'];
  $tahun = $year . $semester_ini;
  $status = 'diterima';
  $kd_bsw_1 = '1';
  $kd_bsw_2 = '2';
  $query1 = "SELECT
  tahun
  , pendaftaran.kd_bsw
  , count(pendaftaran.id_mhs) as total_mhs
  , pendaftaran.semester
  , user_mhs.id_fakultas
  FROM pendaftaran
  JOIN user_mhs
  WHERE pendaftaran.kd_bsw= ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND user_mhs.id_fakultas = ? AND pendaftaran.tahun = ? GROUP BY pendaftaran.kd_bsw";
  $stmt1 = $con->prepare($query1);
  $stmt1->bind_param("sss", $kd_bsw_1, $id_fakultas, $tahun);
  $stmt1->execute();
  $result = $stmt1->get_result();
  $beasiswa_kebutuhan = $result->fetch_assoc();
  $stmt1->close();

  $query2 = "SELECT
  tahun
  , pendaftaran.kd_bsw
  , count(pendaftaran.id_mhs) as total_mhs
  , pendaftaran.semester
  , user_mhs.id_fakultas
  FROM pendaftaran
  JOIN user_mhs
  WHERE pendaftaran.kd_bsw= ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND user_mhs.id_fakultas = ? AND pendaftaran.tahun = ? GROUP BY pendaftaran.kd_bsw";
  
  $stmt2 = $con->prepare($query2);
  $stmt2->bind_param("sss", $kd_bsw_2, $id_fakultas, $tahun);
  $stmt2->execute();
  $result = $stmt2->get_result();
  $pinjaman_registrasi = $result->fetch_assoc();
  $stmt2->close();
?>

  <?php
  include("include/header.php");
  ?>
  <style>
    .card2:hover {

      background-color: #e9ecef;

    }
  </style>
  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }
  </script>
  </head>
  <?php
  include("include/sidebar.php");
  ?>

  <!-- Main content -->
  <div class="main-content" id="panel">

    <?php
    include("include/topnav.php"); //Edit topnav on this page
    ?>

    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Dashboards</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="../acc?id"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboards</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">

            </div>
          </div>

          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-6 col-md-6">
              <div class="card card2 card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total pengajuan pinjaman registrasi semester ini</h5>
                      <span class="h2 font-weight-bold mb-0"><?php
                                                              $nominal = $pinjaman_registrasi['total_mhs'];
                                                              $hasil_rupiah = number_format($nominal, 0, ',', '.');
                                                              echo $hasil_rupiah;  ?> Mahasiswa
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <!-- <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?php echo getPercentageChange(900, 1900); ?>%</span>
                    <span class="text-nowrap text-black">Dari semester lalu</span>
                  </p> -->
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-md-6">
              <div class="card card2 card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total pengajuan beasiswa kebutuhan semester ini</h5>
                      <span class="h2 font-weight-bold mb-0"><?php
                                                              $nominal = $beasiswa_kebutuhan['total_mhs'];
                                                              $hasil_rupiah = number_format($nominal, 0, ',', '.');
                                                              echo $hasil_rupiah;  ?> Mahasiswa</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <!-- <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                    <span class="text-nowrap">Dari semester lalu</span>
                  </p> -->
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-8">
          <div class="card bg-white">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-black text-uppercase ls-1 mb-1">Riwayat</h6>
                  <h5 class="h3 text-primary mb-0 text-uppercase">Bantuan Dana</h5>
                </div>
                <div class="col-xl-8">
                  <ul class="nav nav-pills justify-content-end">
                    <li class="nav-item mr-2 mr-md-0">
                      <a href="?id" class="nav-link py-2 px-3 <?php echo ($_GET['id'] == "" ? "active" : "") ?>">
                        <span class="d-none d-md-block">Pinjaman Registrasi</span>
                        <span class="d-md-none"><i class="fas fa-graduation-cap"></i></span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?id=beasiswa-kebutuhan" class="nav-link py-2 px-3 <?php echo ($_GET['id'] == "beasiswa-kebutuhan" ? "active" : "") ?>">
                        <span class="d-none d-md-block">Beasiswa Kebutuhan</span>
                        <span class="d-md-none"><i class="fas fa-hand-holding-usd"></i></span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <!-- Chart wrapper -->

                <?php
                $header = $_GET['id'];
                if ($header == 'beasiswa-kebutuhan') {
                ?>
                  <canvas id="riwayat-beasiswa-kebutuhan" class="chart-canvas"></canvas>
                <?php } else { ?>
                  <canvas id="riwayat-pinjaman-registrasi" class="chart-canvas"></canvas>
                <?php }  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Riwayat</h6>
                  <h5 class="h3 text-primary mb-0 text-uppercase">Pengajuan</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="riwayat-pengajuan" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="col-xl-4">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                  <h5 class="h3 mb-0">Total orders</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              Chart
              <div class="chart">
                <canvas id="chart-bars" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div> -->
      </div>
      <?php
      $status = '1';
      $id_info = '1';
      $sql = "SELECT * FROM informasi WHERE id_info =? and status=? LIMIT 1";
      $stmt = $con->prepare($sql);
      $stmt->bind_param("ii", $id_info, $status);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
       ?>
        <div class="row">
          <div class="col-xl-12">
            <!-- Members list group card -->
            <div class="card">
              <!-- Card header -->
              <div class="card-header">
                <!-- Title -->
                <h6 class="text-black text-uppercase ls-1 mb-1">PENGUMUMAN</h6>
                <h5 class="h3 text-uppercase text-primary mb-0"><?php echo $row['jdl_info']; ?></h5>
              </div>
              <!-- Card body -->
              <div class='card-body'>
                <?php echo $row['detail_info']; ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php
      include("include/footer.php"); //Edit topnav on this page
      ?>
     <?php
      $status = "diterima";
      $kd_bsw = "1";
      $rt = mysqli_query($con, "SELECT * FROM pendaftaran where kd_bsw='$kd_bsw' and status='$status'");
      // $peterpan = mysqli_query($con,"SELECT * FROM kehadiran where idusers='".$_SESSION['login']."' and statuskehadiran='$statuskehadiran' and semester='".$_GET['semester']."'");
      // $kp = mysqli_query($con,"SELECT * FROM tblkonsultasi where idusers='".$_SESSION['login']."' and idmatakuliah='$kp' and sts_konsul='$status' and semester='".$_GET['semester']."'");
      // $skripsi = mysqli_query($con,"SELECT * FROM tblkonsultasi where idusers='".$_SESSION['login']."' and idmatakuliah='$skripsi' and sts_konsul='$status' and semester='".$_GET['semester']."'");
      $num1 = mysqli_num_rows($rt);
      // $num2 = mysqli_num_rows($peterpan);
      // $num3 = mysqli_num_rows($kp);
      // $num4 = mysqli_num_rows($skripsi);
      { ?>

        <script>
          //
          // Charts
          //

          'use strict';

          //
          // Sales chart
          //

          var SalesChart = (function() {

            // Variables

            var $chart = $('#riwayat-beasiswa-kebutuhan');


            // Methods

            function init($this) {
              var salesChart = new Chart($this, {
                type: 'line',
                options: {
                  tooltips: {
                    callbacks: {
                      title: function(tooltipItem, data) {
                        return data.labels[tooltipItem[0].index];
                      },
                      label: function(tooltipItem, data) {
                        var amount = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        var total = eval(data.datasets[tooltipItem.datasetIndex].data.join("+"));
                        return 'Jumlah Beasiswa Kebutuhan: ' + 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                      },
                      //footer: function(tooltipItem, data) { return 'Total: 100 planos.'; }
                    }
                  },
                  scales: {
                    yAxes: [{
                      gridLines: {
                        color: Charts.colors.gray[700],
                        zeroLineColor: Charts.colors.gray[700]
                      },
                      ticks: {
                        beginAtZero: false,
                        callback: function(value, index, values) {
                          if (parseInt(value) >= 1000) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                          } else {
                            return 'Rp ' + value;
                          }
                        },

                        // callback: function(label, index, labels) {
                        //   return label / 1000000 + 'jt';
                        // }

                      },
                      scaleLabel: {
                        display: true,
                        labelString: 'JUMLAH BEASISWA KEBUTUHAN'
                      }
                    }]
                  }
                },
                data: { 
                  labels: [<?php
                            $status = 'diterima';
                            $kd_bsw = '1';
                            $id_fakultas = $_SESSION['id_fakultas'];
                            $query = "SELECT
                            tahun
                            , pendaftaran.tgl_daftar
                            , SUM(pendaftaran.nominal_disetujui) as total_dana
                            , pendaftaran.semester
                            , user_mhs.id_fakultas
                            FROM pendaftaran
                            JOIN user_mhs
                            WHERE pendaftaran.kd_bsw= ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND pendaftaran.status= ? AND user_mhs.id_fakultas = ? GROUP BY tahun";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("sss", $kd_bsw, $status, $id_fakultas);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {


                              // $date = $row['tahun'];
                              $tahun = $row['tahun'];
                              $tahun_cut = substr($tahun, 0, -1);
                              $semester = $row['semester'];
                              if ($semester == 'Gasal') {
                                $semester = '1';
                              } else {
                                $semester = '2';
                              }

                              $display = "'" . $tahun_cut . "-" . $semester . "'" . ",,";
                              $display_cut = substr($display, 0, -1);
                            ?><?php echo substr($display, 0, -1);
                            } ?>],
                  datasets: [{
                    data: [<?php
                            $status = 'diterima';
                            $kd_bsw = '1';
                            $id_fakultas = $_SESSION['id_fakultas'];
                            $query = "SELECT
                            tahun
                            , pendaftaran.tgl_daftar
                            , SUM(pendaftaran.nominal_disetujui) as total_dana
                            , pendaftaran.semester
                            , user_mhs.id_fakultas
                            FROM pendaftaran
                            JOIN user_mhs
                            WHERE pendaftaran.kd_bsw= ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND pendaftaran.status= ? AND user_mhs.id_fakultas = ? GROUP BY tahun";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("sss", $kd_bsw, $status, $id_fakultas);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {


                              $nominal = $row['total_dana'];
                              $display = "'" . $nominal . "'" . ",,";
                              $display_cut = substr($display, 0, -1);
                            ?><?php echo substr($display, 0, -1);
                            } ?> '10000000']
                  }]
                }
              });

              // Save to jQuery object

              $this.data('chart', salesChart);

            };


            // Events

            if ($chart.length) {
              init($chart);
            }

          })();
        </script>
        <script>
          //
          // Charts
          //

          'use strict';

          //
          // Sales chart
          //

          var SalesChart = (function() {

            // Variables

            var $charts = $('#riwayat-pinjaman-registrasi');


            // Methods

            function init($this) {
              var salesChart = new Chart($this, {
                type: 'line',
                options: {
                  tooltips: {
                    callbacks: {
                      title: function(tooltipItem, data) {
                        return data.labels[tooltipItem[0].index];
                      },
                      label: function(tooltipItem, data) {
                        var amount = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        var total = eval(data.datasets[tooltipItem.datasetIndex].data.join("+"));
                        return 'Jumlah Bantuan Dana: ' + 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                      },
                      //footer: function(tooltipItem, data) { return 'Total: 100 planos.'; }
                    }
                  },
                  scales: {
                    yAxes: [{
                      gridLines: {
                        color: Charts.colors.gray[700],
                        zeroLineColor: Charts.colors.gray[700]
                      },
                      ticks: {
                        beginAtZero: false,
                        callback: function(value, index, values) {
                          if (parseInt(value) >= 1000) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                          } else {
                            return 'Rp ' + value;
                          }
                        },

                        // callback: function(label, index, labels) {
                        //   return label / 1000000 + 'jt';
                        // }

                      },
                      scaleLabel: {
                        display: true,
                        labelString: 'JUMLAH PINJAMAN REGISTRASI'
                      }
                    }]
                  }
                },
                data: {
                  labels: [<?php
                            $status = 'diterima';
                            $kd_bsw = '2';
                            $id_fakultas = $_SESSION['id_fakultas'];
                            $query = "SELECT
                            tahun
                            , pendaftaran.tgl_daftar
                            , SUM(pendaftaran.nominal_disetujui) as total_dana
                            , pendaftaran.semester
                            , user_mhs.id_fakultas
                            FROM pendaftaran
                            JOIN user_mhs
                            WHERE pendaftaran.kd_bsw= ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND pendaftaran.status= ? AND user_mhs.id_fakultas = ? GROUP BY tahun";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("sss", $kd_bsw, $status, $id_fakultas);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {

                              // $date = $row['tahun'];
                              $tahun = $row['tahun'];
                              $tahun_cut = substr($tahun, 0, -1);
                              $semester = $row['semester'];
                              if ($semester == 'Gasal') {
                                $semester = '1';
                              } else {
                                $semester = '2';
                              }

                              $display = "'" . $tahun_cut . "-" . $semester . "'" . ",,";
                              $display_cut = substr($display, 0, -1);
                            ?><?php echo substr($display, 0, -1);
                            } ?>],
                  datasets: [{
                    data: [<?php
                            $status = 'diterima';
                            $kd_bsw = '2';
                            $id_fakultas = $_SESSION['id_fakultas'];
                            $query = "SELECT
                            tahun
                            , pendaftaran.tgl_daftar
                            , SUM(pendaftaran.nominal_disetujui) as total_dana
                            , pendaftaran.semester
                            , user_mhs.id_fakultas
                            FROM pendaftaran
                            JOIN user_mhs
                            WHERE pendaftaran.kd_bsw= ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND pendaftaran.status= ? AND user_mhs.id_fakultas = ? GROUP BY tahun";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("sss", $kd_bsw, $status, $id_fakultas);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {


                              $nominal = $row['total_dana'];
                              $display = "'" . $nominal . "'" . ",,";
                              $display_cut = substr($display, 0, -1);
                            ?><?php echo substr($display, 0, -1);
                            } ?> '10000000']
                  }]
                }
              });

              // Save to jQuery object

              $this.data('charts', salesChart);

            };


            // Events

            if ($charts.length) {
              init($charts);
            }

          })();
        </script>
        <script>
          //
          // Charts
          //

          'use strict';

          //
          // Doughnut chart
          //

          var BarStackedChart = (function() {

            // Variables

            var $chart = $('#riwayat-pengajuan');


            // Methods

            function init($this) {

              // Only for demo purposes - return a random number to generate datasets
              var randomScalingFactor = function() {
                return Math.round(Math.random() * 100);
              };


              // Chart data

              var data = {
                labels: [<?php
                          $status = 'diterima';
                          $kd_bsw = '1';
                          $id_fakultas = $_SESSION['id_fakultas'];
                          $query = "SELECT
                          tahun
                          , pendaftaran.tgl_daftar
                          , SUM(pendaftaran.nominal_disetujui) as total_dana
                          , pendaftaran.semester
                          , user_mhs.id_fakultas
                          FROM pendaftaran
                          JOIN user_mhs
                          WHERE pendaftaran.kd_bsw= ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND pendaftaran.status= ? AND user_mhs.id_fakultas = ? GROUP BY tahun";
                          $stmt = $con->prepare($query);
                          $stmt->bind_param("sss", $kd_bsw, $status, $id_fakultas);
                          $stmt->execute();
                          $result = $stmt->get_result();
                          while ($row = $result->fetch_assoc()) {


                            // $date = $row['tahun'];
                            $tahun = $row['tahun'];
                            $tahun_cut = substr($tahun, 0, -1);
                            $semester = $row['semester'];
                            if ($semester == 'Gasal') {
                              $semester = '1';
                            } else {
                              $semester = '2';
                            }

                            $display = "'" . $tahun_cut . "-" . $semester . "'" . ",,";
                            $display_cut = substr($display, 0, -1);
                          ?><?php echo substr($display, 0, -1);
                            } ?>],
                datasets: [{
                  label: 'Pinjaman Registrasi',
                  backgroundColor: Charts.colors.theme['success'],
                  data: [
                    <?php
                    $status = 'diterima';
                    $kd_bsw = '2';
                    $id_fakultas = $_SESSION['id_fakultas'];
                    $query = "SELECT
                    tahun
                    , pendaftaran.tgl_daftar
                    , count(pendaftaran.nominal_disetujui) as total_mhs
                    , pendaftaran.semester
                    , user_mhs.id_fakultas
                    FROM pendaftaran
                    JOIN user_mhs
                    WHERE pendaftaran.kd_bsw= ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND pendaftaran.status= ? AND user_mhs.id_fakultas = ? GROUP BY tahun";
                            
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("sss", $kd_bsw, $status, $id_fakultas);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {


                      $nominal = $row['total_mhs'];
                      $display = "'" . $nominal . "'" . ",,";
                      $display_cut = substr($display, 0, -1);
                    ?><?php echo substr($display, 0, -1);
                            } ?>
                  ]
                }, {
                  label: 'Beasiswa Kebutuhan',
                  backgroundColor: Charts.colors.theme['primary'],
                  data: [
                    <?php
                    $status = 'diterima';
                    $kd_bsw = '1';
                    $id_fakultas = $_SESSION['id_fakultas'];
                    $query = "SELECT
                    tahun
                    , pendaftaran.tgl_daftar
                    , count(pendaftaran.nominal_disetujui) as total_mhs
                    , pendaftaran.semester
                    , user_mhs.id_fakultas
                    FROM pendaftaran
                    JOIN user_mhs
                    WHERE pendaftaran.kd_bsw= ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND pendaftaran.status= ? AND user_mhs.id_fakultas = ? GROUP BY tahun";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("sss", $kd_bsw, $status, $id_fakultas);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {


                      $nominal = $row['total_mhs'];
                      $display = "'" . $nominal . "'" . ",,";
                      $display_cut = substr($display, 0, -1);
                    ?><?php echo substr($display, 0, -1);
                            } ?>
                  ]
                }]

              };


              // Options

              var options = {
                tooltips: {
                  mode: 'index',
                  intersect: false,
                  callbacks: {
                    footer: (tooltipItems, data) => {
                      let total = tooltipItems.reduce((a, e) => a + parseInt(e.yLabel), 0);
                      return 'Total Pengajuan: ' + total + ' Mahasiswa';
                    }
                  }
                },
                responsive: true,
                scales: {
                  xAxes: [{
                    stacked: true,
                  }],
                  yAxes: [{
                    stacked: true,
                    scaleLabel: {
                      display: true,
                      labelString: 'JUMLAH PENDAFTARAN MAHASISWA'
                    }
                  }]
                }
              }


              // Init chart

              var barStackedChart = new Chart($this, {
                type: 'bar',
                data: data,
                options: options
              });

              // Save to jQuery object

              $this.data('chart', barStackedChart);

            };


            // Events

            if ($chart.length) {
              init($chart);
            }

          })();
        </script>
        <script>
          function getPercentageChange($oldNumber, $newNumber) {
            $decreaseValue = $newNumber - $oldNumber;

            return ($decreaseValue / $oldNumber) * 100;
            // echo getPercentageChange(500, 234);
          }
        </script>
      <?php } ?>
    </div>
  </div>

  </body>

  </html>
<?php } ?>