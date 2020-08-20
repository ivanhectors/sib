<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../403');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());
    $parentpage = "akun";
    $childpage = "mahasiswa";

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
                                    <li class="breadcrumb-item active" aria-current="page">Data Mahasiswa</li>
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
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Data Mahasiswa</h3>
                            <p class="text-sm mb-0">
                                Tabel ini merupakan data mahasiswa <strong>aktif</strong> yang tersedia pada database untuk dapat melakukan pengajuan beasiswa. Jika akun belum <strong>tersedia</strong>, admin dapat melakukan registrasi akun baru secara <a href="tambah_mahasiswa"> manual <i class='fas fa-external-link-alt'></i></a> atau dengan mengimport data akun secara massal dengan file <strong>.CSV</strong> pada halaman <a href="import_mhs_csv">Import Data <i class='fas fa-external-link-alt'></i></a>.
                            </p>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive py-4">
                            <table class="table align-items-center table-hover table-flush table-striped" id="tabelMhs">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID MHS</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Email</th>
                                        <th>No Telpon</th>
                                        <th>Pilihan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID MHS</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Email</th>
                                        <th>No Telpon</th>
                                        <th>Pilihan</th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    <tr>
                                        <td>ID MHS</td>
                                        <td>NIM</td>
                                        <td>Nama Mahasiswa</td>
                                        <td>Email</td>
                                        <td>No Telpon</td>
                                        <td>Pilihan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Data Akun Duplikat Mahasiswa</h3>
                            <p class="text-sm mb-0">
                                Tabel ini merupakan data akun mahasiswa yang memiliki <strong>Duplikat</strong> akun. Jika data tersedia, Admin <strong>diwajibkan</strong> untuk menghapus akun yang duplikat tersebut dengan memilih akun yang tidak terpakai. Akun yang masuk kategori duplikat ialah akun yang memiliki <strong>NIM</strong> sama dalam database.
                            </p>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive py-4">
                            <table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                                <thead class="thead-light">
                                    <tr>
                                        <th>NIM</th>
                                        <th class="text-center">Jumlah Akun Duplikat</th>
                                        <th>Pilihan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>NIM</th>
                                        <th class="text-center">Jumlah Akun Duplikat</th>
                                        <th>Pilihan</th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    <?php $query = "SELECT username, COUNT(username) AS duplikat FROM user_mhs GROUP BY username HAVING  COUNT(username) > 1 ORDER BY username ASC";
                                    $stmt = $con->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {

                                    ?>
                                        <tr>
                                            <td class="table-user">
                                                <b>
                                                    <span class="text-muted"><?php echo htmlentities($row['username']); ?></span>
                                                </b>
                                            </td>
                                            <td class="text-center">
                                                <span class="h4 text-muted"><?php echo htmlentities($row['duplikat']); ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="cari_mahasiswa?carimhs=<?php echo htmlentities($row['username']); ?>" class='btn btn-default btn-sm text-white'>Detail <i class='fas fa-chevron-circle-right text-white'></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                    } ?>
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
                $(document).ready(function() {
                    var table = $('#tabelMhs').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "pagingType": "full_numbers",
                        "ajax": "scripts/get_data_mahasiswa.php",
                        "order": [
                            [1, "asc"]
                        ],
                        "language": {
                            "lengthMenu": "Menampilkan _MENU_ data per halaman",
                            "zeroRecords": "Maaf, Data yang dicari tidak ditemukan.",
                            "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                            "infoEmpty": "Tidak ada data tersedia.",
                            "infoFiltered": "(Dicari dari total _MAX_ data)",
                            "paginate": {
                                "previous": "<i class='fas fa-angle-left'></i>",
                                "next": "<i class='fas fa-angle-right'></i>",
                                "first": "<i class='fas fa-angle-double-left'></i>",
                                "last": "<i class='fas fa-angle-double-right'></i>"
                            }
                        },

                        "columnDefs": [{
                            "targets": -1,
                            "data": null,
                            "defaultContent": "<button class='btn btn-default btn-sm linkMhs'>Detail <i class='fas fa-chevron-circle-right'></button>"
                        }]
                    });

                    $('#tabelMhs tbody').on('click', '.linkMhs', function() {
                        var data = table.row($(this).parents('tr')).data();
                        window.location.href = "cari_mahasiswa?carimhs=" + data[1];
                    });

                });
            </script>
            <script type="text/javascript">
                document.getElementById("close_direct").onclick = function() {
                    location.href = "data_penyeleksi";
                };
            </script>


        </div>
    </div>

    </body>

    </html>
<?php } ?>