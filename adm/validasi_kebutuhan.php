<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../403');
} else {
    error_reporting(0);
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    // include("include/header.php");
    // include("include/sidebar.php");
    $parentpage = "pengajuan";
    $subchildpage = "validasi";
    $childpage = "validasi_kebutuhan";



    $year = date('Y');
    $tahun = date('n');
    if ($tahun <= 6) {
        $tahun = intval($year - 1) . "2";
    } else {
        $tahun = $year . "1";
    }
    $kd_bsw = '1';
    $status = 'diterima';
    $sql = "SELECT budget.nominal AS budget_beasiswa
    FROM budget
    WHERE budget.thn_ajaran = ? AND budget.kd_bsw = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $tahun, $kd_bsw);
    $stmt->execute();
    $result = $stmt->get_result();
    $budget_beasiswa = $result->fetch_assoc();

    $sql2 = "SELECT SUM(pendaftaran.nominal_disetujui) AS dana_keluar
    FROM pendaftaran
    WHERE pendaftaran.tahun = ? AND pendaftaran.status = ? AND pendaftaran.kd_bsw = ?";
    $stmt2 = $con->prepare($sql2);
    $stmt2->bind_param("isi", $tahun, $status, $kd_bsw);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $dana_keluar = $result2->fetch_assoc();

    $bb = $budget_beasiswa['budget_beasiswa'];
    $dk = $dana_keluar['dana_keluar'];
    $hasil_kurang = $bb - $dk;
    $budget_sekarang = $hasil_kurang;


    //Proses Validasi
    if (isset($_POST['validasi'])) {
        $status = 'diterima';
        $kd_daftar = $_POST['kd_daftar'];
        $nominal_disetujui = $_POST['nominal_disetujui'];
        if ($nominal_disetujui <= $budget_sekarang) {
            $valid = $con->prepare("UPDATE pendaftaran SET status = ?, nominal_disetujui = ? WHERE kd_daftar = ?");
            $valid->bind_param('sii', $status, $nominal_disetujui, $kd_daftar);
            /* execute prepared statement */
            $valid->execute();
            // printf("%d Row inserted.\n", $valid->affected_rows);
            /* close statement */
            $valid->close();


            $_SESSION['success'] = "Berhasil melakukan validasi terhadap Nomor Pendaftaran " . $_POST['kd_daftar'];
        } else {

            $_SESSION['error'] = "Budget bantuan dana anda kurang. Silahkan menambah Budget anda untuk melakukan validasi selanjutnya.";
        }
    }

    //Proses Diskulaifikasi / Tolak
    if (isset($_POST['tolak'])) {
        $status = 'ditolak';
        $kd_daftar = $_POST['kd_daftar'];
        $valid = $con->prepare("UPDATE pendaftaran SET status = ? WHERE kd_daftar = ?");
        $valid->bind_param('si', $status, $kd_daftar);
        /* execute prepared statement */
        $er = $valid->execute();
        // printf("%d Row inserted.\n", $valid->affected_rows);
        /* close statement */
        if (false === $er) {
            $_SESSION['error'] = htmlspecialchars($valid->error);
            // die('execute() failed: ' . htmlspecialchars($valid->error));
        } else {
            $_SESSION['success'] = "Berhasil mendiskualifikasi atau menolak terhadap Nomor Pendaftaran " . $_POST['kd_daftar'] . ".";
        }
        $valid->close();
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
                            <h6 class="h2 text-white d-inline-block mb-0">Validasi</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="../adm?id"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../adm?id">Dashboards</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Validasi Beasiswa Kebutuhan</li>
                                </ol>
                            </nav>
                        </div>
                        <!-- <div class="col-lg-6 col-5 text-right">
                            <a href="riwayat_pengajuan_exp?tahun=&semester=" class="btn btn-sm btn-neutral"><i class="fas fa-cloud-download-alt" style="color:primary;"> </i> Download PDF/XLSX</a>

                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Batas Header & Breadcrumbs -->





        <!-- Page content -->
        <div class="container-fluid mt--6">
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

            <!-- Table -->
            <div class="row">
                <div class="col">

                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header border-0">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-0">Data Pengajuan Beasiswa Kebutuhan</h3>
                                    <p class="text-sm mb-0">
                                        Data pada tabel ini merupakan data hasil seleksi pengajuan dari <strong>Wakil Dekan Fakultas III</strong> yang menjadi kandidat penerima Beasiswa Kebutuhan.
                                        Silahkan menggunakan tombol <strong>opsi</strong>, untuk menentukan validasi anda.
                                    </p>
                                    <p class="text-sm">
                                        *<strong>P1</strong> = Poin Gaji Orangtua | <strong>P2</strong> = IPK Mahasiswa | <strong>P3</strong> = Poin Semester
                                    </p>

                                    <p class="mb-0">Budget Pinjaman Semster Ini : <b><?php $bb_demo = htmlentities($budget_beasiswa['budget_beasiswa']);
                                                                                        $hasil = "Rp " . number_format($bb_demo, 0, ',', '.');
                                                                                        echo $hasil; ?></b> | Dana Keluar : <b><?php $dk_demo = htmlentities($dana_keluar['dana_keluar']);
                                                                                                                                $hasil = "Rp " . number_format($dk_demo, 0, ',', '.');
                                                                                                                                echo $hasil; ?></b></p>
                                    <p class="mb-0">Sisa Dana Budget :<b>
                                            <?php
                                            $bb = htmlentities($budget_beasiswa['budget_beasiswa']);
                                            $dk = htmlentities($dana_keluar['dana_keluar']);
                                            $hasil_kurang = $bb - $dk;
                                            $hasil = "Rp " . number_format($hasil_kurang, 0, ',', '.');
                                            echo $hasil;

                                            // $rupiah_test = "Rp 88.850.000";
                                            // $output = str_replace([':', '\\',' ', 'Rp', '.'], '', $rupiah_test);
                                            // $nominal = trim($output, '');
                                            // echo $nominal;
                                            ?></b>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive py-4">
                            <table class="table align-items-center table-flush table-striped" id="datatable-buttonss">
                                <thead class="thead-light">
                                    <tr>
                                        <th>
                                            <center>Kode Daftar
                                        </th>
                                        <th>
                                            <center>NIM
                                        </th>
                                        <th>
                                            <center>Tanggal Daftar
                                        </th>
                                        <th>
                                            <center>P1
                                        </th>
                                        <th>
                                            <center>P2
                                        </th>
                                        <th>
                                            <center>P3
                                        </th>
                                        <th>
                                            <center>Total
                                        </th>
                                        <th>
                                            <center>Status
                                        </th>
                                        <th>
                                            <center>Nominal
                                        </th>
                                        <th>
                                            <center>Opsi
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <center>Kode Daftar
                                        </th>
                                        <th>
                                            <center>NIM
                                        </th>
                                        <th>
                                            <center>Tanggal Daftar
                                        </th>
                                        <th>
                                            <center>P1
                                        </th>
                                        <th>
                                            <center>P2
                                        </th>
                                        <th>
                                            <center>P3
                                        </th>
                                        <th>
                                            <center>Total
                                        </th>
                                        <th>
                                            <center>Status
                                        </th>
                                        <th>
                                            <center>Nominal
                                        </th>
                                        <th>
                                            <center>Opsi
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $status = 'acc-wakil-dekan';
                                    $query = "Select kd_daftar, user_mhs.nim, gaji_ortu, kd_bsw, tgl_daftar,
                                    CASE
                                    WHEN gaji_ortu > 2000000 THEN '0'
                                    WHEN gaji_ortu >= 1800000 THEN '1'
                                    WHEN gaji_ortu >= 1650000 THEN '2'
                                    WHEN gaji_ortu >= 1500000 THEN '3'
                                    WHEN gaji_ortu >= 1300000 THEN '4'
                                    WHEN gaji_ortu >= 1150000 THEN '5'
                                    WHEN gaji_ortu >= 1000000 THEN '6'
                                    WHEN gaji_ortu >= 800000 THEN '7'
                                    WHEN gaji_ortu >= 650000 THEN '8'
                                    WHEN gaji_ortu >= 500000 THEN '9'
                                    WHEN gaji_ortu < 500000 THEN '10'
                                    Else '0'
                                    END AS poin_gaji_ortu,
                                    ipk,
                                    CASE
                                    WHEN ipk < 2.25 THEN '0'
                                    WHEN ipk <= 2.32 THEN '1'
                                    WHEN ipk <= 2.4 THEN '2'
                                    WHEN ipk <= 2.5 THEN '3'
                                    WHEN ipk <= 2.58 THEN '4'
                                    WHEN ipk <= 2.65 THEN '5'
                                    WHEN ipk <= 2.75 THEN '6'
                                    WHEN ipk <= 2.82 THEN '7'
                                    WHEN ipk <= 2.99 THEN '8'
                                    WHEN ipk <= 3.5 THEN '9'
                                    WHEN ipk <= 4 THEN '10'
                                    Else '0'
                                    END AS poin_ipk,
                                    semester_ke,
                                    CASE
                                    WHEN semester_ke >= 11 THEN '0'
                                    WHEN semester_ke >= 10 THEN '1'
                                    WHEN semester_ke >= 9 THEN '2'
                                    WHEN semester_ke >= 8 THEN '3'
                                    WHEN semester_ke >= 7 THEN '4'
                                    WHEN semester_ke >= 6 THEN '5'
                                    WHEN semester_ke >= 5 THEN '6'
                                    WHEN semester_ke >= 4 THEN '7'
                                    WHEN semester_ke >= 3 THEN '8'
                                    WHEN semester_ke >= 2 THEN '9'
                                    Else '0'
                                    END AS poin_semester,
                                    nominal_pengajuan, pendaftaran.status
                                    from pendaftaran 
                                    JOIN user_mhs
                                    WHERE tahun = ? AND pendaftaran.status = ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND pendaftaran.kd_bsw = ?";
                                    $stmt = $con->prepare($query);
                                    $stmt->bind_param("isi", $tahun, $status, $kd_bsw);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td class="kd_daftar"><b><?php echo htmlentities($row['kd_daftar']); ?></b></td>
                                            <td><?php echo htmlentities($row['nim']); ?></td>
                                            <td><?php $date = $row['tgl_daftar'];
                                                echo date('d-m-Y H:i', strtotime($date)); ?></td>
                                            <td><?php echo htmlentities($row['poin_gaji_ortu']); ?></td>
                                            <td><?php echo htmlentities($row['poin_ipk']); ?></td>
                                            <td><?php echo htmlentities($row['poin_semester']); ?></td>
                                            <td><b><?php $total = $row['poin_gaji_ortu'] + $row['poin_ipk'] + $row['poin_semester'];
                                                    echo $total; ?></b></td>

                                            <td>
                                                <?php $status = htmlentities($row['status']);
                                                if ($status == 'diterima') {
                                                    echo '<span class="badge badge-success">Diterima</span>';
                                                } elseif ($status == 'ditolak') {
                                                    echo '<span class="badge badge-danger">DITOLAK</span>';
                                                } else {
                                                    echo '<span class="badge badge-warning">blm VLD</span>';
                                                }
                                                ?></td>
                                            <td class="nominal_pengajuan"><?php
                                                                            $nominal_invoice = $row['nominal_pengajuan'];
                                                                            $hasil_rupiah = "Rp " . number_format($nominal_invoice, 0, ',', '.');
                                                                            echo $hasil_rupiah;  ?></td>
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item" href="form?id_bsw=<?php echo htmlentities($row['kd_bsw']); ?>&kd_daftar=<?php echo htmlentities($row['kd_daftar']); ?>&total_invoice=<?php echo htmlentities($row['nominal_pengajuan']); ?>" target="_blank" style="color: black;" type="button"><i class="fas fa-search" style="color:#172b4d;"></i>Detail</a>
                                                        <a class="dropdown-item" style="color: black;" type="button" data-toggle="modal" data-id="<?php echo htmlentities($row['kd_daftar']); ?>" data-target="#modal-validasi"><i class="fas fa-check-circle" style="color:#2dce89;"></i>Validasi</a>
                                                        <a class="dropdown-item" style="color: black;" type="button" data-toggle="modal" data-id="<?php echo htmlentities($row['kd_daftar']); ?>" data-target="#modal-tolak"><i class="fas fa-times-circle" style="color:#f5365c;"></i>Diskualifikasi / Tolak</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- Modal Validasi -->
                            <div class="modal hide fade" id="modal-validasi" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                                <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="modal-title-default">Validasi Pendaftaran</h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <h6 class="heading-small text-muted">Kode Pendaftaran :</h6>
                                                        <input type="text" class="form-control kd_daftar" id="kd_daftar" name="kd_daftar" Placeholder="Kode Daftar" onkeypress="return isNumber(event)" readonly />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h6 class="heading-small text-muted">Nominal Pinjaman :</h6>
                                                        <input type="text" name="nominal_pengajuan" class="form-control nominal_pengajuan" id="nominal_pengajuan" Placeholder="Kode Daftar" onkeypress="return isNumber(event)" readonly />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <h6 class="heading-small text-muted">Jumlah Diberikan Dana :</h6>
                                                        <select class="form-control" id="nominal_disetujui" name="nominal_disetujui"  placeholder="Pilih Besaran Dana" title="Silahkan pilih besaran dana yang diberikan." oninvalid="this.setCustomValidity('Silahkan pilih besaran dana yang diberikan.')" oninput="setCustomValidity('')" required>
                                                            <option selected="selected" value="" disabled>-- Pilih Besaran Dana --</option>
                                                            <option value="1000000">Rp. 1.000.000</option>
                                                            <option value="800000">Rp. 800.000</option>
                                                            <option value="650000">Rp. 650.000</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <p>Melakukan Validasi terhadap pendaftaran ini, berarti <b><u>setuju</u></b> bahwa pendaftaran ini telah diterima sebagai salah satu penerima Beasiswa Kebutuhan semester ini. Anda tidak dapat kembali mengubah tindakan ini.</p>
                                                <p><b><u>Anda tidak dapat kembali mengubah tindakan ini.</b></u></p>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-icon btn-primary" name="validasi" type="submit">
                                                <span class="btn-inner--icon"><i class="fas fa-check-circle"></i></span>
                                                <span class="btn-inner--text">Setuju & Validasi</span>
                                            </button>
                                            <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Batal</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Tolak -->
                            <div class="modal fade" id="modal-tolak" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                    <div class="modal-content bg-gradient-danger">

                                        <div class="modal-header">
                                            <h6 class="modal-title" id="modal-title-notification">Mohon Perhatian Anda</h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="py-3 text-center">
                                                    <i class="ni ni-bell-55 ni-3x"></i>
                                                    <h4 class="heading mt-4">Ketentuan Diskualifikasi atau Menolak Pengajuan</h4>
                                                </div>
                                                <div class="text-left">
                                                    <input type="hidden" name="kd_daftar" class="form-control kd_daftar" />
                                                    <p class="mb-0">Anda dapat mendiskualifikasi atau menolak pengajuan ini jika: </p>
                                                    <p class="mb-0"> 1. Anda merasa pengajuan ini terjadi kecurangan atau data yang tidak sah;</p>
                                                    <p class="mb-0"> 2. Dana Budget anda telah mencukupi untuk menerima pengajuan lain.</p>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" name="tolak" class="btn btn-white">Ok, Diskualifikasi atau Tolak</button>
                                                <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                    <!-- Image overlay -->
                    <div class="card bg-dark text-white border-0">
                        <img class="card-img" src="../assets/img/validasi.svg" alt="List Beasiswa">
                        <div class="card-img-overlay align-items-center">
                            <div>
                                <!-- <h5 class="h2 card-title text-white mb-2">Cari Mahasiswa</h5> -->
                                <div class="form-group col-md-6 mt-2">
                                </div>

                            </div>
                        </div>
                    </div>




                    <?php
                    include("include/footer.php"); //Edit topnav on this page
                    ?>
                    <script type="text/javascript">
                        document.getElementById("close_direct").onclick = function() {
                            location.href = "data_admin";
                        };
                    </script>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            var table = $('#datatable-buttonss').DataTable({
                                "order": [
                                    [6, "desc"]
                                ],
                                "columnDefs": [{
                                        "orderable": false,
                                        "targets": 0
                                    },
                                    {
                                        "orderable": false,
                                        "targets": 1
                                    },
                                    {
                                        "orderable": false,
                                        "targets": 2,
                                        "searchable": false
                                    },
                                    {
                                        "orderable": false,
                                        "targets": 3,
                                        "searchable": false
                                    },
                                    {
                                        "orderable": false,
                                        "targets": 4,
                                        "searchable": false
                                    },
                                    {
                                        "orderable": false,
                                        "targets": 5,
                                        "searchable": false
                                    },
                                    {
                                        "orderable": false,
                                        "targets": 6,
                                        "searchable": false
                                    },
                                    {
                                        "orderable": false,
                                        "targets": 7,
                                        "searchable": false
                                    },
                                    {
                                        "orderable": false,
                                        "targets": 8,
                                        "searchable": false
                                    },
                                    {
                                        "orderable": false,
                                        "targets": 9,
                                        "visible": true,
                                        "searchable": false
                                    }
                                ],
                                "language": {
                                    "lengthMenu": "Menampilkan _MENU_ data per halaman",
                                    "zeroRecords": "Maaf, Data yang dicari tidak ditemukan.",
                                    "info": "_PAGE_ dari _PAGES_ halaman | Total Data : _TOTAL_",
                                    "infoEmpty": "Tidak ada data tersedia.",
                                    "infoFiltered": "(Difilter dari total _TOTAL_ data)",
                                    "paginate": {
                                        "previous": "<i class='fas fa-angle-left'></i>",
                                        "next": "<i class='fas fa-angle-right'></i>",
                                        "first": "<i class='fas fa-angle-double-left'></i>",
                                        "last": "<i class='fas fa-angle-double-right'></i>"
                                    }
                                }
                            });

                        });
                    </script>
                    <script>
                        $(document).ready(function() {

                            //$(".zz-modal").click(function() {
                            //  $("#con-close-modal").modal('show');
                            //});

                            $('#modal-validasi').on('show.bs.modal', function(e) {
                                // console.log(e);
                                // console.log(e.relatedTarget);

                                var _button = $(e.relatedTarget); // Button that triggered the modal

                                // console.log(_button, _button.parents("tr"));
                                var _row = _button.parents("tr");
                                var _kd_daftar = _row.find(".kd_daftar").text();
                                var _nominal_pengajuan = _row.find(".nominal_pengajuan").text();
                                // console.log(_kd_daftar, _nominal_pengajuan);

                                $(this).find(".kd_daftar").val(_kd_daftar);
                                $(this).find(".nominal_pengajuan").val(_nominal_pengajuan);

                                // document.getElementById("kd_daftar").val=(_kd_daftar);
                                // document.getElementById("nominal_pengajuan").value=_nominal_pengajuan;

                            });

                        });
                    </script>
                    <script>
                        $(document).ready(function() {

                            //$(".zz-modal").click(function() {
                            //  $("#con-close-modal").modal('show');
                            //});

                            $('#modal-tolak').on('show.bs.modal', function(e) {
                                // console.log(e);
                                // console.log(e.relatedTarget);

                                var _button = $(e.relatedTarget); // Button that triggered the modal

                                // console.log(_button, _button.parents("tr"));
                                var _row = _button.parents("tr");
                                var _kd_daftar = _row.find(".kd_daftar").text();
                                var _nominal_pengajuan = _row.find(".nominal_pengajuan").text();
                                // console.log(_kd_daftar, _nominal_pengajuan);

                                $(this).find(".kd_daftar").val(_kd_daftar);
                                $(this).find(".nominal_pengajuan").val(_nominal_pengajuan);

                                // document.getElementById("kd_daftar").val=(_kd_daftar);
                                // document.getElementById("nominal_pengajuan").value=_nominal_pengajuan;

                            });

                        });
                    </script>

                </div>
            </div>

            </body>

            </html>
        <?php } ?>