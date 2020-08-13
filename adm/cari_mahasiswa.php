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


    if (isset($_POST['submit'])) {
        //update info pribadi
        $password_valid =  $_POST["password_valid"];
        $username_valid = $_SESSION['admlogin'];

        $id_user = $_GET["id"];
        $username = $_POST["username"];
        $nama = $_POST["nama"];
        $email = $_POST['email'];
        $notelp = $_POST['notelp'];
        $role = $_POST['role'];
        $fakultas = $_POST['fakultas'];
        $prodi = $_POST['prodi'];


        //validasi password user
        $pass_valid = "SELECT * FROM user_admin WHERE username = '$username_valid'";
        $admin = mysqli_query($con, $pass_valid);

        if (mysqli_num_rows($admin) > 0) {
            while ($row = mysqli_fetch_array($admin)) {
                if (password_verify($password_valid, $row["password"])) {
                    //return true;   
                    $sql = mysqli_query($con, "update user_acc set username='$username', nama_acc='$nama', email='$email', no_telp='$notelp', kd_role='$role', kd_fakultas='$fakultas', kd_prodi='$prodi' where id_acc='$id_user'");
                    $_SESSION['pswmsg'] = "1";
                    //$successmsg="Data profil anda berhasil diubah.";

                } else {
                    //echo "<script>alert('Gagal! Password tidak cocok.');</script>";
                    $_SESSION['pswmsg'] = "0";
                    //$errormsg="Password lama tidak cocok! Gagal mengubah data.";
                }
            }
            //echo "<script>alert('Fetch Array Gagal');</script>";
        }
        //echo "<script>alert('Number of Rows 0');</script>";
    }


