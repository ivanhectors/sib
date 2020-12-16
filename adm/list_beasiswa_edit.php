<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../403');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    // include("include/header.php");
    // include("include/sidebar.php");
    $parentpage = "beasiswa";
    $childpage = "list_persyaratan_beasiswa";

    if (isset($_POST['edit'])) {
        $id_bsw = $_POST["id_bsw"];
        $kd_bsw = $_POST["kd_bsw"];
        $nama_bsw = $_POST["nama_bsw"];
        $dtl_bsw = $_POST["dtl_bsw"];
        $start_date = $_POST['tgl_buka'];
        $end_date = $_POST["tgl_tutup"];
        //$tgl_lahir = date('d-m-Y', strtotime($date));
        $tgl_buka = (new DateTime($start_date))->format('Y-m-d');
        $tgl_tutup = (new DateTime($end_date))->format('Y-m-d');

        //edit fakultas
        $sql = mysqli_query($con, "update beasiswa set kd_bsw='$kd_bsw', nama_bsw='$nama_bsw', dtl_bsw='$dtl_bsw', tgl_buka='$tgl_buka',tgl_tutup='$tgl_tutup' where id_bsw='$id_bsw'");
        $sql .= mysqli_query($con, "DELETE FROM syarat_bsw WHERE kd_bsw = '$id_bsw'");

        $checkbox = $_POST['syarat'];
        for ($i = 0; $i < count($checkbox); $i++) {
            $check_id = $checkbox[$i];
            mysqli_query($con, "INSERT INTO syarat_bsw (kd_syarat, kd_bsw) values ('" . $check_id . "','" . $id_bsw . "')");
        }



        $_SESSION['editmsg'] = "1";
    } else {
        $_SESSION['editmsg'] = "0";
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
                                    <li class="breadcrumb-item"><a href="../adm/list_beasiswa">Beasiswa</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Beasiswa</li>
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
            <div class="card mb-4">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Form Edit Data Beasiswa</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <!-- Form groups used in grid -->
                    <?php
                    $id_bsw = $_GET['id_bsw'];
                    $query = "select * from beasiswa where id_bsw=?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("i", $id_bsw);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <form role="form" method="post">
                            <!-- Address -->
                            <h6 class="heading-small text-muted mb-4">Informasi Beasiswa</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="kd_bsw">Kode Beasiswa</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><small class="font-weight-bold">@</small></span>
                                            </div>
                                            <input id="kd_bsw" name="kd_bsw" value="<?php echo $row['kd_bsw'] ?>" class="form-control" placeholder="Username Kode Beasiswa" type="text" title="Masukkan Kode Beasiswa" oninvalid="this.setCustomValidity('Selahkan masukkan Kode Beasiswa.')" oninput="setCustomValidity('')" required>
                                        </div>
                                        <input id="id_bsw" name="id_bsw" value="<?php echo $row['id_bsw'] ?>" type="hidden" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="nama_bsw">Nama Beasiswa</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                            </div>
                                            <input type="text" name="nama_bsw" class="form-control" value="<?php echo $row['nama_bsw'] ?>" id="nama_bsw" placeholder="Nama Beasiswa">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="dtl_bsw">Detail Beasiswa</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                            </div>
                                            <textarea name="dtl_bsw" class="form-control" id="dtl_bsw" placeholder="Detail Beasiswa" rows="3" resize="none"><?php echo $row['dtl_bsw'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="tgl_buka">Tanggal Buka</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input name="tgl_buka" class="form-control" id="tgl_buka" data-provide="datepicker" value="<?php $date = $row['tgl_buka']; echo date('d-m-Y', strtotime($date)); ?>" data-date-format="dd-mm-yyyy" placeholder="Pilih Tanggal Buka" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="tgl_tutup">Tanggal Tutup</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input name="tgl_tutup" class="form-control" id="tgl_tutup" data-provide="datepicker" value="<?php $date = $row['tgl_tutup']; echo date('d-m-Y', strtotime($date)); ?>" data-date-format="dd-mm-yyyy" placeholder="Pilih Tanggal Tutup" type="text">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr class="my-4" />
                            <!-- Address -->
                            <h6 class="heading-small text-muted mb-4">Informasi Syarat Beasiswa</h6>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="syarat">Pilih Syarat Beasiswa</label>
                                        <?php
                                        $id_bsw = $_GET['id_bsw'];
                                        $sql_syarat = mysqli_query($con, "SELECT
                                        ref_syarat.kd_syarat AS kd_syarat
                                      , ref_syarat.nama_syarat As nama_syarat
                                      , syarat_bsw.kd_bsw AS checked
                                      FROM ref_syarat
                                      LEFT JOIN syarat_bsw ON (
                                        ref_syarat.kd_syarat = syarat_bsw.kd_syarat
                                        AND kd_bsw= '" . $id_bsw . "'
                                      )");

                                        if (mysqli_num_rows($sql_syarat) > 0) {
                                            while ($row = mysqli_fetch_assoc($sql_syarat)) {
                                        ?>
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input class="custom-control-input" name="syarat[]" value="<?php echo ($row['kd_syarat']) ?>" id="customCheck<?php echo ($row['kd_syarat']) ?>" type="checkbox" <?php $checked = $row['checked'];
                                                                                                                                                                                                                    if ($checked == "" || $checked == "NULL") :
                                                                                                                                                                                                                    ?> <?php else : ?> checked <?php endif; ?>>
                                                    <label class="custom-control-label" for="customCheck<?php echo ($row['kd_syarat']) ?>"><?php echo ($row['nama_syarat']) ?></label>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>


                            <div class="text-right pb-0">
                                <button type="submit" id="edit" name="edit" class="btn btn-primary my-4">Edit Data</button>
                                <a type="button" href="../adm/list_beasiswa" class="btn btn-danger my-4">Batal</a>
                            </div>
                        <?php } ?>
                        </form>
                </div>
            </div>


            <?php
            include("include/footer.php"); //Edit topnav on this page
            ?>

            <script type="text/javascript">
                document.getElementById("close_direct").onclick = function() {
                    location.href = "list_beasiswa_edit";
                };
            </script>
            <script>
                $('.select2').select2();
            </script>
            <script src="js/fakultas-prodi.js"></script>

            <script>
                $.fn.datepicker.defaults.format = "yyyy/mm/dd";
            </script>
            
        </div>
    </div>

    </body>

    </html>
<?php } ?>