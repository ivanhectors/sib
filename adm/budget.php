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
    $parentpage = "beasiswa";
    $childpage = "budget";

    if (isset($_POST['tambah'])) {
        $kd_bsw = $_POST["kd_bsw"];
        $nominal_input = $_POST["nominal"];
        $output = str_replace('.', '', $nominal_input);
        $nominal = trim($output, '');
        $semester = $_POST["tahun"] . $_POST["semester"];
        $query = "SELECT kd_bsw, thn_ajaran from budget where kd_bsw = ? AND thn_ajaran = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("is", $kd_bsw, $semester);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $_SESSION['error'] = 'Budget bantuan dana dan semester yang dimasukkan telah tersedia. Silahkan ubah data jika diperlukan.';
        } else {
            $budget = $con->prepare("INSERT INTO budget (kd_bsw, thn_ajaran, nominal) VALUES (?, ?, ?)");
            $budget->bind_param('iii', $kd_bsw, $semester, $nominal);
            /* execute prepared statement */
            $budget->execute();
            //printf("%d Row inserted.\n", $budget->affected_rows);
            /* close statement */
            $budget->close();
            $_SESSION['success'] = 'Budget baru berhasil ditambahkan.';
        }
        header('location: budget');
        exit();
    }


    if (isset($_POST['edit'])) {
        $id_budget = $_POST["id_budget"];
        $nominaledit = $_POST["nominaledit"];


        //edit fakultas
        $sql = mysqli_query($con, "update budget set nominal='$nominaledit' where id_budget='$id_budget' ");
        $_SESSION['success'] = "Nominal budget berhasil diubah.";
    } else {
        $_SESSION['editmsg'] = "1";
    }



    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from ref_syarat where kd_syarat = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "1";
    } else {
        $_SESSION['delmsg'] = "0";
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
        <?php if (isset($_POST['tambah'])) {
            if ($_SESSION['msg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Data Budget Beasiswa baru berhasil ditambahkan.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menambah Data Budget Beasiswa baru. Coba sesaat lagi.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
        <?php }
        } ?>

        <?php if (isset($_POST['edit'])) {
            if ($_SESSION['editmsg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Data Budget Beasiswa berhasil diubah.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">TTerjadi kesalahan saat mengubah nominal budget. Silahkan coba lagi.</span>
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
                        <span data-notify="message">Budget Beasiswa berhasil dihapus.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat menghapus Budget Beasiswa. Coba sesaat lagi.</span>
                    </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
        <?php }
        } ?>


        <!-- Header -->


        <!-- Header & Breadcrumbs -->
        <div class="header bg-primary pb-6">
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
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../adm">Dashboards</a></li>
                                    <li class="breadcrumb-item"><a href="#">Beasiswa</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Budget Beasiswa</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-neutral"><i class="fas fa-coins" style="color:primary;"> </i> Tambah Budget Baru</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Batas Header & Breadcrumbs -->



        <div class="col-md-4">
            <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card bg-secondary border-0 mb-0">
                                <div class="card-body px-lg-5 py-lg-5">
                                    <div class="text-center text-muted mb-4">
                                        <small>Form Tambah Budget Beasiswa Baru</small>
                                    </div>
                                    <form role="form" method="post">
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                                </div>
                                                <select class="form-control" placeholder="Pilih Jenis Beasiswa" name="kd_bsw" id="kd_bsw" title="Pilih Jenis Beasiswa" oninvalid="this.setCustomValidity('Selahkan pilih jenis beasiswa.')" oninput="setCustomValidity('')" required>
                                                    <option selected value="">Pilih Jenis Beasiswa</option>
                                                    <option value="2">Pinjaman Registrasi</option>
                                                    <option value="1">Beasiswa Kebutuhan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp. </span>
                                                </div>
                                                <input class="form-control" name="nominal" id="nominal" placeholder="Nominal Budget" type="text" title="Masukkan Nominal Budget" oninvalid="this.setCustomValidity('Selahkan masukkan budget beasiswa baru.')" oninput="setCustomValidity('')" required>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                </div>
                                                <select class="form-control" name="tahun" id="yearpicker" onmousedown="if(this.options.length>4){this.size=2;}" onchange='this.size=0;' onblur="this.size=0;">
                                                    <option selected value="">Tahun</option>
                                                </select>
                                                <select class="form-control" placeholder="Semester" name="semester" id="semester" title="Pilih Semester" oninvalid="this.setCustomValidity('Selahkan pilih semester.')" oninput="setCustomValidity('')" required>
                                                    <option selected value="">Semester</option>
                                                    <option value="1">Gasal</option>
                                                    <option value="2">Genap</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" id="tambah" name="tambah" class="btn btn-primary my-4">Tambah Budget</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <!-- Page content -->
        <div class="container-fluid mt--6">
            <!-- Table -->
            <div class="row">
                <div class="col">

                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header border-0">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="mb-0">Data Budget Beasiswa</h3>
                                </div>
                                <div class="col-6 text-right">
                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Beasiswa</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Nominal</th>
                                        <th>Pilihan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $cnt = 1;
                                    $sql = "select budget.*
                                    , beasiswa.nama_bsw
                                    from budget, beasiswa
                                    WHERE budget.kd_bsw = beasiswa.id_bsw order by thn_ajaran DESC";
                                    $stmt = $con->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td class="table-user">
                                                <b> <?php echo $cnt++ ?></b>

                                            </td>
                                            <td>
                                                <b> <span class="text-muted"><?php $dtl_bsw_row = htmlentities($row['nama_bsw']);
                                                                                if (strlen($dtl_bsw_row) > 90) $dtl_bsw_row = substr($dtl_bsw_row, 0, 90) . "...";
                                                                                echo $dtl_bsw_row;

                                                                                ?></span></b>
                                            </td>
                                            <td>
                                                <b> <span class="text-muted"><?php $dtl_bsw_row = htmlentities($row['thn_ajaran']);
                                                                                if (strlen($dtl_bsw_row) > 90) $dtl_bsw_row = substr($dtl_bsw_row, 0, 90) . "...";
                                                                                echo $dtl_bsw_row;

                                                                                ?></span></b>
                                            </td>
                                            <td align="right">
                                                <b> <span class="text-muted"><?php
                                                                                $rupiah = $row['nominal'];
                                                                                $hasil_rupiah = "Rp " . number_format($rupiah, 0, ',', '.');
                                                                                echo $hasil_rupiah;
                                                                                ?></span></b>
                                            </td>
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#modal-form2<?php echo $row['id_budget']; ?>" type="button"> <i class="fas fa-pen" style="color:#172b4d;"></i>Edit Budget</span></a>
                                                        <!-- <a class="dropdown-item" href="list_persyaratan_beasiswa?id=<?php echo $row['id_budget'] ?>&del=delete" onClick="return confirm('Yakin ingin menghapus Syarat, <?php echo htmlentities($row['nama_syarat']); ?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Hapus Budget</a> -->
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="col-md-4">
                                            <div class="modal fade" id="modal-form2<?php echo $row['id_budget']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form2" aria-hidden="true">
                                                <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <div class="card bg-secondary border-0 mb-0">
                                                                <div class="card-body px-lg-5 py-lg-5">
                                                                    <div class="text-center text-muted mb-4">
                                                                        <small>Form Ubah Budget Beasiswa</small>
                                                                    </div>
                                                                    <form role="form" method="post">
                                                                        <div class="form-group mb-3">
                                                                            <div class="input-group input-group-merge input-group-alternative">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">Rp. </span>
                                                                                </div>
                                                                                <input name="id_budget" type="hidden" value="<?php echo $row['id_budget']; ?>" />
                                                                                <input class="form-control" name="nominaledit" id="nominal" placeholder="Nominal Budget" type="text" value="<?php echo $row['nominal']; ?>" title="Masukkan Nominal Budget" oninvalid="this.setCustomValidity('Selahkan masukkan budget beasiswa.')" oninput="setCustomValidity('')" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-center">
                                                                            <button type="submit" id="edit" name="edit" class="btn btn-primary my-4">Edit Budget </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            include("include/footer.php"); //Edit topnav on this page
            ?>

            <script type="text/javascript">
                document.getElementById("close_direct").onclick = function() {
                    location.href = "budget";
                };
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
            <script type="text/javascript">
                let startYear = 1800;
                let endYear = new Date().getFullYear();
                for (i = endYear; i > startYear; i--) {
                    $('#yearpicker').append($('<option />').val(i).html(i));
                }
            </script>
        </div>
    </div>

    </body>

    </html>
<?php } ?>