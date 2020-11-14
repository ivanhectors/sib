<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['acclogin']) == 0) {
    header('location:../403');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    $parentpage = "data-mahasiswa";


?>
    <?php
    include("include/header.php");
    ?>

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
                        <div class="col-lg-6 col-7">

                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../acc?id">Dashboards</a></li>
                                    <li class="breadcrumb-item"><a href="../acc/data_mahasiswa">Data Mahasiswa</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Detail Data Mahasiswa</li>
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
                                <!-- <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                            <div class="col-lg-3 order-lg-2">
                                                <div class="card-profile-image">
                                                    <?php $userphoto = $row['photo_mhs'];
                                                    if ($userphoto == "" || $userphoto == "NULL") :
                                                    ?>
                                                        <img src="img/profile.png" class="avatar rounded-circle mr-3">
                                                    <?php else : ?>
                                                        <img src="img/<?php echo htmlentities($userphoto); ?>" class="avatar rounded-circle mr-3">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <?php $userphoto = $row['photo_mhs'];
                                            if ($userphoto == "" || $userphoto == "NULL") :
                                            ?>
                                                <img src="img/profile.png" class="avatar mr-3" style="width: 50%; height:auto;">
                                            <?php else : ?>
                                                <img src="img/<?php echo htmlentities($userphoto); ?>" class="avatar mr-3" style="width: 50%; height:auto;">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="nim">NIM</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><small class="font-weight-bold">@</small></span>
                                                </div>
                                                <input id="usernamemhs" value="<?php echo $row['nim'] ?>" class="form-control" placeholder="NIM Mahasiswa" type="text" title="Masukkan NIM" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="nama">Nama Mahasiswa</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?php echo $row['nama_mhs'] ?>" id="nama" placeholder="Nama Mahasiswa" disabled>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr class="my-4" />
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Informasi Akademik</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">Email</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="email" class="form-control" id="email" placeholder="Email Mahasiswa" value="<?php echo $row['email'] ?>" disabled>
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
                                                <input type="number" class="form-control" id="notelp" placeholder="Telpon Mahasiswa" value="<?php echo $row['no_telp'] ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="fakultas">Fakultas</label>
                                            <select class="form-control" title="fakultas" disabled>
                                                <?php
                                                $nim_mhs = $_GET['carimhs'];
                                                $sql_fakultas = mysqli_query($con, "select * from user_mhs join ref_fakultas where user_mhs.id_fakultas=ref_fakultas.id_fakultas AND user_mhs.nim = '" . $nim_mhs . "'");
                                                ?>

                                                <?php
                                                if (mysqli_num_rows($sql_fakultas) > 0) {
                                                    while ($rs_fakultas = mysqli_fetch_assoc($sql_fakultas)) {
                                                        echo '<option value="' . $rs_fakultas['id_fakultas'] . '">' . $rs_fakultas['nama_fakultas'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option></option>';
                                                }

                                                ?>

                                            </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="prodi">Program Studi</label>

                                            <select class="form-control" title="Pilih Program Studi" disabled>
                                                <?php
                                                $sql_prodi = mysqli_query($con, "select * from user_mhs join ref_prodi where user_mhs.id_prodi=ref_prodi.id_prodi AND user_mhs.nim = '" . $nim_mhs . "'");
                                                ?>

                                                <?php
                                                if (mysqli_num_rows($sql_prodi) > 0) {
                                                    while ($rs_prodi = mysqli_fetch_assoc($sql_prodi)) {
                                                        echo '<option value="' . $rs_prodi['id_prodi'] . '">' . $rs_prodi['nama_prodi'] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="0"></option>';
                                                }

                                                ?>

                                            </select>
                                            <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="dosen_wali">Wali Studi</label>
                                            <select class="form-control" title="Dosen Wali" disabled>
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
                                    </div> -->
                                </div>

                        <?php }
                    } elseif ($result->num_rows > 1) {
                        $hasil = "duplikat";
                    } else {
                        echo '<div class="card bg-dark text-white border-0">
                            <img class="card-img" src="../assets/img/cari-mahasiswa-gagal.svg" alt="Mahasiswa Tidak Ditemukan">
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