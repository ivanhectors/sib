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
    $childpage = "data_penyeleksi";

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
                        <span data-notify="message">Data Penyeleksi berhasil diubah.</span>
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
                                    <li class="breadcrumb-item"><a href="../adm/data_penyeleksi">Penyeleksi</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Penyeleksi</li>
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
                    <h3 class="mb-0">Form Edit Data Penyeleksi</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <!-- Form groups used in grid -->
                    <?php
                    $id_acc = $_GET['id'];
                    $query = "select * from user_acc where id_acc=?";
                    $stmt = $con->prepare($query);
                    $stmt->bind_param("i", $id_acc);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <form role="form" method="post">
                            <!-- Address -->
                            <h6 class="heading-small text-muted mb-4">Informasi Pribadi</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="username">Username</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><small class="font-weight-bold">@</small></span>
                                            </div>

                                            <input onBlur="userAvailability()" id="username" name="username" value="<?php echo $row['username'] ?>" class="form-control" placeholder="Username Penyeleksi Baru" type="text" title="Masukkan Username" oninvalid="this.setCustomValidity('Selahkan masukkan Username Penyeleksi.')" oninput="setCustomValidity('')" required>
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
                                        <label class="form-control-label" for="nama">Nama Penyeleksi</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" name="nama" class="form-control" value="<?php echo $row['nama_acc'] ?>" id="nama" placeholder="Nama Penyeleksi">
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
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Email Penyeleksi" value="<?php echo $row['email'] ?>">
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
                                            <input type="number" name="notelp" class="form-control" id="notelp" placeholder="Telpon Penyeleksi" value="<?php echo $row['no_telp'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <!-- Address -->
                            <h6 class="heading-small text-muted mb-4">Informasi Role</h6>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="role">Hak Akses</label>
                                        <select class="form-control" name="role" title="Hak Akses" id="role">
                                            <?php
                                            $id_acc = $_GET['id'];
                                            $sql_role = mysqli_query($con, "select * from user_acc join ref_role where user_acc.kd_role=ref_role.kd_role AND user_acc.id_acc = '" . $id_acc . "'");
                                            ?>

                                            <?php
                                            if (mysqli_num_rows($sql_role) > 0) {
                                                while ($rs_role = mysqli_fetch_assoc($sql_role)) {
                                                    echo '<option value="' . $rs_role['kd_role'] . '">' . $rs_role['nama_role'] . '</option>';
                                                }
                                            } else {
                                                echo '<option></option>';
                                            }

                                            ?>
                                            <?php
                                            $sql_role = mysqli_query($con, "select * from ref_role where kd_role!='1' and kd_role!='5' order by kd_role ASC");
                                            ?>
                                            <?php
                                            while ($rs_role = mysqli_fetch_assoc($sql_role)) {
                                                echo '<option value="' . $rs_role['kd_role'] . '">' . $rs_role['nama_role'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="fakultas">Fakultas</label>
                                        <select class="form-control" name="fakultas" title="fakultas" id="fakultasedit">
                                            <?php
                                            $id_acc = $_GET['id'];
                                            $sql_fakultas = mysqli_query($con, "select * from user_acc join ref_fakultas where user_acc.kd_fakultas=ref_fakultas.kd_fakultas AND user_acc.id_acc = '" . $id_acc . "'");
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
                                            $sql_prodi = mysqli_query($con, "select * from user_acc join ref_prodi where user_acc.kd_prodi=ref_prodi.kd_prodi AND user_acc.id_acc = '" . $id_acc . "'");
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
                            </div>


                            <div class="text-right pb-0">
                                <button type="button" data-toggle="modal" data-target="#edit" class="btn btn-primary my-4">Edit Data</button>
                                <a type="button" href="../adm/data_penyeleksi" class="btn btn-danger my-4">Batal</a>
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
                                                    <?php } ?>
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