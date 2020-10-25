<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['acclogin']) == 0) {
    header('location:../403');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    // include("include/header.php");
    // include("include/sidebar.php");
    $parentpage = "pengajuan";


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
                                    <li class="breadcrumb-item"><a href="../acc?id"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../acc?id">Dashboards</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Pengajuan Mahasiswa</li>
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
                                    <h3 class="mb-0">List Beasiswa Tersedia</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive py-4">
                            <table class="table align-items-center table-hover table-flush table-striped" id="datatable-buttons">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Kode Daftar</th>
                                        <th>NIM</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $kd_role = $_SESSION['role'];
                                    $status = 'diterima';
                                    $sql = "SELECT
                                    pendaftaran.kd_daftar
                                    , pendaftaran.nim
                                    , pendaftaran.kd_bsw
                                    , pendaftaran.thn_ajaran
                                    , pendaftaran.semester
                                    , pendaftaran.tgl_daftar
                                    , sts_daftar.kd_daftar AS KD_DAFTAR_STATUS
                                    , sts_daftar.acc_role
                                    , sts_daftar.status 
                                    FROM pendaftaran
                                    JOIN sts_daftar
                                    WHERE sts_daftar.acc_role = ?  AND pendaftaran.kd_daftar = sts_daftar.kd_daftar AND sts_daftar.status = ?";
                                    $stmt = $con->prepare($sql);
                                    $stmt->bind_param("ss", $kd_role, $status);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td class="table-user">
                                                <b> <?php echo htmlentities($row['kd_daftar']); ?></b>

                                            </td>
                                            <td>
                                            <b> <?php echo htmlentities($row['nim']); ?></b>
                                            </td>
                                            
                                            <td class="table-user">
                                                <b> <?php
                                                    $tanggal = $row['tgl_daftar'];
                                                    echo date('d-m-Y', strtotime($tanggal));
                                                    ?></b>

                                            </td>
                                            <td class="table-user">
                                            <b> <?php echo htmlentities($row['thn_ajaran']); ?></b>
                                            </td>
                                            <td>
                                            <b> <?php echo htmlentities($row['semester']); ?></b>
                                            </td>
                                            <td>
                                            <span class="badge badge-danger">Belum di ACC</span>
                                            </td>

                                            <td class="text-center">

                                                    <a type="button" href="form?id=<?php echo htmlentities($row['id_bsw']); ?>" class=" btn btn-primary btn-sm btn-icon-only rounded-circle">
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