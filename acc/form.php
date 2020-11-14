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



    if (isset($_POST['updatepengajuan'])) {
        $status = $_POST["status"];
        $kd_daftar = $_GET["kd_daftar"];
        $acc_role = $_SESSION['role'];
        $acc_id = $_SESSION['id_acc']; 

        // Update Tabel Seleksi PENDAFTARAN
        $query = "UPDATE pendaftaran SET status = ? WHERE kd_daftar = ? ";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $status, $kd_daftar);
        $stmt->execute();
        $stmt->close();
        // Update Tabel Seleksi STS_DAFTAR
        $query2 = "SELECT kd_daftar from sts_daftar where kd_daftar = ? AND acc_id = ?";
        $stmt2 = $con->prepare($query2);
        $stmt2->bind_param("ii", $kd_daftar, $acc_id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        if ($result->num_rows > 0) {
            $queryupdate = "UPDATE sts_daftar SET status = ? WHERE kd_daftar = ? AND acc_id = ?";
            $stmt3 = $con->prepare($queryupdate);
            $stmt3->bind_param("sss", $status, $kd_daftar, $acc_id);
            $stmt3->execute();
            $stmt3->close();
        } else {
            $queryinsert = "INSERT INTO sts_daftar (kd_daftar, acc_role, acc_id, status ) VALUES (?, ?, ?, ?)";
            $stmt3 = $con->prepare($queryinsert);
            $stmt3->bind_param("ssss", $kd_daftar, $acc_role, $acc_id, $status);
            $stmt3->execute();
            $stmt3->close();
        }

        //echo "<script>alert('Number of Rows 0');</script>";

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = "form?id_bsw=" . $_GET['id_bsw'] . "&kd_daftar=" . $_GET['kd_daftar'] . "&total_invoice=" . $_GET['total_invoice'];
        //header('location: form.php?id=2&kd_daftar=.$7216005720201412');
        header("location:http://$host$uri/$extra");
        $_SESSION['success'] = 'Berhasil menyeleksi pendaftaran. Anda dapat mengunjungi halaman riwayat pengajuan untuk melihat kembali keseluruhan data.';
        exit();
    } 


