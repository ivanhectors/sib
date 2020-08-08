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
        $password = $_POST["password_default"];
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        $username = $_POST["username"];
        $email = $_POST['email'];
        $status = 1;
        $role = $_POST['role'];
        $fakultas = $_POST['fakultas'];
        $prodi = $_POST['prodi'];


        //tambah acc
        $sql = mysqli_query($con, "INSERT INTO user_acc (username, password, email, status, kd_role, kd_fakultas, kd_prodi) VALUES ('$username', '$passwordhash', '$email', '$status', '$role', '$fakultas', '$prodi')");
        $_SESSION['msg'] = "1";
    } else {
        $_SESSION['msg'] = "0";
    }

    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from user_acc where id_acc = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "1";
    } else {
        $_SESSION['delmsg'] = "0";
    }

    if (isset($_GET['on'])) {
        mysqli_query($con, "update user_acc set status='1' where id_acc = '" . $_GET['id'] . "'");
        $_SESSION['stsmsg1'] = "1";
    } else {
        $_SESSION['stsmsg1'] = "0";
    }

    if (isset($_GET['off'])) {
        mysqli_query($con, "update user_acc set status='0' where id_acc = '" . $_GET['id'] . "'");
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
                    $sql = mysqli_query($con, "update user_acc set password='$passwordhash' where id_acc='$id_user'");
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
                url: "add_admin_check_username.php",
                data: 'username=' + $("#username").val(),
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
                        <span data-notify="message">Data Penyeleksi baru berhasil ditambahkan.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menambah Data Penyeleksi baru. Coba sesaat lagi.</span>
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
                        <span data-notify="message">Penyeleksi berhasil dihapus.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menghapus Penyeleksi. Coba sesaat lagi.</span>
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
                        <span data-notify="message">Akun Penyeleksi berhasil di aktifkan.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat mengaktifkan akun Penyeleksi. Coba sesaat lagi.</span>
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
                        <span data-notify="message">Akun Penyeleksi berhasil di nonaktifkan.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat me-nonaktifkan akun Penyeleksi. Coba sesaat lagi.</span>
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
                        <span data-notify="message">Password User berhasil di Reset ke Default.</span>
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
                        <div class="col-lg-6 col-6">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../adm">Dashboards</a></li>
                                    <li class="breadcrumb-item"><a href="../adm">Data Akun</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Mahasiswa</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-neutral"><i class="fas fa-user-plus" style="color:primary;"> </i> Tambah Penyeleksi</a>

                        </div>
                    </div>

                    <div class="row card-wrapper">
                        <div class="col-lg-4">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="card-title text-uppercase text-muted mb-0">Tambah</h4>
                                            <span class="h5 font-weight-bold mb-0">Akun Mahasiswa <i class="fas fa-chevron-right"></i></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="card-title text-uppercase text-muted mb-0">Import</h4>
                                            <span class="h5 font-weight-bold mb-0">Data Mahasiswa <i class="fas fa-chevron-right"></i></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="fas fa-file-csv"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                        <span class="text-nowrap">Since last month</span>
                                    </p> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="card-title text-uppercase text-muted mb-0">Export</h4>
                                            <span class="h5 font-weight-bold mb-0">Data Mahasiswa <i class="fas fa-chevron-right"></i></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="ni ni-money-coins"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                        <span class="text-nowrap">Since last month</span>
                                    </p> -->
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <!-- Batas Header & Breadcrumbs -->


        <!-- Page content -->
        <div class="container-fluid mt--6">
            <!-- Image overlay -->
            <div class="card bg-dark text-white border-0">
                <img class="card-img" src="../assets/img/cari-mahasiswa.jpg" alt="Card image">
                <div class="card-img-overlay align-items-center">
                    <div>
                        <center>
                            <h5 class="h1 card-title text-white mb-4 mt-5">Cari Mahasiswa</h5>
                        <div class="form-group col-md-6">
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><small class="font-weight-bold"><i class="fas fa-search"></i></small></span>
                                </div>
                                <input id="carimhs" name="carimhs" class="form-control" placeholder="Cari Mahasiswa menggunakan NIM" type="text" title="Masukkan NIM untuk mencari mahasiswa" >
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><small class="font-weight-bold"><a href="#" class="font-weight-bold"><i class="fas fa-chevron-circle-right"></i></a></small></span>
                                </div>
                            </div>

                        </div>
                        </center>
                        <!-- <div class="text-center">
                                  <button type="submit" name="resetpsw" class="btn btn-primary">Reset Password</button>
                                </div> -->
                        <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text text-sm font-weight-bold">Last updated 3 mins ago</p> -->
                    </div>
                </div>
            </div>
            <!-- Table -->









            <?php
            include("include/footer.php"); //Edit topnav on this page
            ?>

        </div>
    </div>

    </body>

    </html>
<?php } ?>