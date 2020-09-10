<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../login');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());



    if (isset($_POST['update'])) {
        $id_info = '1';
        $jdl_info = $_POST["jdl_info"];
        $dtl_info = $_POST["dtl_info"];
        $status = $_POST["status"];


        //edit fakultas
        $sql = mysqli_query($con, "update informasi set jdl_info='$jdl_info', detail_info='$dtl_info', status='$status' where id_info='$id_info'");
        $_SESSION['editmsg'] = "1";
    } else {
        $_SESSION['editmsg'] = "0";
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

        <?php if (isset($_POST['update'])) {
            if ($_SESSION['editmsg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Pengumuman berhasil diubah.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat mengubah pengumuman. Coba sesaat lagi.</span>
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
                                    <li class="breadcrumb-item"><a href="#">Pilihan <i class="ni ni-ungroup"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Pengumuman</li>
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
                    <h3 class="mb-0">Pengumuman</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <!-- Form groups used in grid -->
                    <form role="form" method="post">
                        <?php

                        $sql = "select * from informasi order by id_info ASC";
                        $stmt = $con->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                        ?>


                            <div class="col-md-4">


                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput1">Judul Pengumuman</label>
                                    <input name="jdl_info" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Judul Pengumuman" value="<?php echo $row['jdl_info']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlInput2">Detail Pengumuman</label>
                                    <textarea class="ckeditor" id="dtl_info" name="dtl_info" id="exampleFormControlTextarea2" rows="8" resize="none" required><?php echo $row['detail_info']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="status" value=0>
                                    <label class="form-control-label" for="exampleFormControlInput2">Tampilkan Pengumuman ?</label>
                                    <div>
                                        <label class="custom-toggle">
                                            <?php $status = $row['status'];
                                            if ($status > 0) :
                                            ?>
                                                <input type="checkbox" name="status" value="1" checked>
                                            <?php else : ?>
                                                <input type="checkbox" name="status" value="1">
                                            <?php endif; ?>

                                            <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <button type="submit" id="update" name="update" class="btn btn-primary my-2">Update Pengumuman</button>
                                </div>
                            </div>
                        <?php } ?>
                    </form>
                    </form>
                </div>

            </div>


            <?php
            include("include/footer.php"); //Edit topnav on this page
            ?>
            <script>
                CKEDITOR.replace('dtl_info', {
                    language: 'id'
                });
            </script>

        </div>
    </div>

    </body>

    </html>
<?php } ?>