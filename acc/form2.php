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


    // Mengambil data Genap/Ganjil berdasarkan Tahun saat ini dan Bulan saat ini
    $year = date('Y');
    $bulan_ini = date('n');
    if ($bulan_ini <= 6) {
        $bulan_ini = 'Genap';
    } else {
        $bulan_ini = 'Ganjil';
    }

    // Membuat Format nama file "Semester = 2020_Ganjil" record pada inputan file
    $string_gabungan = $year . "_" . $bulan_ini;
    $semester = $string_gabungan;

    // Membuat output semester menjadi 1 / 2 alias dari Ganjil / Genap
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
    $nim = $_SESSION['acclogin'];

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
            $filename2   = $nim . "_" . $namasyarat2[$i] . "_" . $semester . "_" . time();
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


    if (isset($_GET['on'])) {
        mysqli_query($con, "update user_mhs set status='1' where id_mhs = '" . $_GET['id'] . "'");
        $_SESSION['stsmsg1'] = "1";
    } else {
        $_SESSION['stsmsg1'] = "0";
    }

    if (isset($_GET['off'])) {
        mysqli_query($con, "update user_mhs set status='0' where id_mhs = '" . $_GET['id'] . "'");
        $_SESSION['stsmsg'] = "1";
    } else {
        $_SESSION['stsmsg'] = "0";
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

        <!-- Header -->
        <!-- Header & Breadcrumbs -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-12 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Form Pengajuan</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="../acc?id"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../acc?id">Dashboards</a></li>
                                    <li class="breadcrumb-item"><a href="../acc/beasiswa-kebutuhan">Data Pengajuan</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Form Pengajuan Detail</li>
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
            <div class="card mb-4">
                <!-- Card header -->
                <div class="card-header">
                    <div class="row align-items-center">
                        <?php
                        // $year = date('Y');
                        // $semester_ini = date('n');
                        // if ($semester_ini <= 6) {
                        //     $semester_ini = '2';
                        // } else {
                        //     $semester_ini = '1';
                        // }
                        // $digits = 3;
                        // $unik_number = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
                        // $nim_id = $_SESSION['mhslogin'];
                        // $kd_daftar = $nim_id . $year . $semester_ini . $unik_number;


                        // $year = date('Y');
                        // $bulan_ini = date('n');
                        // if ($bulan_ini <= 6) {
                        //     $num = intval("10");
                        //     $bulan_ini = intval($year - 1) . "/" . $year;
                        //     echo $bulan_ini;
                        // } else {
                        //     $bulan_ini = $year . "/" . intval($year + 1);
                        //     echo $bulan_ini;
                        // }


                        $id_bsw = $_GET['id'];
                        $tommorrow = date("Y-m-d");
                        $query = "select * from beasiswa where id_bsw=? and tgl_tutup > '$tommorrow'";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("i", $id_bsw);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <div class="col-8">
                                    <!-- Title -->
                                    <h3 class="mb-0">Form Pengisian Data</h3>
                                </div>

                                <div class="col-4 text-right">

                                    <code class="text-default"><mark class="text-default">Kode Beasiswa: <?php echo $row['kd_bsw'] ?></mark></code>
                                </div>
                        <?php
                            }
                        } else {
                            echo '<div class="col-8"><h3 class="mb-0">Form Pengisian Data</h3></div><div class="col-4 text-right"><code class="text-red"><mark>Beasiswa Tidak Ditemukan</code></mark></div>';
                        }
                        ?>

                    </div>
                </div>

                <!-- Card body -->
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                        <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                        <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                            <span data-notify="message">' . $_SESSION['error'] . '</span>
                        </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                            <span aria-hidden="true">×</span></button>
                    </div>';
                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['success'])) {
                        echo '<div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                        <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                        <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                            <span data-notify="message">' . $_SESSION['success'] . '</span>
                        </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                            <span aria-hidden="true">×</span></button>
                    </div>';
                        unset($_SESSION['success']);
                    }

                    ?>

                    <?php if (isset($_POST['submit'])) {
                        if ($_SESSION['msg'] > 0) {

                    ?>
                            <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                                <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                                <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                                    <span data-notify="message">Data Profil berhasil diubah.</span>
                                </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                                    <span aria-hidden="true">×</span></button>
                            </div>
                        <?php } else { ?>
                            <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                                <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                                <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                                    <span data-notify="message">Password tidak cocok. Data Gagal diubah.</span>
                                </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                                    <span aria-hidden="true">×</span></button>
                            </div>
                    <?php }
                    } ?>
                    <!-- Batas Awal Header Info -->
                    <?php
                    $id_bsw = $_GET['id'];
                    $tommorrow = date("Y-m-d");
                    $query = "select * from beasiswa where id_bsw=? and tgl_tutup > '$tommorrow'";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("i", $id_bsw);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                    ?>

                            <h6 class="heading-small text-muted mb-4">Informasi Beasiswa</h6>
                            <div class="card bg-gradient-default">
                                <div class="card-body">
                                    <h3 class="card-title text-white"><?php echo $row['nama_bsw'] ?></h3>
                                    <blockquote class="blockquote text-white mb-0">
                                        <p><?php echo $row['dtl_bsw'] ?></p>
                                        <footer class="blockquote-footer text-danger">Deadline Pengajuan : <cite title="Source Title"><?php $date = $row['tgl_tutup'];
                                                                                                                                        echo date('d-m-Y', strtotime($date)); ?></cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- Batas Akhir Header Info -->

                        <!-- Batas Awal Info Pribadi Mahasiswa -->

                        <?php
                        $kd_daftar = $_GET['form'];
                        $query = "SELECT
                        user_mhs.username
                        , user_mhs.nama_mhs
                        , user_mhs.email
                        , user_mhs.no_telp
                        , pendaftaran.kd_daftar
                        FROM user_mhs
                        JOIN pendaftaran 
                        WHERE pendaftaran.kd_daftar = ? AND pendaftaran.nim = user_mhs.username";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("s", $kd_daftar);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <h6 class="heading-small text-muted mb-4">Informasi Pribadi</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="username">NIM</label>
                                                <div class="input-group input-group-merge">
                                                    <input id="username" value="<?php echo $row['username'] ?>" class="form-control" placeholder="NIM Mahasiswa" type="text" title="Masukkan Username" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="nama">Nama Mahasiswa</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" class="form-control" value="<?php echo $row['nama_mhs'] ?>" id="nama" placeholder="Nama Mahasiswa" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="email">Email</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="email" class="form-control" id="email" placeholder="Email Mahasiswa" value="<?php echo $row['email'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="notelp">No. Telpon Anda</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="number" class="form-control" id="notelp" placeholder="Telpon Mahasiswa" value="<?php echo $row['no_telp'] ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="blockquote-footer text-danger"><cite title="Source Title">Jika data diatas kosong, lengkapi data tersebut pada profil anda.</cite></footer>
                                <?php } ?>
                                <hr class="my-4" />
                                <!-- Batas Akhir Info Pribadi Mahasiswa -->
                                <?php
                                $id_bsw = $_GET['id'];
                                if ($id_bsw == 1) {
                                ?>
                                    <!-- Batas Awal Pengisian Form Manual -->
                                    <h6 class="heading-small text-muted mb-4">Pengisian Form</h6>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="ipk">IPK Terbaru (*)</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-award"></i></span>
                                                    </div>
                                                    <input type="text" name="ipk" class="form-control" id="ipk" placeholder="IPK Terbaru Anda" title="Masukkan IPK Terbaru anda." oninvalid="this.setCustomValidity('Selahkan masukkan IPK Terbaru Anda.')" oninput="setCustomValidity('')" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="no_telp_ortu">No. Telpon Orang Tua (*)</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    </div>
                                                    <input type="text" name="no_telp_ortu" class="form-control" id="no_telp_ortu" placeholder="No. Telp Orang tua Anda" title="Masukkan No. Telp Ortu" oninvalid="this.setCustomValidity('Selahkan masukkan No. Telp Orangtua anda.')" oninput="setCustomValidity('')" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="nominal">Nominal Invoice Registrasi (*)</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><b>Rp.</b></span>
                                                    </div>
                                                    <input type="text" name="nominal" class="form-control" id="nominal" placeholder="Total Nominal Invoice Registrasi" title="Total Nominal Invoice Registrasi" oninvalid="this.setCustomValidity('Selahkan Masukkan Total Nominal Invoice Registrasi.')" oninput="setCustomValidity('')" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="pekerjaan-ortu">Pekerjaan Orangtua (*)</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                    </div>
                                                    <input type="text" name="pekerjaan_ortu" class="form-control" id="pekerjaan-ortu" placeholder="Pekerjaan Orang Tua" title="Pekerjaan Orang Tua Anda" oninvalid="this.setCustomValidity('Selahkan Masukkan Pekerjaan Orangtua Anda.')" oninput="setCustomValidity('')" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } elseif ($id_bsw == 2) { ?>

                                    <h6 class="heading-small text-muted mb-4">Pengisian Form</h6>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="ipk">IPK Terbaru (*)</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-award"></i></span>
                                                    </div>
                                                    <input type="text" name="ipk" class="form-control" id="ipk" placeholder="IPK Terbaru Anda" title="Masukkan IPK Terbaru anda." oninvalid="this.setCustomValidity('Selahkan masukkan IPK Terbaru Anda.')" oninput="setCustomValidity('')" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="no_telp_ortu">No. Telpon Orang Tua (*)</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    </div>
                                                    <input type="text" name="no_telp_ortu" class="form-control" id="no_telp_ortu" placeholder="No. Telp Orang tua Anda" title="Masukkan No. Telp Ortu" oninvalid="this.setCustomValidity('Selahkan masukkan No. Telp Orangtua anda.')" oninput="setCustomValidity('')" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="nominal">Nominal Invoice Registrasi (*)</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><b>Rp.</b></span>
                                                    </div>
                                                    <input type="text" name="nominal" class="form-control" id="nominal" placeholder="Total Nominal Invoice Registrasi" title="Total Nominal Invoice Registrasi" oninvalid="this.setCustomValidity('Selahkan Masukkan Total Nominal Invoice Registrasi.')" oninput="setCustomValidity('')" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-control-label" for="pekerjaan-ortu">Pekerjaan Orangtua (*)</label>
                                                <div class="input-group input-group-merge">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                    </div>
                                                    <input type="text" name="pekerjaan_ortu" class="form-control" id="pekerjaan-ortu" placeholder="Pekerjaan Orang Tua" title="Pekerjaan Orang Tua Anda" oninvalid="this.setCustomValidity('Selahkan Masukkan Pekerjaan Orangtua Anda.')" oninput="setCustomValidity('')" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                <?php } elseif ($id_bsw == 3) { ?>

                                <?php } elseif ($id_bsw == 4) { ?>

                                <?php } elseif ($id_bsw == 5) {
                                } else {
                                } ?>

                                <!-- Batas Akhir Pengisian Form Manual -->

                                <footer class="blockquote-footer text-danger"><cite title="Source Title">(*) Field wajib isi</cite></footer>

                                <hr class="my-4" />
                                <!-- Batas Awal Persyaratan Berkas -->
                                <h6 class="heading-small text-muted mb-4">Persyaratan Berkas</h6>
                                <div class="row">
                                    <?php
                                    $id_bsw = $_GET['id'];
                                    $sql_syarat = mysqli_query($con, "SELECT
                                    ref_syarat.kd_syarat AS kd_syarat
                                  , ref_syarat.nama_syarat As nama_syarat
                                  , syarat_bsw.kd_bsw AS checked
                                  , syarat_bsw.kd_syarat_bsw AS kd_syarat_bsw
                                  FROM ref_syarat
                                  JOIN syarat_bsw ON (
                                    ref_syarat.kd_syarat = syarat_bsw.kd_syarat
                                    AND kd_bsw= '" . $id_bsw . "'
                                      )");
                                    $cnt = 0;
                                    if (mysqli_num_rows($sql_syarat) > 0) {
                                        while ($row = mysqli_fetch_assoc($sql_syarat)) {
                                    ?>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="syarat-<?php echo ($row['kd_syarat']) ?>">Scan <?php echo ($row['nama_syarat']) ?></label>
                                                    <div class="custom-file">
                                                        <input type="file" accept=".pdf" name="syarat[]" class="custom-file-input file" id="syarat-file-input-<?php echo ($row['kd_syarat']) ?>" lang="id" required>
                                                        <label id="syarat-file-label-<?php echo ($row['kd_syarat']) ?>" class="custom-file-label" for="syarat-file-label-<?php echo ($row['kd_syarat']) ?>">Pilih File .pdf <i class="fas fa-file-pdf text-danger"></i></label>
                                                        <input type="hidden" name="nama_syarat[]" value="<?php echo ($row['nama_syarat']) ?>" />
                                                        <input type="hidden" name="kd_syarat_bsw[]" value="<?php echo ($row['kd_syarat_bsw']) ?>" />
                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                    }
                                    ?>

                                    <!-- <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="prodi">No. Telpon Orang Tua</label>
                                            <div class="custom-file">
                                                <input type="file" accept="image/*" name="fileToUpload" class="custom-file-input file" id="fileToUpload" lang="id">
                                                <label class="custom-file-label" for="fileToUpload">Pilih File</label>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <!-- Batas Akhir Persyaratan Berkas -->
                                <footer class="blockquote-footer text-danger"><cite title="Source Title">Persyaratan wajib di upload menggunakan format file .pdf</cite></footer>

                                <div class="text-right pb-0">
                                    <button type="submit" id="submit" name="file_array" class="btn btn-icon btn-primary text-white my-4 <?php
                                                                                                                                        if ($result->num_rows > 1) {
                                                                                                                                            echo "disabled";
                                                                                                                                        }
                                                                                                                                        ?>" type="button">
                                        <span class="btn-inner--icon"><i class="fas fa-paper-plane"></i></span>
                                        <span class="btn-inner--text">Submit Form</span>
                                    </button>
                                </form>
                                <a type="button" href="../mhs/pengajuan" class="btn btn-icon btn-danger text-white my-4" type="button">
                                    <span class="btn-inner--icon"><i class="fas fa-times"></i></span>
                                    <span class="btn-inner--text">Batal</span>
                                </a>
                </div>

                <!-- Batas verifikasi hapus akun -->
                <div class="modal fade" id="hapusconfirm<?php echo $row['id_mhs'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                        <div class="modal-content bg-gradient-danger">
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal-title-notification">Konfirmasi Hapus Akun</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="py-3 text-center">
                                    <i class="ni ni-bell-55 ni-3x"></i>
                                    <h4 class="heading mt-4">Perhatian</h4>
                                    <p>Menghapus akun berarti setuju bahwa akun akan dihapus dari database. Akun yang telah di hapus tidak dapat dipulihkan kembali. Yakin ingin menghapus akun ini?</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="cari_mahasiswa?carimhs=<?php echo $row['username'] ?>&&id=<?php echo $row['id_mhs'] ?>&&del=delete" type="button" class="btn btn-white">Ok, Hapus Sekarang</a>
                                <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- batas modal form validasi edit profil -->
                <div class="col-md-4">
                    <div class="modal fade" id="reset<?php echo $row['id_mhs'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <div class="card bg-secondary border-0 mb-0">

                                        <div class="card-body px-lg-5 py-lg-5">
                                            <div class="text-center text-muted mb-4">
                                                <small>Masukkan password anda untuk mengubah data user : <b>
                                                        <?php $nama_acc = $row['nama_mhs'];
                                                        if ($nama_acc == "" || $nama_acc == "NULL") {
                                                            echo htmlentities($row['username']);
                                                        } else {
                                                            echo htmlentities($row['nama_mhs']);
                                                        }

                                                        ?>
                                                    </b></small>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group input-group-merge input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                                    </div>
                                                    <input type="hidden" name="id_user" value="<?php echo $row['id_mhs'] ?>">
                                                    <input class="form-control" name="password_valid" placeholder="Password Anda" type="password" title="Masukkan Password" oninvalid="this.setCustomValidity('Selahkan masukkan Password anda.')" oninput="setCustomValidity('')" required>
                                                </div>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend text-left text-muted">
                                                    <span><i class="fas fa-info-circle"></i> <small>Reset Password Default User akan diubah menjadi <code style="font-size: 1rem;">1234</code>. Setelah user berhasil Login, User tersebut dapat mengubahnya pada pilihan Profil user tersebut. </small></span>
                                                </div>

                                            </div>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend text-left text-muted">
                                                    <span><i class="fas fa-info-circle"></i> <small>Password anda di butuhkan sebagai verifikasi bahwa anda memiliki akses untuk mengubah data ini. </small></span>
                                                </div>

                                            </div>

                                            <div class="text-center">
                                                <button type="submit" name="resetpsw" class="btn btn-primary my-4">Reset Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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




        <?php
        include("include/footer.php"); //Edit topnav on this page
        ?>
        <?php
        $id_bsw = $_GET['id'];
        $sql_syarat = mysqli_query($con, "SELECT
                                        ref_syarat.kd_syarat AS kd_syarat
                                      , ref_syarat.nama_syarat As nama_syarat
                                      , syarat_bsw.kd_bsw AS checked
                                      FROM ref_syarat
                                      JOIN syarat_bsw ON (
                                        ref_syarat.kd_syarat = syarat_bsw.kd_syarat
                                        AND kd_bsw= '" . $id_bsw . "'
                                      )");

        if (mysqli_num_rows($sql_syarat) > 0) {
            while ($row = mysqli_fetch_assoc($sql_syarat)) {
        ?>
                <script>
                    $(document).on('change', '#syarat-file-input-<?php echo ($row['kd_syarat']) ?>', function(event) {
                        $(this).next('#syarat-file-label-<?php echo ($row['kd_syarat']) ?>').html(event.target.files[0].name);
                    })
                </script>
        <?php
            }
        }
        ?>

        <script type="text/javascript">
            document.getElementById("close_direct").onclick = function() {
                location.href = "cari_mahasiswa?carimhs=<?php echo $carimahasiswa ?>";
            };
        </script>
        <script>
            $('.select2').select2();
        </script>

        <script>
            var nominal = document.getElementById("nominal");
            nominal.addEventListener("keyup", function(e) {
                nominal.value = convertRupiah(this.value);
            });
            nominal.addEventListener('keydown', function(event) {
                return isNumberKey(event);
            });

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