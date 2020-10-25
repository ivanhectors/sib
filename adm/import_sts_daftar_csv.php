<?php
session_start();

include("include/config.php");

use Phppot\DataSource;

require_once 'include/DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../403');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    // include("include/header.php");
    // include("include/sidebar.php");

    $parentpage = "akun";
    $childpage = "mahasiswa";

    if (isset($_POST["import"])) {

        $fileName = $_FILES["file"]["tmp_name"];

        if ($_FILES["file"]["size"] > 0) {

            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

                $kd_daftar = "";
                if (isset($column[0])) {
                    $kd_daftar = mysqli_real_escape_string($conn, $column[0]);
                }
                $acc_id = "";
                if (isset($column[1])) {
                    $acc_id = mysqli_real_escape_string($conn, $column[1]);
                }
                $acc_role = "";
                if (isset($column[2])) {
                    $acc_role = mysqli_real_escape_string($conn, $column[2]);
                }
                $acc_tanggal = "";
                if (isset($column[3])) {
                    $acc_tanggal = mysqli_real_escape_string($conn, $column[3]);
                }
                $status = "";
                if (isset($column[4])) {
                    $status = mysqli_real_escape_string($conn, $column[4]);
                }

                $sqlInsert = "INSERT into sts_daftar (kd_daftar, acc_id, acc_role, acc_tanggal, status)
                       values (?,?,?,?,?)";
                $paramType = "sssss";
                $paramArray = array(
                    $kd_daftar,
                    $acc_id,
                    $acc_role,
                    $acc_tanggal,
	                $status
                );
                $insertId = $db->insert($sqlInsert, $paramType, $paramArray);

                if (!empty($insertId)) {
                    $type = "success";
                    $message = "Data Riwayat Status Penerima Pinjaman dan Beasiswa berhasil diimport.";
                } else {
                    $type = "error";
                    $message = "Terjadi kesalahan saat meng-import data. Pastikan format .CSV benar lalu coba lagi.";
                }
            }
        }
    }




?>
    <?php
    include("include/header.php");
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#frmCSVImport").on("submit", function() {

                $("#response").attr("class", "");
                $("#response").html("");
                var fileType = ".csv";
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
                if (!regex.test($("#file").val().toLowerCase())) {
                    $("#response").addClass("error");
                    $("#response").addClass("display-block");
                    $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
                    return false;
                }
                return true;
            });
        });
    </script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <style>
        .outer-scontainer {
            background: #F0F0F0;
            border: #e0dfdf 1px solid;
            padding: 20px;
            border-radius: 2px;
        }

        .input-row {
            margin-top: 0px;
            margin-bottom: 20px;
        }

        .btn-submit {
            background: #333;
            border: #1d1d1d 1px solid;
            color: #f0f0f0;
            font-size: 0.9em;
            width: 100px;
            border-radius: 2px;
            cursor: pointer;
        }

        .outer-scontainer table {
            border-collapse: collapse;
            width: 100%;
        }

        .outer-scontainer th {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        .outer-scontainer td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        #response {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 2px;
            display: none;
        }

        .success {
            background: #c7efd9;
            border: #bbe2cd 1px solid;
        }

        .error {
            background: #fbcfcf;
            border: #f3c6c7 1px solid;
        }

        div#response.display-block {
            display: block;
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
        <!-- Header -->
        <!-- INSERT into user_mhs (nim,nama_mhs,password,id_fakultas,id_prodi,id_dosen_wali,id_role)
values ('31170031','Kevin','$2y$10$45c9JSZ.tEiOmaQD8b3KQeIklOOYJiV/ckWEiO3HG4vQuwH8/GK3G','3','31','2','5') -->

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
                        <div class="col-8">
                            <!-- Title -->
                            <h3 class="mb-0">Import Data Mahasiswa</h3>
                        </div>
                    </div>
                </div>

                <!-- Card body -->
                <div class="card-body">
                    <!-- Form groups used in grid -->

                    <form class="form-horizontal" action="" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                        <!-- Address -->
                        <div id="response" class="<?php if (!empty($type)) {
                                                        echo $type . " display-block";
                                                    } ?>">
                            <?php if (!empty($message)) {
                                echo $message;
                            } ?>
                        </div>
                        <h6 class="heading-small text-muted mb-4">Pilih File</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" type="file" name="file" id="file" accept=".csv" class="custom-file-input" id="customFileLang" lang="id">
                                        <label class="custom-file-label" for="customFileLang">Pilih .CSV file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="text-left">
                                        <span class="badge badge-pill badge-warning">* Hanya Menerima .CSV File</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right pb-0">
                            <button class="btn btn-icon btn-primary text-white" id="submit" name="import" type="submit">
                                <span class="btn-inner--icon"><i class="fas fa-cloud-upload-alt"></i></span>
                                <span class="btn-inner--text">Upload</span>
                            </button>

                        </div>
                    </form>
                    <hr class="my-4" />
                    <!-- Address -->
                    <h6 class="heading-small text-muted mb-4">Panduan Import Akun</h6>
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="h4">1. Sebelum melakukan <mark>Import</mark> data dengan file .CSV, Pastikan <mark>Format</mark> sesuai dengan yang ditetapkan.</p>
                            <p class="h4">2. File .CSV yang di upload hanya menerima Delimeter bertipe Comma <mark>(,)</mark>. </p>
                            <p class="h4">3. Format Excel (<i class="fas fa-file-excel text-green"></i>) dapat di unduh <a href="">disini</a>.</p>
                            <p class="h4">4. Jika tidak terjadi kesalahan dan berhasil (<i class="fas fa-check text-green"></i>) Import Data, Pastikan untuk memeriksa ulang akun apakah terjadi duplikat (Akun Ganda) pada halaman <a href="data_mahasiswa#datatable-buttons">data mahasiswa</a>. </p>

                        </div>
                    </div>




                </div>

            </div>




            <?php
            include("include/footer.php"); //Edit topnav on this page
            ?>

            <script type="text/javascript">
                document.getElementById("close_direct").onclick = function() {
                    location.href = "data_penyeleksi";
                };
            </script>
            <script>
                $(document).on('change', '.custom-file-input', function(event) {
                    $(this).next('.custom-file-label').html(event.target.files[0].name);
                })
            </script>
        </div>
    </div>

    </body>

    </html>
<?php } ?>