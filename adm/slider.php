<?php
session_start();
include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
    header('location:../login');
} else {
    date_default_timezone_set('Asia/Jakarta'); // change according timezone
    $currentTime = date('d-m-Y h:i:s A', time());

    if (isset($_POST['gambar']) && isset($_FILES['fileToUpload'])) {

        define('KB', 1024);
        define('MB', 1048576);
        define('GB', 1073741824);
        define('TB', 1099511627776);
        $imgfile = $_FILES["fileToUpload"]["name"];
        $date = date('d-m-Y_H-i-s');

        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $imageFileName = strtolower(pathinfo($target_file, PATHINFO_FILENAME));
        // // get the image extension
        $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
        // // allowed extensions
        // $allowed_extensions = array(".jpg","jpeg",".png",".gif");

        // Validation for allowed extensions .in_array() function searches an array for a specific value.
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo '<script language="javascript">';
            echo 'alert("Format yang diterima hanya JPG, PNG & JPEG")';
            echo '</script>';
        } else {
            if ($_FILES["fileToUpload"]["size"] > 2 * MB) {
                echo '<script language="javascript">';
                echo 'alert("Ukuran file terlalu besar. Pastikan ukuran file kecil dari 2 MB")';
                echo '</script>';
            } else {
                //rename the image file
                $imgnewfile = md5($imageFileName) . "_" . md5($date) . "." . $imageFileType;
                // Code for move image into directory
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../assets/img/slider/" . $imgnewfile);
                // Query for insertion data into database
                $query = mysqli_query($con, "INSERT INTO img (img, jdl_img) VALUES ('$imgnewfile','$imageFileName')");
                if ($query) {
                    echo '<script language="javascript">';
                    echo 'alert("Berhasil menambahkan foto slider baru!")';
                    echo '</script>';
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("Gagal menambahkan foto slider baru!")';
                    echo '</script>';
                }
            }
        }
    }


    if (isset($_GET['del'])) {
        mysqli_query($con, "delete from img where id_img = '" . $_GET['id'] . "'");
        $_SESSION['delmsg'] = "1";
    } else {
        $_SESSION['delmsg'] = "0";
    }

    if (isset($_GET['on'])) {
        mysqli_query($con, "update img set status='1' where id_img = '" . $_GET['id'] . "'");
        $_SESSION['stsmsg1'] = "1";
    } else {
        $_SESSION['stsmsg1'] = "0";
    }

    if (isset($_GET['off'])) {
        mysqli_query($con, "update img set status='0' where id_img = '" . $_GET['id'] . "'");
        $_SESSION['stsmsg'] = "1";
    } else {
        $_SESSION['stsmsg'] = "0";
    }

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

    <style>
        .file {
            visibility: hidden;
            position: absolute;
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

        <?php if (isset($_POST['update'])) {
            if ($_SESSION['editmsg'] > 0) {

        ?>
                <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
                        <span data-notify="message">Slider berhasil diubah.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
            <?php } else { ?>
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                    <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
                    <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
                        <span data-notify="message">Terjadi kesalahan saat mengubah Slider. Coba sesaat lagi.</span>
                    </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                        <span aria-hidden="true">×</span></button>
                </div>
        <?php }
        } ?>

<?php if(isset($_GET['del']))
{ if ($_SESSION['delmsg'] > 0){
  
  ?>
                  <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span> 
                  <span data-notify="message">Gambar slider berhasil dihapus.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } else {?> 
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                  <span data-notify="message">Terjadi kesalahan saat menghapus gambar. Coba sesaat lagi.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } }?> 


<?php if(isset($_GET['on']))
{ if ($_SESSION['stsmsg1'] > 0){
  
  ?>
                  <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span> 
                  <span data-notify="message">Gambar Slider berhasil di tampilkan.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } else {?> 
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                  <span data-notify="message">Terjadi kesalahan saat menampilkan gambar. Coba sesaat lagi.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } }?> 


<?php if(isset($_GET['off']))
{ if ($_SESSION['stsmsg'] > 0){
  
  ?>
                  <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span> 
                  <span data-notify="message">Gambar slider berhasil di sembunyikan.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } else {?> 
                <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
                  <span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
                  <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span> 
                  <span data-notify="message">Terjadi kesalahan saat me-nyembunyikan gambar slider. Coba sesaat lagi.</span>
                </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
                <span aria-hidden="true">×</span></button></div>
<?php } }?> 
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
                                    <li class="breadcrumb-item active" aria-current="page">Slider</li>
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
                    <h3 class="mb-0">Slider</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <!-- Form groups used in grid -->

                    <form role="form" enctype="multipart/form-data" method="post">



                        <div class="col-md-12">

                            <!-- Multiple -->
                            <!-- <div class="dropzone dropzone-multiple" data-toggle="dropzone" data-dropzone-multiple data-dropzone-url="http://">
                                        <div class="fallback">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="customFileUploadMultiple" multiple>
                                                <label class="custom-file-label" for="customFileUploadMultiple">Choose file</label>
                                            </div>
                                        </div>
                                        <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush">
                                            <li class="list-group-item px-0">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="avatar">
                                                            <img class="avatar-img rounded" src="..." alt="..." data-dz-thumbnail>
                                                        </div>
                                                    </div>
                                                    <div class="col ml--3">
                                                        <h4 class="mb-1" data-dz-name>...</h4>
                                                        <p class="small text-muted mb-0" data-dz-size>...</p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-ellipses dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a href="#" class="dropdown-item" data-dz-remove>
                                                                    Remove
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    </div> -->



                        </div>

                    </form>

                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-control-label" for="exampleFormControlInput1">Ukuran Banner Slider</label>
                            <div class="ml-2 col-sm-6 center">
                                <img src="../assets/img/slider/1360x312.png" id="preview" class="img-thumbnail">
                            </div>
                        </div>
                        <!-- Multiple -->
                        <div class="custom-file">
                            <input type="file" accept="image/*" name="fileToUpload" class="custom-file-input file" id="fileToUpload" lang="id">
                            <label class="custom-file-label" for="fileToUpload">Pilih File</label>
                        </div>
                        <div class="text-right pt-4 pt-md-4 pb-0 pb-md-4">
                            <div>
                                <button type="submit" id="gambar" name="gambar" class="btn btn-primary my-2">Upload Gambar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">Foto Slider</h3>
            </div>
            <!-- Card body -->



            <div class="card-body">
                <!-- Form groups used in grid -->

                <div class="row">
                    <?php

                    $sql = "select * from img order by id_img ASC";
                    $stmt = $con->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {

                    ?>
                        <div class="col-md-6">
                            <!-- Image overlay -->

                            <div class="card bg-dark text-white border-0">

                                <img class="card-img" src="../assets/img/slider/<?php echo $row['img']; ?>" alt="<?php echo $row['jdl_img']; ?>" />



                                <div class="card-img-overlay align-items-top">
                                    <!-- <div>
                                        <h5 class="h2 card-title text-white mb-2">Card title</h5>
                                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                        <p class="card-text text-sm font-weight-bold">Last updated 3 mins ago</p>
                                    </div> -->
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-primary text-white card-text text-sm font-weight-bold" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">
                                            <?php $status = $row['status'];
                                            if ($status > 0) :
                                            ?>
                                                <a class="dropdown-item" href="slider?id=<?php echo $row['id_img'] ?>&off=0"><i class="fas fa-eye-slash" style="color:#fb6340;"></i> Sembunyikan Gambar</a>
                                            <?php else : ?>
                                                <a class="dropdown-item" href="slider?id=<?php echo $row['id_img'] ?>&on=1"><i class="fas fa-eye" style="color:#2dce89;"></i> Tampilkan Gambar</span></a>
                                            <?php endif; ?>

                                            <a class="dropdown-item" href="slider?id=<?php echo $row['id_img'] ?>&del=delete" onClick="return confirm('Yakin ingin menghapus gambar slider, <?php echo $row['jdl_img'] ?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Hapus Gambar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>






                </div>




            </div>
        </div>


        <?php
        include("include/footer.php"); //Edit topnav on this page
        ?>
        <script>
            $(document).on("click", ".browse", function() {
                var file = $(this).parents().find(".file");
                file.trigger("click");
            });
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                $("#file").val(fileName);

                var reader = new FileReader();
                reader.onload = function(e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("preview").src = e.target.result;
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
            });
        </script>
        <script>
            $(document).on('change', '.custom-file-input', function(event) {
                $(this).next('.custom-file-label').html(event.target.files[0].name);
            })
        </script>
        <script type="text/javascript">
    document.getElementById("close_direct").onclick = function () {
        location.href = "slider";
    };
</script>
    </div>
    </div>

    </body>

    </html>
<?php } ?>