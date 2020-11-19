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
                                            <span class="h5 font-weight-bold mb-0"><a href="tambah_mahasiswa"> Akun Mahasiswa <i class="fas fa-chevron-right"></i></a></span>
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
                                            <span class="h5 font-weight-bold mb-0"> <a href="import_mhs_csv"> Data Mahasiswa <i class="fas fa-chevron-right"></i></a></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="fas fa-file-csv"></i>
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
                                            <h4 class="card-title text-uppercase text-muted mb-0">Lihat</h4>
                                            <span class="h5 font-weight-bold mb-0"><a href="data_mahasiswa"> Data Mahasiswa <i class="fas fa-chevron-right"></i></a></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="ni ni-money-coins"></i>
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
        <!-- Batas Header & Breadcrumbs -->


        <!-- Page content -->
        <div class="container-fluid mt--6">
            <!-- Image overlay -->
            <div class="card bg-dark text-white border-0">
                <img class="card-img" src="../assets/img/cari-mahasiswa.svg" alt="Cari Mahasiswa">
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
                                        <input id="carimhs" name="carimhs" type="text" pattern=".{8,8}" class="form-control card-text" placeholder="Cari Mahasiswa menggunakan NIM" title="Harap memeriksa NIM yang anda masukkan. Pastikan NIM yang dimasukkan benar dan berjumlah 8 Digit Angka." oninvalid="this.setCustomValidity('Selahkan masukkan NIM untuk mencari mahasiswa')" oninput="setCustomValidity('')" required>
                                        <input type="hidden" name="id">
                                        <div class="input-group-prepend">
                                            <input class="input-group-text" type="submit" value="Cari"></input>
                    
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </center>
                    </div>
                </div>
            </div>

            <?php
            include("include/footer.php"); //Edit topnav on this page
            ?>
            <script>
                var carimhs = document.querySelector('#carimhs');
                carimhs.addEventListener('input', restrictNumber);
                function restrictNumber(e) {
                    var newValue = this.value.replace(new RegExp(/[^\d]/, 'ig'), "");
                    this.value = newValue;
                }
            </script>
        </div>
    </div>

    </body>

    </html>
<?php } ?>