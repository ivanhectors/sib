<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['mhslogin']) == 0) {
  header('location:../403');
} else {
  // error_reporting(0);
  date_default_timezone_set('Asia/Jakarta'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());


  $parentpage = "index";
  include("include/header.php");
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
                  <li class="breadcrumb-item"><a href="../mhs?id"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboards</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">

            </div>
          </div>
          <!-- Card stats -->

        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-12">
          <div class="card bg-white">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-black text-uppercase ls-1 mb-1">Riwayat</h6>
                  <h5 class="h3 text-primary mb-0 text-uppercase">Bantuan Dana</h5>
                </div>
                <div class="col">
                  <ul class="nav nav-pills justify-content-end">
                    <li class="nav-item mr-2 mr-md-0">
                      <a href="?id" class="nav-link py-2 px-3 <?php echo ($_GET['id'] == "" ? "active" : "") ?>">
                        <span class="d-none d-md-block">Beasiswa Kebutuhan</span>
                        <span class="d-md-none"><i class="fas fa-graduation-cap"></i></span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="?id=pinjaman-registrasi" class="nav-link py-2 px-3 <?php echo ($_GET['id'] == "pinjaman-registrasi" ? "active" : "") ?>">
                        <span class="d-none d-md-block">Pinjaman Registrasi</span>
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
                if ($header == 'pinjaman-registrasi') {
                ?>
                  <canvas id="riwayat-pinjaman-registrasi" class="chart-canvas"></canvas>
                <?php } else { ?>
                  <canvas id="riwayat-beasiswa-kebutuhan" class="chart-canvas"></canvas>
                <?php }  ?>
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
      $peterpan = "SI3423";
      $kp = "SI4313";
      $skripsi = "SI4426";
      $rt = mysqli_query($con, "SELECT * FROM pendaftaran where id_mhs='" . $_SESSION['id_mhs'] . "' and kd_bsw='$kd_bsw' and status='$status'");
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
                            $nim = $_SESSION['id_mhs'];
                            $status = 'diterima';
                            $kd_bsw = '1';
                            $query = "SELECT tgl_daftar, thn_ajaran, semester, nominal_disetujui, tahun FROM pendaftaran WHERE id_mhs = ? and kd_bsw=? and status = ? GROUP BY tahun";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("sss", $nim, $kd_bsw , $status);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {


                              $date = $row['tgl_daftar'];
                              $tahun = date('Y', strtotime($date));

                              $semester = $row['semester'];
                              if ($semester == 'Ganjil') {
                                $semester = '1';
                              } else {
                                $semester = '2';
                              }

                              $display = "'" . $tahun . "-" . $semester . "'" . ",,";
                              $display_cut = substr($display, 0, -1);
                            ?><?php echo substr($display, 0, -1);
                            } ?>],
                  datasets: [{
                    data: [<?php
                            $nim = $_SESSION['id_mhs'];
                            $status = 'diterima';
                            $kd_bsw = '1';
                            $query = "SELECT tgl_daftar, thn_ajaran, semester, nominal_disetujui, tahun FROM pendaftaran WHERE id_mhs = ? and kd_bsw=? and status = ? GROUP BY tahun";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("sss", $nim,$kd_bsw, $status);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {


                              $nominal = $row['nominal_disetujui'];
                              $display = "'" . $nominal . "'" . ",,";
                              $display_cut = substr($display, 0, -1);
                            ?><?php echo substr($display, 0, -1);
                            } ?>'1000000' ]
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
                            $nim = $_SESSION['id_mhs'];
                            $status = 'diterima';
                            $kd_bsw = '2';
                            $query = "SELECT tgl_daftar, thn_ajaran, semester, nominal_disetujui, tahun FROM pendaftaran WHERE id_mhs = ? and kd_bsw=? and status = ? GROUP BY tahun";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("sss", $nim,$kd_bsw, $status);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {


                              $date = $row['tgl_daftar'];
                              $tahun = date('Y', strtotime($date));

                              $semester = $row['semester'];
                              if ($semester == 'Ganjil') {
                                $semester = '1';
                              } else {
                                $semester = '2';
                              }

                              $display = "'" . $tahun . "-" . $semester . "'" . ",,";
                              $display_cut = substr($display, 0, -1);
                            ?><?php echo substr($display, 0, -1);
                            } ?>],
                  datasets: [{
                    data: [<?php
                            $nim = $_SESSION['id_mhs'];
                            $status = 'diterima';
                            $kd_bsw = '2';
                            $query = "SELECT tgl_daftar, thn_ajaran, semester, nominal_disetujui, tahun FROM pendaftaran WHERE id_mhs = ? and kd_bsw=? and status = ? GROUP BY tahun";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("sss", $nim,$kd_bsw, $status);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {


                              $nominal = $row['nominal_disetujui'];
                              $display = "'" . $nominal . "'" . ",,";
                              $display_cut = substr($display, 0, -1);
                            ?><?php echo substr($display, 0, -1);
                            } ?>'10000000' ]
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
      <?php } ?>
    </div>
  </div>

  </body>

  </html>
<?php } ?>