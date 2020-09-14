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
    $page = "riwayat_pembayaran";


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
                        <div class="col-lg-9 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Pembayaran</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="../adm?id"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../adm?id">Dashboards</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Riwayat Pembayaran Mahasiswa</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-3 col-5 text-right">
                            <a href="riwayat_Pembayaran_exp?tahun=&semester=" class="btn btn-sm btn-neutral"><i class="fas fa-cloud-download-alt" style="color:primary;"> </i> Download PDF/XLSX</a>

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
                        <div class="card-header border-0">
                            <div class="row">
                                <div class="col-6">
                                    <h3 class="mb-0">Data Riwayat Pembayaran Mahasiswa</h3>
                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive py-4">
                            <table class="table align-items-center table-hover table-flush table-striped" id="tblPembayaran">
                                <thead class="thead-light">
                                    <tr>
                                        <th>
                                            <center>Kode Bayar
                                        </th>
                                        <th>
                                            <center>Kode Daftar
                                        </th>
                                        <th>
                                            <center>Tanggal Bayar
                                        </th>
                                        <th>
                                            <center>Nominal Bayar
                                        </th>
                                        <th>
                                            <center>Status
                                        </th>
                                        <th>
                                            <center>Pilihan
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>
                                            <center>Kode Bayar
                                        </th>
                                        <th>
                                            <center>Kode Daftar
                                        </th>
                                        <th>
                                            <center>Tanggal Bayar
                                        </th>
                                        <th>
                                            <center>Nominal Bayar
                                        </th>
                                        <th>
                                            <center>Status
                                        </th>
                                        <th>
                                            <center>Pilihan
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td>
                                            <center>Kode Bayar
                                        </td>
                                        <td>
                                            <center>Kode Daftar
                                        </td>
                                        <td>
                                            <center>Tanggal Bayar
                                        </td>
                                        <td>
                                            <center>Nominal Bayar
                                        </td>
                                        <td>
                                            <center>Status
                                        </td>
                                        <td>
                                            <center>Pilihan
                                        </td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Image overlay -->
            <div class="card bg-dark text-white border-0">
                <img class="card-img" src="../assets/img/quotes.jpg" alt="List Beasiswa">
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
                $(document).ready(function() {
                    var table = $('#tblPembayaran').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "pagingType": "full_numbers",
                        "ajax": "scripts/get_data_pembayaran.php",
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
                            "defaultContent": "<button class='btn btn-default btn-sm linkByr'>Detail <i class='fas fa-chevron-circle-right'></button>"
                        },
                        {
                            "targets": -2,
                            "data": 4,
                            
                            render: function(data, type, row) {
                                if (data == 'Dibayar') {
                                    return '<span class="badge badge-success">Dibayar</span>';
                                } else {
                                    return '<span class="badge badge-warning">Belum Dibayar</span>';
                                }
                            }
                        }
                    ]
                    });

                    $('#tblPembayaran tbody').on('click', '.linkByr', function() {
                        var data = table.row($(this).parents('tr')).data();
                        window.location.href = "form?id_bsw=2&kd_daftar=" + data[1] + "&total_invoice=" + data[3];
                    });

                });
            </script>
        </div>
    </div>

    </body>

    </html>
<?php } ?>