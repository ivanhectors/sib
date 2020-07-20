<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../login');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    // include("include/header.php");
    // include("include/sidebar.php");


    if (isset($_POST['tambah'])) {
        $kd_fakultas = $_POST["kd_fakultas"];
        $kd_prodi = $_POST["kd_prodi"];
        $nama_prodi = $_POST["nama_prodi"];


        //tambah fakultas
        $sql = mysqli_query($con, "INSERT INTO ref_prodi (kd_fakultas, kd_prodi, nama_prodi) VALUES ('$kd_fakultas', '$kd_prodi', '$nama_prodi')");
        $_SESSION['msg'] = "1";
    } else {
        $_SESSION['msg'] = "0";
    }

    if (isset($_POST['edit'])) {
        $id_prodi = $_POST["id_prodi2"];
        $kd_fakultas = $_POST["kd_fakultas2"];
        $kd_prodi = $_POST["kd_prodi2"];
        $nama_prodi = $_POST["nama_prodi2"];


        //edit fakultas
        $sql = mysqli_query($con, "update ref_prodi set kd_fakultas='$kd_fakultas', kd_prodi='$kd_prodi', nama_prodi='$nama_prodi' where id_prodi='$id_prodi' ");
        $_SESSION['editmsg'] = "1";
    } else {
        $_SESSION['editmsg'] = "0";
    }



    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from ref_prodi where id_prodi = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "1";
    } else {
        $_SESSION['delmsg'] = "0";
    }