?>
    <?php
    include("include/header.php");
    ?>
    <script>
        function userAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "edit_acc_check_username.php",
                data: 'username=' + $("#username").val() + '&oldusername=' + $("#oldusername").val(),
                type: "POST",
                success: function(data) {
                    $("#user-availability-status1").html(data);
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
    <style>
        .select2-selection__rendered {
            font-size: .875rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
            top: 50%;
            transform: translateY(-50%);
            right: 0.01px;
            width: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            background-image: url(https://cdn4.iconfinder.com/data/icons/user-interface-174/32/UIF-76-512.png);
            background-color: transparent;
            background-size: contain;
            border: none !important;
            height: 20px !important;
            width: 20px !important;
            margin: auto !important;
            top: auto !important;
            left: auto !important;
        }
    </style>
    </head>
    <?php
    include("include/sidebar.php");
    ?>



    <!-- Main content -->
    <div class="main-content" id="panel">

        <?php
        include("include/topnav.php"); //Edit topnav on this page
        ?>
        <?php if (isset($_POST['submit'])) {
            if ($_SESSION['pswmsg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Data Mahasiswa berhasil diubah.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Password tidak cocok atau terjadi kesalahan sistem. Tunggu beberapa saat lalu coba lagi.</span>
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
                                    <li class="breadcrumb-item"><a href="../adm/mahasiswa">Mahasiswa</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Info Mahasiswa</li>
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

                    <div class="row align-items-center">
                    <?php
                        $id_acc = $_GET['carimhs'];
                        $query = "select * from user_mhs where username=?";
                        $stmt = $con->prepare($query);
                        $stmt->bind_param("i", $id_acc);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-8">
                            <!-- Title -->
                            <h3 class="mb-0">Informasi Data Mahasiswa</h3>
                        </div>

                                <div class="col-4 text-right">

                                    <span class="badge badge-pill badge-default"><?php echo $row['username'] ?> - <?php echo $row['nama_mhs'] ?></span>
                                </div>
                        <?php }
                        } else {
                            echo '<div class="col-8"><h3 class="mb-0">Informasi Data Mahasiswa</h3></div><div class="col-4 text-right"><span class="badge badge-pill badge-danger">Akun Tidak Ditemukan</span></div>';
                        }
                        ?>

                    </div>
                </div>

                <!-- Card body -->
                <div class="card-body">
                    <!-- Form groups used in grid -->
                    <?php
                    $id_acc = $_GET['carimhs'];
                    $query = "select * from user_mhs where username=?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("i", $id_acc);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <form role="form" method="post">
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Informasi Pribadi</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="username">NIM</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><small class="font-weight-bold">@</small></span>
                                                </div>

                                                <input onBlur="userAvailability()" id="username" name="username" value="<?php echo $row['username'] ?>" class="form-control" placeholder="Username Mahasiswa Baru" type="text" title="Masukkan Username" oninvalid="this.setCustomValidity('Selahkan masukkan Username Mahasiswa.')" oninput="setCustomValidity('')" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="user-availability-status1"></span> <img src="../assets/img/loading.gif" width="35" id="loadericon" style="display:none;" />
                                                </div>
                                            </div>
                                            <input id="oldusername" name="oldusername" value="<?php echo $row['username'] ?>" type="hidden" />
                                            <span id="user-availability-status1"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="nama">Nama Mahasiswa</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" name="nama" class="form-control" value="<?php echo $row['nama_mhs'] ?>" id="nama" placeholder="Nama Mahasiswa">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">Email</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Email Mahasiswa" value="<?php echo $row['email'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="notelp">No. Telpon</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="number" name="notelp" class="form-control" id="notelp" placeholder="Telpon Mahasiswa" value="<?php echo $row['no_telp'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4" />
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Informasi Akademik</h6>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="fakultas">Fakultas</label>
                                            <select class="form-control" name="fakultas" title="fakultas" id="fakultasedit">
                                                <?php
                                                $nim_mhs = $_GET['carimhs'];
                                                $sql_fakultas = mysqli_query($con, "select * from user_mhs join ref_fakultas where user_mhs.kd_fakultas=ref_fakultas.kd_fakultas AND user_mhs.username = '" . $nim_mhs . "'");
                                                ?>

                                                <?php
                                                if (mysqli_num_rows($sql_fakultas) > 0) {
                                                    while ($rs_fakultas = mysqli_fetch_assoc($sql_fakultas)) {
                                                        echo '<option value="' . $rs_fakultas['kd_fakultas'] . '">Fakultas ' . $rs_fakultas['nama_fakultas'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option></option>';
                                                }

                                                ?>
                                                <?php
                                                $sql_fakultas = mysqli_query($con, "select * from ref_fakultas order by kd_fakultas ASC");
                                                ?>
                                                <?php
                                                while ($rs_fakultas = mysqli_fetch_assoc($sql_fakultas)) {
                                                    echo '<option value="' . $rs_fakultas['kd_fakultas'] . '">Fakultas ' . $rs_fakultas['nama_fakultas'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="prodi">Program Studi</label>

                                            <select class="form-control" name="prodi" title="Pilih Program Studi" id="prodiedit">
                                                <?php
                                                $sql_prodi = mysqli_query($con, "select * from user_mhs join ref_prodi where user_mhs.kd_prodi=ref_prodi.kd_prodi AND user_mhs.username = '" . $nim_mhs . "'");
                                                ?>

                                                <?php
                                                if (mysqli_num_rows($sql_prodi) > 0) {
                                                    while ($rs_prodi = mysqli_fetch_assoc($sql_prodi)) {
                                                        echo '<option value="' . $rs_prodi['kd_prodi'] . '">Program Studi ' . $rs_prodi['nama_prodi'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option></option>';
                                                }

                                                ?>

                                            </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="dosen_wali">Dosen Wali</label>
                                            <select class="form-control" name="dosen_wali" title="Dosen Wali" id="dosen_wali">
                                                <?php
                                                $nim_mhs = $_GET['carimhs'];
                                                $sql_role = mysqli_query($con, "select * from user_mhs join user_acc where user_mhs.id_dosen_wali=user_acc.id_acc AND user_mhs.username = '" . $nim_mhs . "'");
                                                ?>

                                                <?php
                                                if (mysqli_num_rows($sql_role) > 0) {
                                                    while ($rs_role = mysqli_fetch_assoc($sql_role)) {
                                                        echo '<option value="' . $rs_role['id_acc'] . '">' . $rs_role['nama_acc'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option></option>';
                                                }

                                                ?>
                                            </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div>
                                </div>


                                <div class="text-right pb-0">
                                    <a href="cari_mahasiswa?id=<?php echo $row['id_acc'] ?>&off=1" class="btn btn-icon btn-primary text-white my-4" type="button">
                                        <span class="btn-inner--icon"><i class="fas fa-pen"></i></span>
                                        <span class="btn-inner--text">Edit Data</span>
                                    </a>
                                    <a href="cari_mahasiswa?id=<?php echo $row['id_acc'] ?>&off=1" class="btn btn-icon btn-info text-white my-4" type="button">
                                        <span class="btn-inner--icon"><i class="fas fa-key"></i></span>
                                        <span class="btn-inner--text">Reset Password</span>
                                    </a>
                                    <?php $status = $row['status'];
                                    if ($status > 0) :
                                    ?>
                                        <a href="cari_mahasiswa?id=<?php echo $row['id_acc'] ?>&off=0" class="btn btn-icon btn-warning text-white my-4" type="button">
                                            <span class="btn-inner--icon"><i class="fas fa-lock"></i></span>
                                            <span class="btn-inner--text">Nonaktifkan Akun</span>
                                        </a>
                                    <?php else : ?>
                                        <a href="cari_mahasiswa?id=<?php echo $row['id_acc'] ?>&off=1" class="btn btn-icon btn-success text-white my-4" type="button">
                                            <span class="btn-inner--icon"><i class="fas fa-lock-open"></i></span>
                                            <span class="btn-inner--text">Aktifkan Akun</span>
                                        </a>
                                    <?php endif; ?>
                                    <a href="cari_mahasiswa?id=<?php echo $row['id_acc'] ?>&off=1" class="btn btn-icon btn-danger text-white my-4" type="button">
                                        <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
                                        <span class="btn-inner--text">Hapus Akun</span>
                                    </a>
                                </div>
                                <!-- batas modal form validasi edit profil -->
                                <div class="col-md-4">
                                    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="card bg-secondary border-0 mb-0">

                                                        <div class="card-body px-lg-5 py-lg-5">
                                                            <div class="text-center text-muted mb-4">
                                                                <small>Masukkan password anda untuk mengubah data user : <b>
                                                                        <?php $nama_acc = $row['nama_acc'];
                                                                        if ($nama_acc == "" || $nama_acc == "NULL") {
                                                                            echo htmlentities($row['username']);
                                                                        } else {
                                                                            echo htmlentities($row['nama_acc']);
                                                                        }


                                                                        ?>
                                                                    </b></small>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="input-group input-group-merge input-group-alternative">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                                                    </div>
                                                                    <input class="form-control" name="password_valid" placeholder="Password Anda" type="password" title="Masukkan Password" oninvalid="this.setCustomValidity('Selahkan masukkan Password anda.')" oninput="setCustomValidity('')" required>
                                                                </div>

                                                            </div>
                                                            <div class="input-group input-group-merge">
                                                                <div class="input-group-prepend text-left text-muted">
                                                                    <span><i class="fas fa-info-circle"></i> <small>Password anda di butuhkan sebagai verifikasi bahwa anda memiliki akses untuk mengubah data ini. </small></span>
                                                                </div>

                                                            </div>

                                                            <div class="text-center">
                                                                <button type="submit" name="submit" class="btn btn-primary my-4">Edit Data</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                    } else {
                        echo '<div class="card bg-dark text-white border-0">
                            <img class="card-img" src="../assets/img/cari-mahasiswa-gagal.jpg" alt="Mahasiswa Tidak Ditemukan">
                            <div class="card-img-overlay align-items-center">
                            </div>
                            </div>';
                    } ?>
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
                        url: 'as_status_penyeleksi.php',
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
                    location.href = "data_penyeleksi";
                };
            </script>
            <script>
                $('.select2').select2();
            </script>
            <script src="js/fakultas-prodi.js"></script>

        </div>
    </div>

    </body>

    </html>
<?php } ?>