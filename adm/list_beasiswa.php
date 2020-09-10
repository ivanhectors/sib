<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../login');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    $parentpage = "beasiswa";
    $childpage = "list_beasiswa";

    if (isset($_POST['tambah'])) {
        $kd_bsw = $_POST["kd_bsw"];
        $nama_bsw = $_POST["nama_bsw"];
        $dtl_bsw = $_POST["dtl_bsw"];
        $tgl_buka = $_POST["tgl_buka"];
        $tgl_tutup = $_POST["tgl_tutup"];


        //tambah beasiswa
        $sql = mysqli_query($con, "INSERT INTO beasiswa (kd_bsw, nama_bsw, dtl_bsw, tgl_buka, tgl_tutup) VALUES ('$kd_bsw', '$nama_bsw', '$dtl_bsw', '$tgl_buka','$tgl_tutup')");
        $_SESSION['msg'] = "1";
    } else {
        $_SESSION['msg'] = "0";
    }

    if (isset($_POST['edit'])) {
        $id_bsw = $_POST["id_bsw2"];
        $kd_bsw = $_POST["kd_bsw2"];
        $nama_bsw = $_POST["nama_bsw2"];
        $dtl_bsw = $_POST["dtl_bsw2"];
        $tgl_buka = $_POST["tgl_buka2"];
        $tgl_tutup = $_POST["tgl_tutup2"];


        //edit fakultas
        $sql = mysqli_query($con, "update beasiswa set kd_bsw='$kd_bsw', nama_bsw='$nama_bsw', dtl_bsw='$dtl_bsw', tgl_buka='$tgl_buka',tgl_tutup='$tgl_tutup' where id_bsw='$id_bsw'");
        $_SESSION['editmsg'] = "1";
    } else {
        $_SESSION['editmsg'] = "0";
    }

    if (isset($_GET['on'])) {
        mysqli_query($con, "update beasiswa set tampilkan='1' where id_bsw = '" . $_GET['id'] . "'");
        $_SESSION['stsmsg1'] = "1";
    } else {
        $_SESSION['stsmsg1'] = "0";
    }

    if (isset($_GET['off'])) {
        mysqli_query($con, "update beasiswa set tampilkan='0' where id_bsw = '" . $_GET['id'] . "'");
        $_SESSION['stsmsg'] = "1";
    } else {
        $_SESSION['stsmsg'] = "0";
    }

    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from beasiswa where id_bsw = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "1";
    } else {
        $_SESSION['delmsg'] = "0";
    }

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
        <?php if (isset($_POST['tambah'])) {
            if ($_SESSION['msg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Data Beasiswa baru berhasil ditambahkan.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menambah Data Beasiswa baru. Coba sesaat lagi.</span>
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
                        <span data-notify="message">Data Beasiswa berhasil diubah.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat mengubah Data Beasiswa baru. Coba sesaat lagi.</span>
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
                        <span data-notify="message">Beasiswa berhasil dihapus.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menghapus Beasiswa. Coba sesaat lagi.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
        <?php }
        } ?>

        <?php if (isset($_GET['on'])) {
            if ($_SESSION['stsmsg1'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Beasiswa berhasil di tampilkan pada keseluruhan sistem.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menampilkan beasiswa. Coba sesaat lagi.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
        <?php }
        } ?>


        <?php if (isset($_GET['off'])) {
            if ($_SESSION['stsmsg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Beasiswa berhasil di sembunyikan pada keseluruhan sistem.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat me-nyembunyikan beasiswa. Coba sesaat lagi.</span>
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
                                    <li class="breadcrumb-item"><a href="#">Beasiswa</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Beasiswa</li>
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
                                        <small>Form Tambah Beasiswa Baru</small>
                                    </div>
                                    <form role="form" method="post">
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><small class="font-weight-bold">#</small></span>
                                                </div>
                                                <input type="text" id="kd_bsw" name="kd_bsw" class="form-control" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" placeholder="Kode Beasiswa Baru" title="Masukkan Kode Beasiswa" oninvalid="this.setCustomValidity('Selahkan masukkan Kode Beasiswa baru.')" oninput="setCustomValidity('')" required>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">

                                                <input class="form-control" name="nama_bsw" placeholder="Nama Beasiswa Baru" type="text" title="Masukkan Nama Beasiswa" oninvalid="this.setCustomValidity('Selahkan masukkan Nama Beasiswa baru.')" oninput="setCustomValidity('')" required>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">

                                                <textarea class="form-control" name="dtl_bsw" placeholder="Detail Beasiswa Baru" rows="3" resize="none"></textarea>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-control-label">Tanggal Buka</label>
                                                    <input class="form-control" name="tgl_buka" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Pilih Tanggal" type="text">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-control-label">Tanggal Tutup</label>
                                                    <input class="form-control" name="tgl_tutup" data-provide="datepicker" data-date-format="yyyy-mm-dd" placeholder="Pilih Tanggal" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="tambah" name="tambah" class="btn btn-primary my-4">Tambah Beasiswa Baru</button>
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
                                    <h3 class="mb-0">Data Beasiswa</h3>
                                </div>
                                <div class="col-6 text-right">
                                    <a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-primary btn-round btn-icon" style="color:white;">
                                        <span class="btn-inner--icon"><i class="fas fa-user-plus" style="color:white;"></i></span>
                                        <span class="btn-inner--text" style="color:white;">Tambah Beasiswa Baru</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Kode Beasiswa</th>
                                        <th>Nama Beasiswa</th>
                                        <th>Tanggal Buka</th>
                                        <th>Tanggal Tutup</th>
                                        <th>Tampilkan</th>
                                        <th>Pilihan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php

                                    $sql = "select * from beasiswa order by id_bsw ASC";
                                    $stmt = $con->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td class="table-user">
                                                <b> <?php echo htmlentities($row['kd_bsw']); ?></b>

                                            </td>
                                            <td>
                                                <b> <span class="text-muted"><?php $dtl_bsw_row = htmlentities($row['nama_bsw']);
                                                                                if (strlen($dtl_bsw_row) > 23) $dtl_bsw_row = substr($dtl_bsw_row, 0, 23) . "...";
                                                                                echo $dtl_bsw_row;

                                                                                ?></span></b>
                                            </td>
                                            
                                            <td class="table-user">
                                                <b> <?php
                                                    $tanggal = $row['tgl_buka'];
                                                    echo date('d-m-Y', strtotime($tanggal));
                                                    ?></b>

                                            </td>
                                            <td class="table-user">
                                                <b> <?php
                                                    $tanggal = $row['tgl_tutup'];
                                                    echo date('d-m-Y', strtotime($tanggal));
                                                    ?></b>
                                            </td>
                                            <td>
                                                <?php $status = $row['tampilkan'];
                                                if ($status > 0) {
                                                    echo '<span class="badge badge-success">Aktif</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">Tidak Aktif</span>';
                                                }
                                                ?>
                                            </td>

                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <?php $tampilkan = $row['tampilkan'];
                                                        if ($tampilkan > 0) :
                                                        ?>
                                                            <a class="dropdown-item" href="list_beasiswa?id=<?php echo $row['id_bsw']; ?>&off=0"><i class="fas fa-eye-slash" style="color:#fb6340;"></i>Sembunyikan Beasiswa</a>
                                                        <?php else : ?>
                                                            <a class="dropdown-item" href="list_beasiswa?id=<?php echo $row['id_bsw']; ?>&on=1"><i class="fas fa-eye" style="color:#5e72e4;"></i>Tampilkan Beasiswa</span></a>
                                                        <?php endif; ?>
                                                        <a class="dropdown-item" href="list_beasiswa_edit?id_bsw=<?php echo $row['id_bsw'] ?>" type="button"> <i class="fas fa-pen" style="color:#172b4d;"></i>Edit Beasiswa</span></a>
                                                        <a class="dropdown-item" href="list_beasiswa?id=<?php echo $row['id_bsw'] ?>&del=delete" onClick="return confirm('Yakin ingin menghapus, Beasiswa <?php echo htmlentities($row['nama_bsw']); ?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Hapus Beasiswa</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
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
                    location.href = "list_beasiswa";
                };
            </script>
        </div>
    </div>

    </body>

    </html>
<?php } ?>