?>
    <?php
    include("include/header.php");
    ?>
    <script>
        function userAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_prodi.php",
                data: 'kd_prodi=' + $("#kd_prodi").val(),
                type: "POST",
                success: function(data) {
                    $("#user-availability-status1").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }

        function userAvailability2() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_prodi.php",
                data: 'kd_prodi2=' + $("#kd_prodi2").val(),
                type: "POST",
                success: function(data) {
                    $("#user-availability-status2").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>
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
        <?php if (isset($_POST['tambah'])) {
            if ($_SESSION['msg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Data Hak Akses baru berhasil ditambahkan.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menambah Data Hak Akses baru. Coba sesaat lagi.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
        <?php }
        } ?>

        <?php if (isset($_POST['edit'])) {
            if ($_SESSION['editmsg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Data Hak Akses berhasil diubah.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat mengubah Data Hak Akses baru. Coba sesaat lagi.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
        <?php }
        } ?>

        <?php if (isset($_GET['del'])) {
            if ($_SESSION['delmsg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Hak Akses berhasil dihapus.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menghapus Hak Akses. Coba sesaat lagi.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
        <?php }
        } ?>


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
                                    <li class="breadcrumb-item"><a href="#">Data Master</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Hak Akses</li>
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



        <div class="col-md-4">
            <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card bg-secondary border-0 mb-0">
                                <div class="card-body px-lg-5 py-lg-5">
                                    <div class="text-center text-muted mb-4">
                                        <small>Form Tambah Hak Akses Baru</small>
                                    </div>
                                    <form role="form" method="post">
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                </div>
                                                <select class="form-control" name="kd_fakultas" title="Pilih Fakultas" oninvalid="this.setCustomValidity('Selahkan pilih Fakultas.')" oninput="setCustomValidity('')" required>
                                                    <?php $query2 = mysqli_query($con, "select * from ref_fakultas order by kd_fakultas ASC");
                                                    while ($row = mysqli_fetch_array($query2)) {
                                                    ?>
                                                        <option value="<?php echo htmlentities($row['kd_fakultas']); ?>">Fakultas
                                                            <?php echo htmlentities($row['nama_fakultas']); ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><small class="font-weight-bold">#</small></span>
                                                </div>
                                                <input onBlur="userAvailability()" type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;" id="kd_prodi" name="kd_prodi" class="form-control" maxlength="2" placeholder="Kode Program Studi Baru" title="Masukkan Kode Program Studi" oninvalid="this.setCustomValidity('Selahkan masukkan Kode Program Studi baru.')" oninput="setCustomValidity('')" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="user-availability-status1"></span>
                                                </div>
                                            </div>
                                            <span id="user-availability-status1"></span>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                </div>
                                                <input class="form-control" name="nama_prodi" placeholder="Nama Program Studi Baru" type="text" title="Masukkan Nama Program Studi" oninvalid="this.setCustomValidity('Selahkan masukkan Nama Program Studi baru.')" oninput="setCustomValidity('')" required>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="tambah" name="tambah" class="btn btn-primary my-4">Tambah Hak Akses Baru</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






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
                                    <h3 class="mb-0">Data Hak Akses</h3>
                                </div>
                                <div class="col-6 text-right">
                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Kode Hak Akses</th>
                                        <th>Nama Hak Akses</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $sql = "select * from ref_role order by kd_role ASC";
                                    $stmt = $con->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td class="table-user">
                                                <b> <?php echo htmlentities($row['kd_role']); ?></b>

                                            </td>
                                            <td>
                                                <b> <span class="text-muted"><?php echo htmlentities($row['nama_role']); ?></span></b>
                                            </td>


                                        </tr>
                                        <div class="col-md-4">
                                            <div class="modal fade" id="modal-form2<?php echo $row['id_prodi']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form2" aria-hidden="true">
                                                <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="card bg-secondary border-0 mb-0">
                                                                <div class="card-body px-lg-5 py-lg-5">
                                                                    <div class="text-center text-muted mb-4">
                                                                        <small>Form Ubah Hak Akses</small>
                                                                    </div>
                                                                    <form role="form" method="post">
                                                                        <div class="form-group mb-3">
                                                                            <div class="input-group input-group-merge input-group-alternative">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                                                </div>

                                                                                <select class="form-control" name="kd_fakultas2" title="Pilih Fakultas" oninvalid="this.setCustomValidity('Selahkan pilih Fakultas.')" oninput="setCustomValidity('')" required>
                                                                                    <option value="<?php echo htmlentities($row['kd_fakultas']); ?>">
                                                                                        Fakultas
                                                                                        <?php echo htmlentities($row['nama_fakultas']); ?>
                                                                                    </option>
                                                                                    <?php $query3 = mysqli_query($con, "select * from ref_fakultas order by kd_fakultas ASC");
                                                                                    while ($row1 = mysqli_fetch_array($query3)) {
                                                                                    ?>
                                                                                        <option value="<?php echo htmlentities($row1['kd_fakultas']); ?>">
                                                                                            Fakultas
                                                                                            <?php echo htmlentities($row1['nama_fakultas']); ?>
                                                                                        </option>
                                                                                    <?php } ?>
                                                                                </select>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group mb-3">
                                                                            <div class="input-group input-group-merge input-group-alternative">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><small class="font-weight-bold">#</small></span>
                                                                                </div>
                                                                                <input type="hidden" name="id_prodi2" value="<?php echo $row['id_prodi']; ?>" />
                                                                                <input onBlur="userAvailability2()" type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==2) return false;" id="kd_prodi2" name="kd_prodi2" class="form-control" maxlength="2" value="<?php echo $row['kd_prodi']; ?>" placeholder="Kode Program Studi" title="Masukkan Kode Program Studi" oninvalid="this.setCustomValidity('Selahkan masukkan Kode Program Studi.')" oninput="setCustomValidity('')" required>
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text" id="user-availability-status2"></span>
                                                                                </div>
                                                                            </div>
                                                                            <span id="user-availability-status1"></span>
                                                                        </div>
                                                                        <div class="form-group mb-3">
                                                                            <div class="input-group input-group-merge input-group-alternative">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                                                </div>
                                                                                <input class="form-control" id="nama_prodi2" name="nama_prodi2" placeholder="Nama Program Studi" type="text" value="<?php echo $row['nama_prodi']; ?>" title="Masukkan Nama Program Studi" oninvalid="this.setCustomValidity('Selahkan masukkan Nama Program Studi.')" oninput="setCustomValidity('')" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-center">
                                                                            <button type="submit" id="edit" name="edit" class="btn btn-primary my-4">Edit Hak
                                                                                Akses</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
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
                document.getElementById("close_direct").onclick = function() {
                    location.href = "data_prodi";
                };
            </script>
        </div>
    </div>

    </body>

    </html>
<?php } ?>