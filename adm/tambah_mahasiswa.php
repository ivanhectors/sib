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

    if (isset($_POST['submit'])) {

        $password = '1234';
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);
        $username = $_POST["tambahusernamebaru"];
        $nama_mhs = $_POST["nama_mhs"];
        $email = $_POST['email'];
        $no_telp = $_POST['no_telp'];
        $kd_fakultas = $_POST['kd_fakultas'];
        $kd_prodi = $_POST['kd_prodi'];
        $id_dosen_wali = $_POST['id_dosen_wali'];
        $kd_role = '5';

        //Prepare Update User Data
        $SQL = $con->prepare("INSERT INTO user_mhs (username, password, nama_mhs, email, no_telp, kd_fakultas, kd_prodi, id_dosen_wali, kd_role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $SQL->bind_param('sssssssis', $username, $passwordhash, $nama_mhs, $email, $no_telp, $kd_fakultas, $kd_prodi, $id_dosen_wali, $kd_role);
        /* Execute the prepared Statement */
        $status = $SQL->execute();
        /* BK: always check whether the execute() succeeded */
        if ($status === false) {
            // trigger_error($SQL->error, E_USER_ERROR);
            $_SESSION['msg'] = "0";
        }
        $_SESSION['msg'] = "1";
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
                data: 'tambahusernamebaru=' + $("#tambahusernamebaru").val(),
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
                        <span data-notify="message">Akun Mahasiswa baru berhasil di tambahkan.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menambahkan akun baru. Tunggu beberapa saat lalu coba lagi.</span>
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
                                    <li class="breadcrumb-item active" aria-current="page">Tambah Mahasiswa Baru</li>
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
                        <div class="col-8">
                            <!-- Title -->
                            <h3 class="mb-0">Informasi Data Mahasiswa</h3>
                        </div>
                        <div class="col-4 text-right">
                            <code class="text-default"><mark class="text-default"></mark></code>
                        </div>
                    </div>
                </div>

                <!-- Card body -->
                <div class="card-body">
                    <!-- Form groups used in grid -->                    
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
                                                <input onBlur="userAvailability()" id="tambahusernamebaru" name="tambahusernamebaru" value="" class="form-control" placeholder="NIM Mahasiswa" type="text" title="Masukkan Username" oninvalid="this.setCustomValidity('Selahkan masukkan Username Mahasiswa.')" oninput="setCustomValidity('')" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="user-availability-status1"></span> <img src="../assets/img/loading.gif" width="35" id="loadericon" style="display:none;" />
                                                </div>
                                            </div>
                                            <input id="oldusername" name="oldusername" value="" type="hidden" />
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
                                                <input type="text" name="nama_mhs" class="form-control" value="" id="nama" placeholder="Nama Mahasiswa" oninvalid="this.setCustomValidity('Silahkan masukkan Nama Mahasiswa.')" oninput="setCustomValidity('')" required>
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
                                                <input type="email" name="email" class="form-control" id="email" value="" placeholder="Email Mahasiswa" value="">
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
                                                <input type="number" name="no_telp" class="form-control" id="notelp" value="" placeholder="Telpon Mahasiswa" value="">
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
                                            <select class="form-control" name="kd_fakultas" title="fakultas" id="fakultasedit" oninvalid="this.setCustomValidity('Silahkan Pilih Fakultas Mahasiswa.')" oninput="setCustomValidity('')" required>
                                                <option value="selected">Pilih Fakultas</option>
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

                                            <select class="form-control" name="kd_prodi" title="Pilih Program Studi" placeholder="Pilih Program Studi" id="prodiedit" oninvalid="this.setCustomValidity('Silahkan Pilih Prodi Mahasiswa.')" oninput="setCustomValidity('')" required>
                                            <option value="selected">Pilih Program Studi</option>
                                        </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="dosen_wali">Dosen Wali</label>
                                            <select class="form-control" name="id_dosen_wali" title="Dosen Wali" id="dosen_wali" oninvalid="this.setCustomValidity('Silahkan Pilih Dosen Wali Mahasiswa.')" oninput="setCustomValidity('')" required>
                                            </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right pb-0">
                                    <button type="submit" id="submit" name="submit" class="btn btn-icon btn-primary text-white my-4"  type="button">
                                        <span class="btn-inner--icon"><i class="fas fa-user-plus"></i></span>
                                        <span class="btn-inner--text">Tambah Akun</span>
                                    </button>
                            </form>
                            
                            <a href="../adm/mahasiswa" type="button" class="btn btn-icon btn-danger text-white my-4" type="button">
                                <span class="btn-inner--icon"><i class="fas fa-times"></i></span>
                                <span class="btn-inner--text">Batal</span>
                            </a>
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
                location.href = "tambah_mahasiswa";
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