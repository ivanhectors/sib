<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
  header('location:../403');
} else {
  date_default_timezone_set('Asia/Jakarta'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());
  $page = "userlog";


?>
  <?php
  include("include/header.php");
  ?>

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


    <!-- Header & Breadcrumbs -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">

              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="../adm">Dashboards</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Riwayat Login User</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">


            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Batas Header & Breadcrumbs -->





    <!-- Page content -->
    <div class="container-fluid mt--6">
      <!-- Table -->
      <div class="row">
        <div class="col">

          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-0">Data Riwayat Login User</h3>
              <p class="text-sm mb-0">
                Tabel ini merupakan detail riwayat login hingga logout user mulai dari Admin, Penyeleksi & Mahasiswa. Tabel ini berguna untuk melacak
                jejak login user pada sistem. Riwayat yang di tampilkan pada tabel hanya data login terbaru <strong>6 bulan terakhir</strong> saja.
              </p>
            </div>
            <div class="table-responsive py-4">
              <table class="table table-flush" id="tabelUserlog">
                <thead class="thead-light">
                  <tr>
                    <th>
                      <center>No
                    </th>
                    <th>
                      <center>Username
                    </th>
                    <th>
                      <center>User IP
                    </th>
                    <th>
                      <center>Waktu Login
                    </th>
                    <th>
                      <center>Waktu Logout
                    </th>
                    <th>
                      <center>Status Login
                    </th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>
                      <center>No
                    </th>
                    <th>
                      <center>Username
                    </th>
                    <th>
                      <center>User IP
                    </th>
                    <th>
                      <center>Waktu Login
                    </th>
                    <th>
                      <center>Waktu Logout
                    </th>
                    <th>
                      <center>Status Login
                    </th>
                  </tr>
                </tfoot>
                <tbody>
                  <tr>
                    <td>No</td>
                    <td>Username</td>
                    <td>User IP</td>
                    <td>Waktu Login</td>
                    <td>Waktu Logout</td>
                    <td>Status Login</td>
                  </tr>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>







      <?php
      include("include/footer.php"); //Edit topnav on this page
      ?>
      <script type="text/javascript">
        $(document).ready(function() {

          var table = $('#tabelUserlog').DataTable({
            "processing": true,
            "serverSide": true,
            "pagingType": "full_numbers",
            "ajax": "scripts/get_data_userlog.php",
            "order": [
              [3, "desc"]
            ],
            "language": {
              "lengthMenu": "Menampilkan _MENU_ data per halaman",
              "zeroRecords": "Maaf, Data yang dicari tidak ditemukan.",
              "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
              "infoEmpty": "Tidak ada data tersedia.",
              "infoFiltered": "(Dicari dari total _MAX_ data)",
              "paginate": {
                "previous": "<i class='fas fa-angle-left'></i>",
                "next": "<i class='fas fa-angle-right'></i>",
                "first": "<i class='fas fa-angle-double-left'></i>",
                "last": "<i class='fas fa-angle-double-right'></i>"
              }
            },

            "columnDefs": [
              {
                "targets": -3,
                "data": 3,

                render: function(data, type, row) {
                  moment.locale('');
                  var data_tanggal = data;
                  var ubah = moment(data_tanggal, "YYYY-MM-DD h:mm:ss").format('DD-MM-YYYY h:mm:ss');
                  return ubah;
                }
              }, {
                "targets": -1,
                "data": 5,
                render: function(data, type, row) {
                  if (data == '1') {
                    return '<center><p class="btn btn-success btn-sm linkMhs">Sukses</p></center>';
                  } else {
                    return '<center><p class="btn btn-danger btn-sm linkMhs">Gagal</p></center>';
                  }
                }
              }
            ]
          });

        });
      </script>
    </div>
  </div>

  </body>

  </html>
<?php } ?>