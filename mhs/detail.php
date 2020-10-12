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


    // Mengambil data Genap/Gasal berdasarkan Tahun saat ini dan Bulan saat ini
    $year = date('Y');
    $bulan_ini = date('n');
    if ($bulan_ini <= 6) {
        $bulan_ini = 'Genap';
    } else {
        $bulan_ini = 'Gasal';
    }

    // Membuat Format nama file "Semester = 2020_Gasal" record pada inputan file
    $string_gabungan = $year . "_" . $bulan_ini;
    $semester = $string_gabungan;

    // Membuat output semester menjadi 1 / 2 alias dari Gasal / Genap
    $semester_ini = date('n');
    if ($semester_ini <= 6) {
        $semester_ini = '2';
    } else {
        $semester_ini = '1';
    }

    // Membuat periode tahun ajaran seperti 2020/2021 pada inputan database
    $periode_tahun = date('n');
    if ($periode_tahun <= 6) {
        $periode_tahun = intval($year - 1) . "/" . $year;
    } else {
        $periode_tahun = $year . "/" . intval($year + 1);
    }

    // Membuat Uniq ID pada belakang KD_DAFTAR 
    $digits = 3;
    $unik_number = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
    $limit = 2 * 1024 * 1024; //10MB. Bisa diubah2
    $nim = $_SESSION['id_mhs'];

    if (isset($_FILES['syarat'])) {
        //karena ada multiple, jadi dilakukan pengecekan foreach


        $namasyarat2 = $_POST["nama_syarat"];
        $name_array = $_FILES['syarat']['name'];
        $tmp_name_array = $_FILES['syarat']['tmp_name'];
        $type_array = $_FILES['syarat']['type'];
        $size_array = $_FILES['syarat']['size'];
        $error_array = $_FILES['syarat']['error'];

        $kd_daftar = $nim . $year . $semester_ini . $unik_number;
        $kd_syarat_bsw = $_POST['kd_syarat_bsw'];
        $namasyarat2 = $_POST["nama_syarat"];


        $kd_bsw = $_GET["id"];
        $ipk = $_POST["ipk"];
        $no_telp_ortu = $_POST["no_telp_ortu"];

        $nominal_input = $_POST["nominal"];
        $output = str_replace('.', '', $nominal_input);
        $nominal = trim($output, '');

        $pekerjaan_ortu = $_POST["pekerjaan_ortu"];

        $registrasi = $con->prepare("INSERT INTO pendaftaran (kd_daftar, nim, kd_bsw, ipk, no_telp_ortu, pekerjaan_ortu, semester, thn_ajaran, nominal_pengajuan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $registrasi->bind_param('ssisisssi', $kd_daftar, $nim, $kd_bsw, $ipk, $no_telp_ortu, $pekerjaan_ortu, $bulan_ini, $periode_tahun, $nominal);
        /* execute prepared statement */
        $registrasi->execute();
        printf("%d Row inserted.\n", $registrasi->affected_rows);
        /* close statement */
        $registrasi->close();

        for ($i = 0; $i < count($kd_syarat_bsw); $i++) {
            $check_id = $kd_syarat_bsw[$i];
            $filename2   = $nim . "_" . $namasyarat2[$i] . "_" . $semester . "_" . uniqid() . "_" . time();
            $extension  = pathinfo($name_array[$i], PATHINFO_EXTENSION); // mengambil ekstensi .pdf
            $basename2   = $filename2 . "." . $extension;

            $stmt = $con->prepare("INSERT INTO syarat_daftar (kd_daftar, kd_syarat_bsw, isi_syarat) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $kd_daftar, $check_id, $basename2);
            /* execute prepared statement */
            $stmt->execute();
            printf("%d Row inserted.\n", $stmt->affected_rows);
            /* close statement */
            $stmt->close();
            // mysqli_query($con, "INSERT INTO syarat_daftar (kd_daftar, kd_syarat_bsw, isi_syarat) values ('" . $kd_daftar . "','" . $check_id . "','" . $basename2 . "')");
            move_uploaded_file($tmp_name_array[$i], "file/" . $basename2);
        }
        $_SESSION['success'] = 'Berhasil mengupload seluruh file';
        header('location: form.php?id=1');
        exit();
    }



    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from user_mhs where id_mhs = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "1";
    } else {
        $_SESSION['delmsg'] = "0";
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
                                    <li class="breadcrumb-item"><a href="../mhs?id"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../mhs?id">Dashboards</a></li>
                                    <li class="breadcrumb-item"><a href="../mhs/riwayat_pengajuan">Riwayat Pengajuan</a></li>
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
                                $nim = $_SESSION['id_mhs'];
                                $query = "select * from user_mhs where id_mhs=?";
                                $stmt = $con->prepare($query);
                                $stmt->bind_param("s", $nim);
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
                                        <footer class="blockquote-footer text-danger"><cite title="Source Title">Jika data diatas kosong, lengkapi data tersebut pada profil anda.</cite></footer>
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
                                                <label for="no-telp-ortu" class="col-md-6 col-form-label form-control-label">No. Telpon Orang Tua</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" value="<?php echo $row['no_telp_ortu'] ?>" id="no-telp-ortu" placeholder="No Telp Orangtua" disabled>
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
                                            <div class="form-group row">
                                                <label for="pekerjaan-ortu" class="col-md-6 col-form-label form-control-label">Pekerjaan Orangtua</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" value="<?php echo $row['pekerjaan_ortu'] ?>" id="pekerjaan-ortu" placeholder="Pekerjaan Orangtua" disabled>
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
                                        $acc_role_wakil_rektor = '2';
                                        $query = "SELECT * FROM sts_daftar WHERE kd_daftar = ? and acc_role = ? LIMIT 1";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("is", $kd_daftar, $acc_role_wakil_rektor);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <div class="timeline-block">
                                                <span class="timeline-step badge-<?php $wakil_rektor_status = $row['status'];
                                                                                    echo ($wakil_rektor_status == "diterima" ? "success" : "danger") ?>">
                                                    <i class="fas fa-<?php $wakil_rektor_status = $row['status'];
                                                                        echo ($wakil_rektor_status == "diterima" ? "check" : "exclamation") ?>"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <span class="badge badge-pill badge-<?php $wakil_rektor_status = $row['status'];
                                                                                        echo ($wakil_rektor_status == "diterima" ? "success" : "danger") ?>"><?php echo $row['status']; ?></span>
                                                    <h5 class=" mt-3 mb-0">Tahap Seleksi </h5>

                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold"><?php $date = $row['acc_tanggal'];
                                                                                                    echo date('d-m-Y g:i A', strtotime($date)); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }} else { ?>
                                            <div class="timeline-block">
                                                <span class="timeline-step badge-warning">
                                                    <i class="fas fa-history"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <span class="badge badge-pill badge-warning">DIPROSES</span>
                                                    <h5 class=" mt-3 mb-0">Tahap Seleksi</h5>

                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold">00-00-0000 00:00 --</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>




                                        <?php
                                        $kd_daftar = $_GET['kd_daftar'];
                                        $status1 = 'diterima';
                                        $status2 = 'ditolak';
                                        $query = "SELECT * FROM pendaftaran WHERE kd_daftar = ? and status = ? OR status = ? LIMIT 1";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("iss", $kd_daftar, $status1, $status2);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <div class="timeline-block">
                                                <span class="timeline-step badge-<?php $status = $row['status'];
                                                                                    echo ($status == "diterima" ? "success" : "danger") ?>">
                                                    <i class="fas fa-<?php $status = $row['status'];
                                                                        echo ($status == "diterima" ? "check" : "exclamation") ?>"></i>
                                                </span>
                                                <div class="timeline-content">
                                                    <span class="badge badge-pill badge-<?php $status = $row['status'];
                                                                                        echo ($status == "diterima" ? "success" : "danger") ?>"><?php echo $row['status']; ?></span>
                                                    <h5 class=" mt-3 mb-0">Status Beasiswa</h5>

                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold"><?php $date = $row['tgl_update'];
                                                                                                    echo date('d-m-Y g:i A', strtotime($date)); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php
                                        $kd_daftar = $_GET['kd_daftar'];
                                        $query = "SELECT * FROM pendaftaran WHERE kd_daftar = ? and status IS null LIMIT 1";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("i", $kd_daftar);
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
                                                    <h5 class=" mt-3 mb-0">Status Beasiswa</h5>

                                                    <div class="mt-3">
                                                        <small class="text-muted font-weight-bold">00-00-0000 00:00 --</small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        </div>
                                    </div>
                                </div>

                                <!-- Batas Form Pembayaran Pinjaman -->


                                <?php
                                $kd_bsw = $_GET['id'];
                                if ($kd_bsw == '2') {
                                ?>
                                    <div class="card bg-gradient-success">
                                        <div class="card-header bg-transparent">
                                            <h3 class="mb-0 text-white">Unggah Bukti Pembayaran</h3>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" enctype="multipart/form-data">
                                                <!-- Multiple -->
                                                <div class="custom-file">
                                                    <input type="file" accept=".pdf" name="fileToUpload" class="custom-file-input" id="fileToUpload" lang="id" required>
                                                    <label class="custom-file-label" for="fileToUpload">Pilih File .pdf <i class="fas fa-file-pdf text-danger"></i></label>
                                                </div>
                                                <div class="text-right pt-4 pt-md-4 pb-0 pb-md-4">
                                                    <div>
                                                        <!-- <button type="submit" name="gambar" class="btn btn-sm btn-white float-right">UPLOAD</button> -->
                                                        <a type="submit" name="gambar" class="btn btn-icon btn-white float-right">
                                                            <span class="btn-inner--icon"><i class="fas fa-cloud-upload-alt"></i></span>
                                                            <span class="btn-inner--text">Upload</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                <?php } else {
                                    '';
                                }
                                ?>



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