?>
    <?php
    include("include/header.php");
    ?>
    <style>
        .attachment-box {
            display: flex;
            margin: 0 20px 20px 0;
            background-color: #f4f4f4;
            border-radius: 4px 0 4px 4px;
            font-weight: 600;
            padding: 15px 20px;
            padding-bottom: 45px;
            padding-right: 25px;
            line-height: 24px;
            flex-direction: column;
            color: #666;
            position: relative;
            transition: .3s;
            flex: 0 1 calc(50% - 21px);
            cursor: default;
            position: relative
        }

        .single-page-section .attachment-box {
            flex: 0 1 calc(33% - 20px)
        }

        .single-page-section .attachments-container {
            margin-bottom: -20px
        }

        a.attachment-box {
            cursor: pointer
        }

        .attachment-box:before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            border-width: 0 20px 20px 0;
            border-style: solid;
            border-color: rgba(0, 0, 0, .15) #fff;
            transition: .3s;
            border-radius: 0 0 0 4px
        }

        a.attachment-box:hover {
            background-color: #5e72e4;
            color: #fff
        }

        a.attachment-box:hover:before {
            border-color: rgba(0, 0, 0, .25) #fff
        }

        .attachment-box span {
            font-size: 14px;
            line-height: 20px;
            display: inline-block;
            flex: auto
        }

        .attachment-box i {
            display: block;
            font-style: normal;
            font-size: 14px;
            color: #999;
            font-weight: 500;
            margin-top: 10px;
            position: absolute;
            bottom: 10px;
            transition: .3s
        }

        a.attachment-box:hover i {
            color: rgba(255, 255, 255, .7)
        }

        .attachment-box .remove-attachment {
            position: absolute;
            bottom: 10px;
            right: 10px;
            color: #fff;
            background-color: #dc3139;
            box-shadow: 0 3px 8px rgba(234, 65, 81, .15);
            height: 28px;
            width: 28px;
            line-height: 28px;
            border-radius: 3px;
            font-weight: 500;
            font-size: 14px;
            transition: .3s;
            opacity: 0;
            transform: translateY(3px)
        }

        .attachment-box .remove-attachment:before {
            content: "\e9e4";
            font-family: feather-icons
        }

        .attachment-box:hover .remove-attachment {
            opacity: 1;
            transform: translateY(0)
        }

        .ripple-effect,
        .ripple-effect-dark {
            overflow: hidden;
            position: relative;
            z-index: 1
        }

        .ripple-effect span.ripple-overlay,
        .ripple-effect-dark span.ripple-overlay {
            animation: ripple .9s;
            border-radius: 100%;
            background: #fff;
            height: 12px;
            position: absolute;
            width: 12px;
            line-height: 12px;
            opacity: .1;
            pointer-events: none
        }

        .ripple-effect-dark span.ripple-overlay {
            background: #000;
            opacity: .07
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
        <!-- Header & Breadcrumbs -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-12 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Detail Pengajuan</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="../acc?id"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../acc?id">Dashboards</a></li>
                                    <li class="breadcrumb-item"><a href="../acc/beasiswa-kebutuhan">Data Pengajuan</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Batas Header & Breadcrumbs -->


        <!-- Page content -->
        <div class="container-fluid mt--6">
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span> 
                <span data-notify="message">' . $_SESSION['success'] . '</span>
              </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
              <span aria-hidden="true">×</span></button></div>';
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo '<div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                <span data-notify="message">' . $_SESSION['error'] . '</span>
              </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
              <span aria-hidden="true">×</span></button></div>';
                unset($_SESSION['error']);
            }

            ?>
            <div class="row">
                <?php
                $kd_daftar = $_GET['kd_daftar'];
                $query = "select kd_daftar from pendaftaran where kd_daftar=?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $kd_daftar);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {

                ?>
                    <div class="col-lg-8">
                    <?php
                } else {
                    echo '<div class="col-lg-12">';
                }
                    ?>
                    <div class="card mb-4">
                        <!-- Card header -->
                        <div class="card-header">
                            <div class="row align-items-center">
                                <?php
                                $kd_daftar = $_GET['kd_daftar'];
                                $query = "select kd_daftar from pendaftaran where kd_daftar=?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("i", $kd_daftar);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <div class="col-8">
                                            <!-- Title -->
                                            <h3 class="mb-0">Detail Pengajuan Beasiswa</h3>
                                        </div>

                                        <div class="col-4 text-right">

                                            <code class="text-default"><mark class="text-default">Kode Daftar: <?php echo $row['kd_daftar'] ?></mark></code>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '<div class="col-8"><h3 class="mb-0">Form Pengisian Data</h3></div><div class="col-4 text-right"><code class="text-red"><mark>Detail Pengajuan Tidak Ditemukan</code></mark></div>';
                                }
                                ?>

                            </div>
                        </div>

                        <!-- Card body -->
                        <div class="card-body">
                            <!-- Batas Awal Header Info -->
                            <?php
                            $kd_daftar = $_GET['kd_daftar'];
                            $query = "SELECT
                    pendaftaran.kd_daftar AS kd_daftar
                    , pendaftaran.tgl_daftar As tgl_daftar
                    , pendaftaran.nominal_disetujui AS status
                    , beasiswa.nama_bsw AS nm_beasiswa
                    , beasiswa.dtl_bsw AS dtl_bsw
                    FROM pendaftaran
                    JOIN beasiswa ON (
                    pendaftaran.kd_bsw = beasiswa.id_bsw ) WHERE pendaftaran.kd_daftar =?";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("i", $kd_daftar);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                            ?>

                                    <h6 class="heading-small text-muted mb-4">Informasi Beasiswa</h6>
                                    <div class="card bg-gradient-default">
                                        <div class="card-body">
                                            <h3 class="card-title text-white"><?php echo $row['nm_beasiswa'] ?></h3>
                                            <blockquote class="blockquote text-white mb-0">
                                                <p><?php echo $row['dtl_bsw'] ?></p>
                                                <footer class="blockquote-footer text-danger">Tanggal Pengajuan : <cite title="Source Title"><?php $date = $row['tgl_daftar'];
                                                                                                                                                echo date('d-m-Y', strtotime($date)); ?></cite></footer>
                                            </blockquote>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- Batas Akhir Header Info -->

                                <!-- Batas Awal Info Pribadi Mahasiswa -->

                                <?php
                                $kd_daftar = $_GET['kd_daftar'];
                                $query = "SELECT
                                user_mhs.nim
                                , user_mhs.nama_mhs
                                , user_mhs.email
                                , user_mhs.no_telp
                                , pendaftaran.kd_daftar
                                FROM user_mhs
                                JOIN pendaftaran 
                                WHERE pendaftaran.kd_daftar = ? AND pendaftaran.id_mhs = user_mhs.id_mhs";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("s", $kd_daftar);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {

                                    while ($row = $result->fetch_assoc()) {
                                ?>

                                        <h6 class="heading-small text-muted mb-4">Informasi Pribadi</h6>
                                        <div class="form-group row">
                                            <label for="nim" class="col-md-6 col-form-label form-control-label">NIM</label>
                                            <div class="col-md-6">
                                                <input class="form-control" type="text" value="<?php echo $row['nim'] ?>" id="nim" placeholder="NIM" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama" class="col-md-6 col-form-label form-control-label">Nama Mahasiswa</label>
                                            <div class="col-md-6">
                                                <input class="form-control" type="text" value="<?php echo $row['nama_mhs'] ?>" id="nama" placeholder="Nama Mahasiswa" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-md-6 col-form-label form-control-label">Email</label>
                                            <div class="col-md-6">
                                                <input class="form-control" type="text" value="<?php echo $row['email'] ?>" id="nama" placeholder="Email" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="notelp" class="col-md-6 col-form-label form-control-label">No. Telpon Anda</label>
                                            <div class="col-md-6">
                                                <input class="form-control" type="text" value="<?php echo $row['no_telp'] ?>" id="telp" placeholder="Telpon Mahasiswa" disabled>
                                            </div>
                                        </div>

                                    <?php } ?>
                                    <hr class="my-4" />
                                    <!-- Batas Akhir Info Pribadi Mahasiswa -->
                                    <?php
                                    $kd_daftar = $_GET['kd_daftar'];
                                    $query = "select * from pendaftaran where kd_daftar=?";
                                    $stmt = $con->prepare($query);
                                    $stmt->bind_param("i", $kd_daftar);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {

                                        while ($row = $result->fetch_assoc()) {
                                    ?>

                                            <!-- Batas Awal Pengisian Form Manual -->
                                            <h6 class="heading-small text-muted mb-4">Pengisian Form</h6>
                                            <div class="form-group row">
                                                <label for="ipk" class="col-md-6 col-form-label form-control-label">IPK</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" value="<?php echo $row['ipk'] ?>" id="ipk" placeholder="IPK" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="semester_ke" class="col-md-6 col-form-label form-control-label">Semester</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" value="<?php echo $row['semester_ke'] ?>" id="semester_ke" placeholder="Semester" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="no-telp-ortu" class="col-md-6 col-form-label form-control-label">No. Telpon Orang Tua</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" value="<?php echo $row['no_telp_ortu'] ?>" id="no-telp-ortu" placeholder="No Telp Orangtua" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pekerjaan-ortu" class="col-md-6 col-form-label form-control-label">Pekerjaan Orangtua</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" value="<?php echo $row['pekerjaan_ortu'] ?>" id="pekerjaan-ortu" placeholder="Pekerjaan Orangtua" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="gaji-ortu" class="col-md-6 col-form-label form-control-label">Gaji Orangtua</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" value="<?php $angka = $row['gaji_ortu'];
                                                                                                    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                                                                                                    echo $hasil_rupiah;
                                                                                                    ?>" id="gaji-ortu" placeholder="Gaji Orangtua" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nominal" class="col-md-6 col-form-label form-control-label">Nominal Invoice Registrasi</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" value="<?php function rupiah($angka)
                                                                                                    {

                                                                                                        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                                                                                                        return $hasil_rupiah;
                                                                                                    }
                                                                                                    echo rupiah($row['nominal_pengajuan']);  ?>" id="nominal" placeholder="Nominal" disabled>
                                                </div>
                                            </div>


                                    <?php
                                        }
                                    }
                                    ?>


                                    <!-- Batas Akhir Pengisian Form Manual -->

                                    <hr class="my-4" />
                                    <!-- Batas Awal Persyaratan Berkas -->
                                    <h6 class="heading-small text-muted mb-4">Berkas Persyaratan</h6>
                                    <div class="row">
                                        <?php
                                        $kd_daftar = $_GET['kd_daftar'];
                                        $sql_syarat = "SELECT
                                            syarat_daftar.isi_syarat As isi_syarat
                                            , pendaftaran.kd_daftar AS kd_daftar
                                            FROM pendaftaran
                                            JOIN syarat_daftar WHERE pendaftaran.kd_daftar = syarat_daftar.kd_daftar AND
                                            syarat_daftar.kd_daftar =?";
                                        $stmt = $con->prepare($sql_syarat);
                                        $stmt->bind_param("s", $kd_daftar);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                        ?>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <a href="readfile.php?file=<?php echo $row['isi_syarat'] ?>" class="margin-top-10 attachment-box ripple-effect" target="_blank">
                                                            <span><?php echo $row['isi_syarat'] ?></span>
                                                            <i>PDF</i>

                                                        </a>
                                                    </div>
                                                </div>

                                        <?php
                                            }
                                        } else {
                                            echo '<footer class="blockquote-footer text-danger"><cite title="Source Title">Berkas persyaratan tidak ada atau tidak dilampirkan.</cite></footer>';
                                        }
                                        ?>

                                    </div>
                                    <!-- Batas Akhir Persyaratan Berkas -->

                                    <!-- <div class="text-right pb-0">
                                        <button type="submit" id="submit" name="file_array" class="btn btn-icon btn-primary text-white my-4 <?php
                                                                                                                                            if ($result->num_rows > 1) {
                                                                                                                                                echo "disabled";
                                                                                                                                            }
                                                                                                                                            ?>" type="button">
                                            <span class="btn-inner--icon"><i class="fas fa-paper-plane"></i></span>
                                            <span class="btn-inner--text">Submit Form</span>
                                        </button>

                                        <a type="button" href="../mhs/pengajuan" class="btn btn-icon btn-danger text-white my-4" type="button">
                                            <span class="btn-inner--icon"><i class="fas fa-times"></i></span>
                                            <span class="btn-inner--text">Batal</span>
                                        </a>
                                    </div> -->
                            <?php }
                            } elseif ($result->num_rows > 1) {
                                $hasil = "duplikat";
                            } else {
                                echo '<div class="card bg-dark text-white border-0">
                            <img class="card-img" src="../assets/img/cari-mahasiswa-gagal.jpg" alt="Mahasiswa Tidak Ditemukan">
                            <div class="card-img-overlay align-items-center">
                            <div>
                            <center>
                                <!-- <h5 class="h2 card-title text-white mb-2">Cari Mahasiswa</h5> -->
                                <div class="form-group col-md-6 mt-2">
                                </div>
                            </center>
                        </div>
                            </div>
                            </div>';
                            } ?>
                        </div>
                    </div>


                    </div>
                    <?php
                    $kd_daftar = $_GET['kd_daftar'];
                    $query = "SELECT kd_daftar, tgl_daftar FROM pendaftaran WHERE pendaftaran.kd_daftar =?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("i", $kd_daftar);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                    ?>

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header bg-transparent">
                                        <h3 class="mb-0">Jejak Pengajuan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">

                                            <div class="timeline-block">
                                                <span class="timeline-step badge-success">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <span class="badge badge-pill badge-success">selesai</span>
                                                    <h5 class=" mt-3 mb-0">Mengisi Formulir</h5>
                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold"><?php $date = $row['tgl_daftar'];
                                                                                                    echo date('d-m-Y g:i A', strtotime($date)); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        $kd_daftar = $_GET['kd_daftar'];
                                        $status1 = "acc-wakil-dekan";
                                        $status2 = "ditolak";
                                        $acc_id = $_SESSION['id_acc'];
                                        $query = "SELECT * FROM sts_daftar WHERE kd_daftar = ? and acc_id = ? and status is not null LIMIT 1";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("ii", $kd_daftar, $acc_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <div class="timeline-block">
                                                <span class="timeline-step badge-<?php $status = $row['status'];
                                                                                    echo ($status == "acc-wakil-dekan" ? "success" : "danger") ?>">
                                                    <i class="fas fa-<?php $status = $row['status'];
                                                                        echo ($status == "acc-wakil-dekan" ? "check" : "exclamation") ?>"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <span class="badge badge-pill badge-<?php $status = $row['status'];
                                                                                        echo ($status == "acc-wakil-dekan" ? "success" : "danger") ?>"><?php $status = $row['status'];
                                                                                                                                                        echo ($status == "acc-wakil-dekan" ? "DITERIMA" : "DITOLAK") ?></span>
                                                    <h5 class=" mt-3 mb-0">Status Seleksi Anda </h5>

                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold"><?php $date = $row['acc_tanggal'];
                                                                                                    echo date('d-m-Y g:i A', strtotime($date)); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        $kd_daftar = $_GET['kd_daftar'];
                                        $acc_wakil_dekan = 'acc-wakil-dekan';
                                        $query = "SELECT * FROM pendaftaran WHERE kd_daftar = ? and status = ? LIMIT 1";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("is", $kd_daftar, $acc_wakil_dekan);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <div class="timeline-block">
                                                <span class="timeline-step badge-warning">
                                                    <i class="fas fa-history"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <span class="badge badge-pill badge-warning">DIPROSES</span>
                                                    <h5 class=" mt-3 mb-0">Status Pengajuan</h5>

                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold">00-00-0000 00:00 --</small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        $kd_daftar = $_GET['kd_daftar'];
                                        $status1 = 'diterima';
                                        $query = "SELECT * FROM pendaftaran WHERE kd_daftar = ? and status = ? LIMIT 1";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("is", $kd_daftar, $status1);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <div class="timeline-block">
                                                <span class="timeline-step badge-success">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <span class="badge badge-pill badge-success">DITERIMA</span>
                                                    <h5 class=" mt-3 mb-0">Status Pengajuan</h5>

                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold"><?php $date = $row['tgl_update'];
                                                                                                    echo date('d-m-Y g:i A', strtotime($date)); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>


                                        <?php
                                        $kd_daftar = $_GET['kd_daftar'];
                                        $status = 'ditolak';
                                        $query = "SELECT * FROM pendaftaran WHERE kd_daftar = ? and status = ? LIMIT 1";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("is", $kd_daftar, $status);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <div class="timeline-block">
                                                <span class="timeline-step badge-danger">
                                                    <i class="fas fa-exclamation"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <span class="badge badge-pill badge-danger">DITOLAK</span>
                                                    <h5 class=" mt-3 mb-0">Status Pengajuan</h5>

                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold"><?php $date = $row['tgl_update'];
                                                                                                    echo date('d-m-Y g:i A', strtotime($date)); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>


                                        </div>
                                    </div>
                                </div>

                                <!-- Batas Form Pembayaran Pinjaman -->

                                <div class="card bg-gradient-default">
                                    <div class="card-header bg-transparent">
                                        <h3 class="mb-0 text-white">Status Pengajuan</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" enctype="multipart/form-data">
                                            <!-- Multiple -->
                                            <div class="form-group">

                                                <?php
                                                $kd_daftar = $_GET['kd_daftar'];
                                                $acc_id = $_SESSION['id_acc'];
                                                $query = "SELECT 
                                                pendaftaran.kd_daftar
                                                , sts_daftar.acc_id
                                                , sts_daftar.acc_tanggal
                                                , sts_daftar.status
                                                FROM pendaftaran
                                                JOIN sts_daftar
                                                WHERE pendaftaran.kd_daftar = sts_daftar.kd_daftar AND sts_daftar.kd_daftar = ? AND sts_daftar.acc_id= ? LIMIT 1";
                                                $stmt = $con->prepare($query);
                                                $stmt->bind_param("ss", $kd_daftar, $acc_id);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                ?>
                                                        <label class="form-control-label text-white" for="status">Status Seleksi Anda :</label>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <?php $status = $row['status'];
                                                                    if ($status == 'ditolak') :
                                                                    ?>
                                                                        <div class="input-group input-group-merge">
                                                                            <input class="form-control" type="text" value="Ditolak" disabled>
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"><i class="fas fa-times-circle text-danger"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <div class="input-group input-group-merge">
                                                                            <input class="form-control" type="text" value="Diterima" disabled>
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"><i class="fas fa-check-circle text-success"></i></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                </div>
                                                                <label class="form-control-label text-white">Tanggal Seleksi Anda :</label>
                                                                <label class="form-control-label text-white"><?php
                                                                                                                $tanggal = $row['acc_tanggal'];
                                                                                                                echo date('d-m-Y G:i:s', strtotime($tanggal));
                                                                                                                ?></label>
                                                            </div>
                                                        </div>
                                                        <label class="form-control-label text-white" for="status">Ubah pengajuan ini?</label>
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <select class="form-control" name="status" type="text" id="status" placeholder="Pilih Status Seleksi" title="Silahkan pilih status seleksi anda." oninvalid="this.setCustomValidity('Silahkan pilih status seleksi anda.')" oninput="setCustomValidity('')" required>
                                                                    <option selected="selected" value="" disabled>-- Pilih Status Pengajuan --</option>
                                                                    <option value="acc-wakil-dekan">Terima</option>
                                                                    <option value="ditolak">Tolak</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="text-right  pb-0 pb-md-4">
                                                            <div>
                                                                <!-- <button type="submit" name="gambar" class="btn btn-sm btn-white float-right">UPLOAD</button> -->
                                                                <button type="button" data-toggle="modal" data-target="#modal-verification" class="btn btn-icon btn-white float-right btn-block">
                                                                    <span class="btn-inner--icon"><i class="fas fa-cloud-upload-alt"></i></span>
                                                                    <span class="btn-inner--text">Update Pengajuan</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                } else { ?>
                                                    <label class="form-control-label text-white" for="status">Terima pengajuan ini?</label>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="status" type="text" id="status" placeholder="Pilih Status Seleksi" title="Silahkan pilih status seleksi anda." oninvalid="this.setCustomValidity('Silahkan pilih status seleksi anda.')" oninput="setCustomValidity('')" required>
                                                                <option selected="selected" value="" disabled>-- Pilih Status Pengajuan --</option>
                                                                <option value="acc-wakil-dekan">Terima</option>
                                                                <option value="ditolak">Tolak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="text-right  pb-0 pb-md-4">
                                                        <div>
                                                            <!-- <button type="submit" name="gambar" class="btn btn-sm btn-white float-right">UPLOAD</button> -->
                                                            <button type="button" data-toggle="modal" data-target="#modal-verification" class="btn btn-icon btn-white float-right btn-block">
                                                                <span class="btn-inner--icon"><i class="fas fa-cloud-upload-alt"></i></span>
                                                                <span class="btn-inner--text">Update Pengajuan</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>


                                            <!-- Modal Verification -->
                                            <div class="modal fade" id="modal-verification" tabindex="-1" role="dialog" aria-labelledby="modal-verification" aria-hidden="true">
                                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                                    <div class="modal-content bg-gradient-danger">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="modal-title-notification">Yakin dengan pilihan anda?</h6>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="py-3 text-center">
                                                                <i class="ni ni-bell-55 ni-3x"></i>
                                                                <h4 class="heading mt-4">Ketentuan dalam menyeleksi pengajuan</h4>
                                                                <p>Menyeleksi pengajuan ini berarti mengubah status pengajuan tersebut. Pastikan untuk tidak mengganti keputusan seleksi anda setelah pengajuan beasiswa ditutup.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="updatepengajuan" class="btn btn-white">Mengerti & Ubah Pengajuan</button>
                                                            <button class="btn btn-link text-white ml-auto" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>




                            </div>
                        <?php
                    } else {
                        '';
                    } ?>
            </div>




            <?php
            include("include/footer.php"); //Edit topnav on this page
            ?>

            <script type="text/javascript">
                document.getElementById("close_direct").onclick = function() {
                    location.href = "cari_mahasiswa?carimhs=<?php echo $carimahasiswa ?>";
                };
            </script>
            <script>
                $(document).on('change', '.custom-file-input', function(event) {
                    $(this).next('.custom-file-label').html(event.target.files[0].name);
                })
            </script>

            <script>
                var nominal = document.getElementById("nominal");

                nominal.value = convertRupiah(this.value, "Rp. ");


                function convertRupiah(angka, prefix) {
                    var number_string = angka.replace(/[^,\d]/g, "").toString(),
                        split = number_string.split(","),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? "." : "";
                        rupiah += separator + ribuan.join(".");
                    }

                    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                    return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
                }

                function isNumberKey(evt) {
                    key = evt.which || evt.keyCode;
                    if (key != 188 // Comma
                        &&
                        key != 8 // Backspace
                        &&
                        key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
                        &&
                        (key < 48 || key > 57) // Non digit
                    ) {
                        evt.preventDefault();
                        return;
                    }
                }
            </script>

        </div>
    </div>

    </body>

    </html>
<?php } ?>