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
    $parentpage = "akun";
    $childpage = "mahasiswa";
    $carimahasiswa = $_GET["carimhs"];

    if (isset($_POST['submit'])) {

        $id_user = $_GET["carimhs"];
        $nim = $_POST["nimmhs"];
        $nama_mhs = $_POST["nama_mhs"];
        $email = $_POST['email'];
        $no_telp = $_POST['no_telp'];
        $id_fakultas = $_POST['id_fakultas'];
        $id_prodi = $_POST['id_prodi'];
        $id_dosen_wali = $_POST['id_dosen_wali'];

        //Prepare Update User Data
        $SQL = $con->prepare("UPDATE user_mhs SET nim=?, nama_mhs=?, email=?, no_telp=?, id_fakultas=?, id_prodi=?, id_dosen_wali=? WHERE nim=?");
        $SQL->bind_param('ssssssis', $nim, $nama_mhs, $email, $no_telp, $id_fakultas, $id_prodi, $id_dosen_wali, $id_user);
        /* Execute the prepared Statement */
        $status = $SQL->execute();
        /* BK: always check whether the execute() succeeded */
        if ($status === false) {
            // trigger_error($SQL->error, E_USER_ERROR);
            $_SESSION['msg'] = "0";
        }
        $_SESSION['msg'] = "1";
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

    if (isset($_POST['resetpsw'])) {
        //update info pribadi
        $password_valid =  $_POST["password_valid"];
        $username_valid = $_SESSION['admlogin'];
        $id_user = $_POST['id_user'];

        //update password
        $password =  '1234';
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);

        //validasi password user
        $pass_valid = "SELECT * FROM user_admin WHERE username = '$username_valid'";
        $admin = mysqli_query($con, $pass_valid);

        if (mysqli_num_rows($admin) > 0) {
            while ($row = mysqli_fetch_array($admin)) {
                if (password_verify($password_valid, $row["password"])) {
                    //return true;   
                    $sql = mysqli_query($con, "update user_mhs set password='$passwordhash' where id_mhs='$id_user'");
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
                url: "check_username.php",
                data: 'nimmhs=' + $("#nimmhs").val() + '&oldnim=' + $("#nimmhsnow").val(),
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
            if ($_SESSION['msg'] > 0) {

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
                        <span data-notify="message">Terjadi kesalahan saat mengubah data. Tunggu beberapa saat lalu coba lagi.</span>
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
                        <span data-notify="message">Akun Mahasiswa berhasil dihapus.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menghapus akun Mahasiswa. Coba sesaat lagi.</span>
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
                        <span data-notify="message">Akun Mahasiswa berhasil di aktifkan.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat mengaktifkan akun Mahasiswa. Coba sesaat lagi.</span>
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
                        <span data-notify="message">Akun Mahasiswa berhasil di nonaktifkan.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat me-nonaktifkan akun Mahasiswa. Coba sesaat lagi.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
        <?php }
        } ?>

        <?php if (isset($_POST['resetpsw'])) {
            if ($_SESSION['pswmsg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Password User berhasil di Reset ke Default : 1234.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Password tidak cocok. Reset Password User gagal dilakukan.</span>
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
                        $query = "select * from user_mhs where nim=?";
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

                                <code class="text-default"><mark class="text-default"><?php echo $row['nim'] ?> - <?php echo $row['nama_mhs'] ?></mark></code>
                                </div>
                        <?php }
                        } else {
                            echo '<div class="col-8"><h3 class="mb-0">Informasi Data Mahasiswa</h3></div><div class="col-4 text-right"><code class="text-red"><mark>Akun Tidak Ditemukan</code></mark></div>';
                        }
                        ?>

                    </div>
                </div>

                <!-- Card body -->
                <div class="card-body">
                    <!-- Form groups used in grid -->
                    <?php
                    $id_acc = $_GET['carimhs'];
                    $query = "select * from user_mhs where nim=?";
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
                                            <label class="form-control-label" for="nim">NIM</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><small class="font-weight-bold">@</small></span>
                                                </div>
                                                <input type="hidden" name="nimmhsnow" id="nimmhsnow" value="<?php echo $_GET['carimhs'] ?>" />
                                                <input onBlur="userAvailability()" id="nimmhs" name="nimmhs" value="<?php echo $row['nim'] ?>" class="form-control" placeholder="NIM Mahasiswa" type="text" title="Masukkan NIM" oninvalid="this.setCustomValidity('Selahkan masukkan NIM Mahasiswa.')" oninput="setCustomValidity('')" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="user-availability-status1"></span> <img src="../assets/img/loading.gif" width="35" id="loadericon" style="display:none;" />
                                                </div>
                                            </div>
                                            <input id="oldnim" name="oldnim" value="<?php echo $row['nim'] ?>" type="hidden" />
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
                                                <input type="text" name="nama_mhs" class="form-control" value="<?php echo $row['nama_mhs'] ?>" id="nama" placeholder="Nama Mahasiswa">
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
                                                <input type="number" name="no_telp" class="form-control" id="notelp" placeholder="Telpon Mahasiswa" value="<?php echo $row['no_telp'] ?>">
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
                                            <select class="form-control" name="id_fakultas" title="fakultas" id="fakultasedit">
                                                <?php
                                                $nim_mhs = $_GET['carimhs'];
                                                $sql_fakultas = mysqli_query($con, "select * from user_mhs join ref_fakultas where user_mhs.id_fakultas=ref_fakultas.id_fakultas AND user_mhs.nim = '" . $nim_mhs . "'");
                                                ?>

                                                <?php
                                                if (mysqli_num_rows($sql_fakultas) > 0) {
                                                    while ($rs_fakultas = mysqli_fetch_assoc($sql_fakultas)) {
                                                        echo '<option value="' . $rs_fakultas['id_fakultas'] . '">Fakultas ' . $rs_fakultas['nama_fakultas'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option></option>';
                                                }

                                                ?>
                                                <?php
                                                $sql_fakultas = mysqli_query($con, "select * from ref_fakultas order by id_fakultas ASC");
                                                ?>
                                                <?php
                                                while ($rs_fakultas = mysqli_fetch_assoc($sql_fakultas)) {
                                                    echo '<option value="' . $rs_fakultas['id_fakultas'] . '">Fakultas ' . $rs_fakultas['nama_fakultas'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="prodi">Program Studi</label>

                                            <select class="form-control" name="id_prodi" title="Pilih Program Studi" id="prodiedit">
                                                <?php
                                                $sql_prodi = mysqli_query($con, "select * from user_mhs join ref_prodi where user_mhs.id_prodi=ref_prodi.id_prodi AND user_mhs.nim = '" . $nim_mhs . "'");
                                                ?>

                                                <?php
                                                if (mysqli_num_rows($sql_prodi) > 0) {
                                                    while ($rs_prodi = mysqli_fetch_assoc($sql_prodi)) {
                                                        echo '<option value="' . $rs_prodi['id_prodi'] . '">Program Studi ' . $rs_prodi['nama_prodi'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="0"></option>';
                                                }

                                                ?>

                                            </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="dosen_wali">Dosen Wali</label>
                                            <select class="form-control" name="id_dosen_wali" title="Dosen Wali" id="dosen_wali">
                                                <?php
                                                $nim_mhs = $_GET['carimhs'];
                                                $sql_role = mysqli_query($con, "select * from user_mhs join user_acc where user_mhs.id_dosen_wali=user_acc.id_acc AND user_mhs.nim = '" . $nim_mhs . "'");
                                                ?>

                                                <?php
                                                if (mysqli_num_rows($sql_role) > 0) {
                                                    while ($rs_role = mysqli_fetch_assoc($sql_role)) {
                                                        echo '<option value="' . $rs_role['id_acc'] . '">' . $rs_role['nama_acc'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="0"></option>';
                                                }

                                                ?>
                                            </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right pb-0">
                                    <button type="submit" id="submit" name="submit" class="btn btn-icon btn-primary text-white my-4 <?php
                                                                                                                                    if ($result->num_rows > 1) {
                                                                                                                                        echo "disabled";
                                                                                                                                    }
                                                                                                                                    ?>" type="button">
                                        <span class="btn-inner--icon"><i class="fas fa-pen"></i></span>
                                        <span class="btn-inner--text">Edit Data</span>
                                    </button>
                            </form>
                            <a data-toggle="modal" type="button" data-target="#reset<?php echo $row['id_mhs'] ?>" class="btn btn-icon btn-info text-white my-4 <?php
                                                                                                                                                                if ($result->num_rows > 1) {
                                                                                                                                                                    echo "disabled";
                                                                                                                                                                }
                                                                                                                                                                ?>" type="button">
                                <span class="btn-inner--icon"><i class="fas fa-key"></i></span>
                                <span class="btn-inner--text">Reset Password</span>
                            </a>
                            <?php $status = $row['status'];
                            if ($status > 0) :
                            ?>
                                <a href="cari_mahasiswa?carimhs=<?php echo $row['nim'] ?>&&id=<?php echo $row['id_mhs'] ?>&off=0" class="btn btn-icon btn-warning text-white my-4 <?php
                                                                                                                                                                                        if ($result->num_rows > 1) {
                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>" type="button">
                                    <span class="btn-inner--icon"><i class="fas fa-lock"></i></span>
                                    <span class="btn-inner--text">Nonaktifkan Akun</span>
                                </a>
                            <?php else : ?>
                                <a href="cari_mahasiswa?carimhs=<?php echo $row['nim'] ?>&&id=<?php echo $row['id_mhs'] ?>&on=1" class="btn btn-icon btn-success text-white my-4 <?php
                                                                                                                                                                                        if ($result->num_rows > 1) {
                                                                                                                                                                                            echo "disabled";
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>" type="button">
                                    <span class="btn-inner--icon"><i class="fas fa-lock-open"></i></span>
                                    <span class="btn-inner--text">Aktifkan Akun</span>
                                </a>
                            <?php endif; ?>
                            <a data-toggle="modal" type="button" data-target="#hapusconfirm<?php echo $row['id_mhs'] ?>" class="btn btn-icon btn-danger text-white my-4" type="button">
                                <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
                                <span class="btn-inner--text">Hapus Akun</span>
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
                                <a href="cari_mahasiswa?carimhs=<?php echo $row['nim'] ?>&&id=<?php echo $row['id_mhs'] ?>&&del=delete" type="button" class="btn btn-white">Ok, Hapus Sekarang</a>
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
                                    <form role="form" method="post">
                                        <div class="card-body px-lg-5 py-lg-5">
                                            <div class="text-center text-muted mb-4">
                                                <small>Masukkan password anda untuk mengubah data user : <b>
                                                        <?php $nama_acc = $row['nama_mhs'];
                                                        if ($nama_acc == "" || $nama_acc == "NULL") {
                                                            echo htmlentities($row['nim']);
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
                                            </form>
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
                                    <form action="cari_mahasiswa">
                                        <div class="input-group input-group-merge input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><small class="font-weight-bold"><i class="fas fa-search"></i></small></span>
                                            </div>
                                            <input id="carimhs" name="carimhs" type="text" pattern=".{8,8}" class="form-control card-text" placeholder="Cari Mahasiswa menggunakan NIM" title="Harap memeriksa NIM yang anda masukkan. Pastikan NIM yang dimasukkan benar dan berjumlah 8 Digit Angka." oninvalid="this.setCustomValidity("Selahkan masukkan NIM untuk mencari mahasiswa")" oninput="setCustomValidity("")" required>
    
                                            <div class="input-group-prepend">
                                                <input class="input-group-text" type="submit" value="Cari"></input>
                        
                                            </div>
    
                                        </div>
                                    </form>
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
                location.href = "cari_mahasiswa?carimhs=<?php echo $carimahasiswa ?>";
            };
        </script>
        <script>
            $('.select2').select2();
        </script>
        <script src="js/fakultas-prodi.js?v=1"></script>

    </div>
    </div>

    </body>

    </html>
<?php } ?>