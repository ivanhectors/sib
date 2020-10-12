<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['mhslogin']) == 0) {
    header('location:../403');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    // include("include/header.php");
    // include("include/sidebar.php");
    $parentpage = "riwayat_pengajuan";


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
                            <h6 class="h2 text-white d-inline-block mb-0">Pengajuan</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="../mhs?id"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../mhs?id">Dashboards</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Riwayat Pengajuan</li>
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
                        <div class="card-header border-0">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="mb-0">Riwayat Pengajuan Beasiswa</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Kode Daftar</th>
                                        <th>Nama Beasiswa</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Status Pengajuan</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $nim = $_SESSION['id_mhs'];
                                    $sql = "SELECT
                                    pendaftaran.kd_daftar AS kd_daftar
                                    , pendaftaran.tgl_daftar As tgl_daftar
                                    , pendaftaran.status AS status
                                    , pendaftaran.thn_ajaran AS tahun_ajaran
                                    , pendaftaran.semester AS semester
                                    , pendaftaran.kd_bsw AS id_bsw
                                    , beasiswa.nama_bsw AS nm_beasiswa
                                    FROM pendaftaran
                                    JOIN beasiswa ON (
                                    pendaftaran.kd_bsw = beasiswa.id_bsw ) WHERE pendaftaran.id_mhs = ? ";
                                    $stmt = $con->prepare($sql);
                                    $stmt->bind_param("i", $nim);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td class="table-user">
                                                <b> <?php echo htmlentities($row['kd_daftar']); ?></b>

                                            </td>
                                            <td>
                                                <b> <span class="text-muted"><?php $dtl_bsw_row = htmlentities($row['nm_beasiswa']);
                                                                                if (strlen($dtl_bsw_row) > 23) $dtl_bsw_row = substr($dtl_bsw_row, 0, 23) . "...";
                                                                                echo $dtl_bsw_row;

                                                                                ?></span></b>
                                            </td>

                                            <td class="table-user">
                                                <b> <?php
                                                    $tanggal = $row['tgl_daftar'];
                                                    echo date('d-m-Y', strtotime($tanggal));
                                                    ?></b>

                                            </td>
                                            <td>
                                                <?php
                                                $tahun_ajaran = $row['tahun_ajaran'];
                                                $semester = $row['semester'];
                                                echo $tahun_ajaran . " " . $semester;
                                                ?>

                                            </td>

                                            <td>
                                                <?php $status = $row['status'];
                                                if ($status == null) {
                                                    echo '<span class="badge badge-warning">Diproses</span>';
                                                } elseif ($status == 'diterima') {
                                                    echo '<span class="badge badge-success">diterima</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">ditolak</span>';
                                                }
                                                ?>
                                            </td>

                                            <td class="text-center">

                                                <a type="button" href="detail?kd_daftar=<?php echo htmlentities($row['kd_daftar']); ?>&&id=<?php echo $row['id_bsw']; ?>" class=" btn btn-primary btn-sm btn-icon-only rounded-circle">
                                                    <span class="btn-inner--icon text-white"><i class="fas fa-chevron-circle-right"></i></span></a>
                                            </td>
                                        </tr>
                                    <?php
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Image overlay -->
            <div class="card bg-dark text-white border-0">
                <img class="card-img" src="../assets/img/quotes.jpg" alt="List Beasiswa">
                <div class="card-img-overlay align-items-center">
                    <div>
                        <!-- <h5 class="h2 card-title text-white mb-2">Cari Mahasiswa</h5> -->
                        <div class="form-group col-md-6 mt-2">
                        </div>

                    </div>
                </div>
            </div>




            <?php
            include("include/footer.php"); //Edit topnav on this page
            ?>
            <script>
                function toggle_select(id) {
                    var X = document.getElementById(id);
                    if (X.checked == true) {
                        X.value = "1";
                    } else {
                        X.value = "0";
                    }
                    //var sql="update clients set calendar='" + X.value + "' where cli_ID='" + X.id + "' limit 1";
                    var who = X.id;
                    var chk = X.value
                    //alert("Joe is still debugging: (function incomplete/database record was not updated)\n"+ sql);
                    $.ajax({
                        //this was the confusing part...did not know how to pass the data to the script
                        url: 'as_status_admin.php',
                        type: 'post',
                        data: 'who=' + who + '&chk=' + chk,
                        success: function(output) {
                            alert('success, server says ' + output);
                        },
                        error: function() {
                            alert('something went wrong, save failed');
                        }
                    });
                }
            </script>
            <script type="text/javascript">
                document.getElementById("close_direct").onclick = function() {
                    location.href = "data_admin";
                };
            </script>


        </div>
    </div>

    </body>

    </html>
<?php } ?>