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
    $page = "riwayat_pengajuan";

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
                            <h6 class="h2 text-white d-inline-block mb-0">Export Riwayat Penerima</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="../adm?id"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="../adm?id">Dashboards</a></li>
                                    <li class="breadcrumb-item"><a href="../adm/riwayat_pengajuan">Riwayat P...</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Export Riwayat Penerima</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-3 col-5 text-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Batas Header & Breadcrumbs -->





        <!-- Page content -->
        <div class="container-fluid mt--6">

            <div class="card bg-gradient-default">
                <div class="card-header bg-transparent">
                    <h3 class="mb-0 text-white">Pilih Semester</h3>
                </div>
                <div class="card-body">
                    <form method="get" enctype="multipart/form-data">
                        <!-- Multiple -->
                        <div class="form-group">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <select onchange="location = this.value;" class="form-control" name="tahun" type="text" id="status" placeholder="NIM" required>
                                        <?php $tahun = $_GET['tahun'];
                                        if ($tahun == '') {
                                            echo "<option selected='selected' value='' disabled>-- Pilih Semester --</option>";
                                        } else {
                                            echo "<option selected='selected' value='' disabled>" . $_GET['tahun'] . " " . $_GET['semester'] . "</option>";
                                        };
                                        ?>
                                        <!-- <option selected="selected" value="" disabled>-- Pilih Semester --</option> -->
                                        <?php
                                        $status = 'diterima';
                                        $sql = "SELECT DISTINCT
                                    pendaftaran.thn_ajaran
                                    , pendaftaran.semester
                                    FROM pendaftaran
                                    WHERE pendaftaran.status = ? ORDER BY pendaftaran.thn_ajaran DESC ";
                                        $stmt = $con->prepare($sql);
                                        $stmt->bind_param("s", $status);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <option value="riwayat_pengajuan_exp?tahun=<?php echo htmlentities($row['thn_ajaran']); ?>&semester=<?php echo htmlentities($row['semester']); ?>"><?php echo htmlentities($row['thn_ajaran']); ?> <?php echo htmlentities($row['semester']); ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                                <!-- <div class="col-md-2">
                                    <div>
                                        <button type="submit" class="btn btn-icon btn-white float-right">
                                            <span class="btn-inner--icon"><i class="fas fa-calendar-check"></i></span>
                                            <span class="btn-inner--text">Pilih</span>
                                        </button>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="row">
                <div class="col">

                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="mb-0">Data Riwayat Penerima Beasiswa</h3>
                                    <p class="text-sm mb-0">
                                        Data pada tabel ini merupakan data penerima Beasiswa Kebutuhan & Pinjaman Registrasi per-semester nya. Jika data kosong, pastikan memilih semester agar data dapat ditampilkan pada tabel.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Light table -->
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="tabel-penerima-beasiswa">
                                <thead class="thead-light">
                                    <tr>
                                        <th>
                                            NO
                                        </th>
                                        <th>
                                            Kode Daftar
                                        </th>
                                        <th>
                                            NIM
                                        </th>
                                        <th>
                                            Nama Mahasiswa
                                        </th>
                                        <th>
                                            IPK
                                        </th>
                                        <th>
                                            Beasiswa
                                        </th>
                                        <th>
                                            Tanggal Daftar
                                        </th>
                                        <th>
                                            Tahun Ajaran
                                        </th>
                                        <th>
                                            Nominal Invoice
                                        </th>
                                        <th>
                                            Dana Diberikan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 1;
                                    $status = 'diterima';
                                    $tahun_ajaran = $_GET['tahun'];
                                    $semester = $_GET['semester'];
                                    $sql = "SELECT pendaftaran.*, user_mhs.nama_mhs, user_mhs.nim, beasiswa.nama_bsw
                                    FROM pendaftaran, user_mhs
                                    JOIN beasiswa
                                    WHERE pendaftaran.status = ? AND pendaftaran.id_mhs = user_mhs.id_mhs AND pendaftaran.thn_ajaran = ? AND pendaftaran.semester = ? AND pendaftaran.kd_bsw = beasiswa.id_bsw ORDER BY pendaftaran.kd_daftar DESC";
                                    $stmt = $con->prepare($sql);
                                    $stmt->bind_param("sss", $status, $tahun_ajaran, $semester);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td>
                                                <b> <?php echo $cnt ?></b>

                                            </td>
                                            <td>
                                                <b> <?php echo htmlentities($row['kd_daftar']); ?></b>

                                            </td>
                                            <td>

                                                <?php echo htmlentities($row['nim']); ?>
                                            </td>
                                            <td>

                                                <?php echo htmlentities($row['nama_mhs']); ?>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php echo htmlentities($row['ipk']); ?>
                                            </td>
                                            <td>

                                                <?php echo htmlentities($row['nama_bsw']); ?>
                                            </td>
                                            <td>
                                                <?php
                                                $tanggal = $row['tgl_daftar'];
                                                echo date('d/m/Y', strtotime($tanggal));
                                                ?>

                                            </td>
                                            <td class="table-user">
                                                <?php echo htmlentities($row['thn_ajaran']); ?> <?php echo htmlentities($row['semester']); ?>
                                            </td>
                                            <td align="right">
                                                <?php
                                                $nominal_invoice = $row['nominal_pengajuan'];
                                                $hasil_rupiah = "Rp " . number_format($nominal_invoice, 0, ',', '.');
                                                echo $hasil_rupiah;  ?>


                                            </td>

                                            <td align="right">
                                                <?php
                                                $nominal_disetujui = $row['nominal_disetujui'];
                                                $hasil_rupiah = "Rp " . number_format($nominal_disetujui, 0, ',', '.');
                                                echo $hasil_rupiah;
                                                ?>


                                            </td>

                                        </tr>
                                    <?php
                                        $cnt = $cnt + 1;
                                    } ?>
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
            <script src="../assets/vendor/datatables.net-buttons/js/buttons.pdfmake.min.js"></script>
            <script src="../assets/vendor/datatables.net-buttons/js/vfs_fonts.js"></script>



            <script>
                var nominal = document.getElementById("nominal");

                nominal.value = convertRupiah(this.value, "Rp. ");


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

            <script>
                $('#link').on('submit', function(e) {
                    e.preventDefault();
                    var $form = $(this),
                        $select = $form.find('select'),
                        links = $select.val();
                    if (links.length > 0) {
                        for (i in links) {
                            link = links[i];
                            window.open(link);
                        }
                    }
                });
            </script>
            <script>

                var DatatableButtons = (function() {
                    // Variables
                    var $dtButtons = $('#tabel-penerima-beasiswa');
                    // Methods
                    function init($this) {
                        var buttons = [
                            "copy", "print",
                            {
                                extend: 'pdfHtml5',
                                text: 'PDF',
                                title: 'Data Penerima Bantuan Dana Beasiswa Kebutuhan & Pinjaman Registrasi Tahun Ajaran <?php echo $_GET['tahun']; ?> <?php echo  $_GET['semester']; ?>',
                                pageSize: 'A4',
                                orientation: 'landscape',
                                customize: function(doc) {
                                    var docDefinition = {
                                        // a string or { width: number, height: number }
                                        pageSize: 'A4',
                                        // by default we use portrait, you can change it to landscape if you wish
                                        pageOrientation: 'landscape',
                                        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
                                        pageMargins: [40, 60, 40, 60],
                                    };
                                    var cols = [];
                                    cols[0] = {
                                        image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAOCAYAAABdC15GAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAABmJLR0QAAAAAAAD5Q7t/AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAB3RJTUUH5AkMEBMX+N1J2AAAA3RJREFUSMe91VuIVWUUB/DfmXHMgbxRFjTbIqNEDbpHkWF2oZII6SGknBMJIT2UsXuICh96CemyIwok7EJ7IlEoogtZkEaXh2AwSCvJUZK2zqRmmenMqDOnh28dPE4zry3YD/vjW2v913/91/pqJrB6Xk3BVbgdu/B5WWT9/merjQOsC4txD27AORjCj/g4vm1lkQ1PUNgMXIaZ+AM78Tvm4jz047cofnKL6wj2NujrKbKR0wDW82pqBF2KO3EJJqGBYxGoI3wO4hu8jy3YVxbZaMSZjwI3ojMK+wzL8RxWoAcvx/nZgaGGURzAOjxfFtkgtEXSF/AJHsf8AAc/4SG8FQFE0KV4GxtxUYDrxDMhiZHwPRQ5jkeRU6LQNpwR35EANogMT+KOJoNNgOvwbDBysIX2OXgad7fcHYrkm/Ae9sb5+ViIk3gqZLIYqzWcnEBix7EKiyLHjihicX3FLzSZKousF731vBrA9VHZvPgWBCO7sR0D0fYtOFwW2bFI1tEig+EGh3qK7ECLNscDOIq9ZZH11fPqQGg2xWqbdApgi12BB/ErtmI9LsUeTMNNUe1hfBftadqeOFuCNTUW1fPqHWwui+z4BAx2YHU9r1ZiFq6OVn9Vvj7ntBa3VjRZGpIOaYpvxV1oRxemS8PTaHUsi+wInsCnmIr7JY2uqefVtLH3w9pxM5bhlujcLmkIxwXY/B+QtLgEXwSo69A7gV8T5HbchwfwURT7KLqdGrJWG8EHeBUboiNzsaw7JDE20U7slzTWGUG/RYUZQf+gJOZRnNl07M6rtu68ai+L7K+yyNbjXmkztEvDMnkcgCdQlEX2SKNhOTZH5xbVQs9jNfgGvpZ0B5fjFQzjNXwfd7ZJkzqrnlebyiI7UeNCPFbPqy+j0OkhCTg6AYNtWFDPqyHpQbg4zv9sNNL90wCWRTaEH+p51SftulXR2n5pV+0vi6w3dt41krBnButdWImHpSHqkLR4DB/itjHgasHqi9Jqau7Fv7Gx56X0moxlsGnzoi27JdFfKYm5qufV1mjNmwGgOckDAeRanBWM7cBa6XlcKC3uowHokFOvCPyDn0OPm1qr+I/V86ojmJs9MqnxbvvJ2lzp+VrfUDvaU3SZwK9TavVsaWr7hgdHdm9Ye4F6Xs3BucF2v/RidbS4j6Aqi2xfa8x/AbL8Hxm2gzafAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIwLTA5LTEyVDE2OjE5OjIzLTA0OjAw+F62BAAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMC0wOS0xMlQxNjoxOToyMy0wNDowMIkDDrgAAAAASUVORK5CYII=',
                                        alignment: 'left',
                                        margin: [20]
                                    };
                                    var today = new Date();
                                    var date = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
                                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                                    var dateTime = date + ' ' + time;
                                    cols[1] = {

                                        text: 'Diunduh Pada :' + ' ' + dateTime,
                                        alignment: 'right',
                                        margin: [0, 0, 20]
                                    };
                                    var objFooter = {};
                                    objFooter['columns'] = cols;
                                    doc['footer'] = objFooter;
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        text: ' ',
                                    });
                                },
                                exportOptions: {
                                    modifier: {
                                        page: 'current'
                                    }
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                filename: 'Data Penerima Bantuan Dana Beasiswa Kebutuhan & Pinjaman Registrasi Tahun Ajaran <?php echo $_GET['tahun']; ?> <?php echo  $_GET['semester']; ?>',
                                title: 'Data Penerima Bantuan Dana Beasiswa Kebutuhan & Pinjaman Registrasi Tahun Ajaran <?php echo $_GET['tahun']; ?> <?php echo  $_GET['semester']; ?>',
                                customize: function(xlsx) {
                                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                    $('row:first c', sheet).attr('s', '51');
                                }
                            }
                        ];


                        // Basic options. For more options check out the Datatables Docs:
                        // https://datatables.net/manual/options

                        var options = {

                            lengthChange: !1,
                            dom: 'Bfrtip',
                            buttons: buttons,
                            "columnDefs": [{
                                    "targets": [3],
                                    "visible": false,
                                    "searchable": false
                                },
                                {
                                    "targets": [4],
                                    "visible": false,
                                    "searchable": false
                                },
                                {
                                    "targets": [8],
                                    "visible": false,
                                    "searchable": false
                                }
                            ],
                            // select: {
                            // 	style: "multi"
                            // },
                            language: {
                                paginate: {
                                    previous: "<i class='fas fa-angle-left'>",
                                    next: "<i class='fas fa-angle-right'>"
                                }
                            }
                        };

                        // Init the datatable

                        var table = $this.on('init.dt', function() {
                            $('.dt-buttons .btn').removeClass('btn-secondary').addClass('btn-sm btn-default');
                        }).DataTable(options);
                    }



                    // Events

                    if ($dtButtons.length) {
                        init($dtButtons);
                    }

                })();
            </script>
        </div>
    </div>
    </body>

    </html>
<?php } ?>