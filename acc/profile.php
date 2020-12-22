<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['acclogin']) == 0) {
  header('location:../403');
} else {
  date_default_timezone_set('Asia/Jakarta'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());
  include("include/header.php");
  include("include/sidebar.php");


  if (isset($_POST['submit'])) {
    //update info pribadi
    $password_valid =  $_POST["password_valid"];
    $username_valid = $_SESSION['acclogin'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nama_acc = $_POST['nama_acc'];
    $no_telp = $_POST['no_telp'];
    $gender = $_POST['gender'];
    $date = $_POST['tgl_lahir'];
    $tgl_lahir = (new DateTime($date))->format('Y-m-d');

    //$photo_acc=$_POST['photo_acc'];

    //update kontak
    $alamat = $_POST['alamat'];
    $provinsi = $_POST['provinsi'];
    $kab_kota = $_POST['kab_kota'];
    $kecamatan = $_POST['kecamatan'];
    $kode_pos = $_POST['kode_pos'];

    //validasi password user
    $pass_valid = "SELECT * FROM user_acc WHERE username = '$username_valid'";
    $acc = mysqli_query($con, $pass_valid);

    if (mysqli_num_rows($acc) > 0) {
      while ($row = mysqli_fetch_array($acc)) {
        if (password_verify($password_valid, $row["password"])) {
          //return true;   
          $sql = mysqli_query($con, "update user_acc set username='$username',nama_acc='$nama_acc',email='$email',no_telp='$no_telp',gender='$gender',alamat='$alamat',provinsi='$provinsi',kab_kota='$kab_kota',kecamatan='$kecamatan',kode_pos='$kode_pos',tgl_lahir='$tgl_lahir' where username='" . $_SESSION['acclogin'] . "'");
          $_SESSION['msg'] = "1";
          //$successmsg="Data profil anda berhasil diubah.";

        } else {
          //echo "<script>alert('Gagal! Password tidak cocok.');</script>";
          $_SESSION['msg'] = "0";
          //$errormsg="Password lama tidak cocok! Gagal mengubah data.";
        }
      }
      //echo "<script>alert('Fetch Array Gagal');</script>";
    }
    //echo "<script>alert('Number of Rows 0');</script>";
  }


  if (isset($_POST['gambar']) && isset($_FILES['fileToUpload'])) {

    define('KB', 1024);
    define('MB', 1048576);
    define('GB', 1073741824);
    define('TB', 1099511627776);
    $imgfile = $_FILES["fileToUpload"]["name"];

    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // // get the image extension
    $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
    // // allowed extensions
    // $allowed_extensions = array(".jpg","jpeg",".png",".gif");

    // Validation for allowed extensions .in_array() function searches an array for a specific value.
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      echo " 
<div data-notify='container' class='alert alert-dismissible alert-danger alert-notify animated fadeInDown' role='alert' data-notify-position='top-center' style='display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;'>
<span class='alert-icon ni ni-bell-55' data-notify='icon'></span> 
<div class='alert-text' div=''> <span class='alert-title' data-notify='title'> Gagal!</span> 
<span data-notify='message'>Format yang diizinkan hanya JPG, PNG dan JPEG.</span>
</div><button type='button' class='close' data-dismiss='alert' aria-label='Close' style='position: absolute; right: 10px; top: 5px; z-index: 1082;'>
<span aria-hidden='true'>×</span></button></div>
";
    } else {
      if ($_FILES["fileToUpload"]["size"] > 2 * MB) {
        echo " 
         <div data-notify='container' class='alert alert-dismissible alert-danger alert-notify animated fadeInDown' role='alert' data-notify-position='top-center' style='display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;'>
         <span class='alert-icon ni ni-bell-55' data-notify='icon'></span> 
         <div class='alert-text' div=''> <span class='alert-title' data-notify='title'> Gagal!</span> 
         <span data-notify='message'>Ukuran file gambar lebih dari 2 MB</span>
       </div><button type='button' class='close' data-dismiss='alert' aria-label='Close' style='position: absolute; right: 10px; top: 5px; z-index: 1082;'>
       <span aria-hidden='true'>×</span></button></div>
       ";
      } else {
        //rename the image file
        $imgnewfile = md5($imgfile) . uniqid() . $extension;
        // Code for move image into directory
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "img/" . $imgnewfile);
        // Query for insertion data into database
        $query = mysqli_query($con, "update user_acc set photo_acc='$imgnewfile' where username='" . $_SESSION['acclogin'] . "'");
        if ($query) {
          echo " 
         <div data-notify='container' class='alert alert-dismissible alert-success alert-notify animated fadeInDown' role='alert' data-notify-position='top-center' style='display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;'>
         <span class='alert-icon ni ni-bell-55' data-notify='icon'></span> 
         <div class='alert-text' div=''> <span class='alert-title' data-notify='title'> Berhasil!</span> 
         <span data-notify='message'>Foto profil berhasil diubah.</span>
       </div><button type='button' class='close' data-dismiss='alert' aria-label='Close' style='position: absolute; right: 10px; top: 5px; z-index: 1082;'>
       <span aria-hidden='true'>×</span></button></div>
       ";
        } else {
          echo " 
         <div data-notify='container' class='alert alert-dismissible alert-danger alert-notify animated fadeInDown' role='alert' data-notify-position='top-center' style='display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;'>
         <span class='alert-icon ni ni-bell-55' data-notify='icon'></span> 
         <div class='alert-text' div=''> <span class='alert-title' data-notify='title'> Gagal!</span> 
         <span data-notify='message'>Maaf, foto gagal diubah. coba lagi.</span>
       </div><button type='button' class='close' data-dismiss='alert' aria-label='Close' style='position: absolute; right: 10px; top: 5px; z-index: 1082;'>
       <span aria-hidden='true'>×</span></button></div>
       ";
        }
      }
    }
  }

  // password acc : $2y$10$biOI1T7.vdq0kgCOmv6vC.ndpob2oi26QqCmWg4wcxrJV9K8FR8Qu

  if (isset($_POST['changepsw'])) {
    $password =  $_POST["password"];
    $usernames = $_SESSION['acclogin'];
    $newpassword = $_POST["newpassword"];
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);
    $newpasswordhash = password_hash($newpassword, PASSWORD_DEFAULT);
    $passchange = "SELECT * FROM user_acc WHERE username = '$usernames'";
    $acc = mysqli_query($con, $passchange);

    if (mysqli_num_rows($acc) > 0) {
      while ($row20 = mysqli_fetch_array($acc)) {
        if (password_verify($password, $row20["password"])) {
          //return true;   
          $log = mysqli_query($con, "update user_acc set password='$newpasswordhash' where username='" . $_SESSION['acclogin'] . "'");
          echo ("<script>location.href = 'logout';</script>");
          exit();
        } else {
          echo "<script>alert('Password lama tidak cocok');</script>";
        }
      }
      //echo "<script>alert('Fetch Array Gagal');</script>";
    }
    //echo "<script>alert('Number of Rows 0');</script>";
  }

?>
  <?php
  include("include/header.php");
  ?>
  <script>
    function userAvailability() {
      $("#loaderIcon").show();
      jQuery.ajax({
        url: "check_username.php",
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
  <script type="text/javascript">
    function valid() {
      if (document.chngpwd.password.value == "") {
        alert("Password lama tidak boleh kosong.");
        document.chngpwd.password.focus();
        return false;
      } else if (document.chngpwd.newpassword.value == "") {
        alert("Password Baru tidak boleh kosong.");
        document.chngpwd.newpassword.focus();
        return false;
      } else if (document.chngpwd.confirmpassword.value == "") {
        alert("Ulangi password baru anda.");
        document.chngpwd.confirmpassword.focus();
        return false;
      } else if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("Password baru tidak cocok.");
        document.chngpwd.confirmpassword.focus();
        return false;
      }
      return true;
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
    <!-- Topnav -->
    <?php
    include("include/topnav.php"); //Edit topnav on this page
    ?>
    <!-- Header -->
    <!-- Header -->
    <?php if (isset($_POST['submit'])) {
      if ($_SESSION['msg'] > 0) {

    ?>
        <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
            <span data-notify="message">Data Profil berhasil diubah.</span>
          </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
      <?php } else { ?>
        <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
            <span data-notify="message">Password tidak cocok. Data Gagal diubah.</span>
          </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
    <?php }
    } ?>
    <?php $query = mysqli_query($con, "select * from user_acc where username = '" . $_SESSION['acclogin'] . "'");
    $cnt = 1;
    while ($row = mysqli_fetch_array($query)) {
    ?>
      <div class="header pb-6 d-flex align-items-center" style="min-height: 500px; background-image: url(img/profile-illustrator.jpg); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
          <div class="row">
            <div class="col-lg-12 col-md-10">
              <h1 class="display-2 text-white">Hello,
                <?php $nama_acc = $row['nama_acc'];
                if ($nama_acc == "" || $nama_acc == "NULL") {
                  echo htmlentities($row['username']);
                } else {
                  echo htmlentities($row['nama_acc']);
                }


                ?>
              </h1>
            </div>
            <div class="col-lg-7 col-md-10">

              <p class="text-white mt-0 mb-5">Ini merupakan halaman detail profil kamu. Kamu dapat mengubah data pribadi kamu disini. Demi keamanan data pribadi, kamu diharapkan untuk memasukkan password kembali saat mengubah data tersebut.</p>
              <a href="../acc?id=" type="button" class="btn btn-neutral btn-icon">
                <span class="btn-inner--icon"><i class="fas fa-home"></i></span>
                <span class="btn-inner--text">Dashboard</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Page content -->
      <div class="container-fluid mt--6">
        <div class="row">
          <div class="col-xl-4 order-xl-2">
            <div class="card card-header">

              <div class="row justify-content-center">
                <div class="col-lg-3 order-lg-2">
                  <div class="card-profile-image">
                    <?php $userphoto = $row['photo_acc'];
                    if ($userphoto == "" || $userphoto == "NULL") :
                    ?>
                      <img src="img/profile.png" class="rounded-circle">
                    <?php else : ?>
                      <img src="img/<?php echo htmlentities($userphoto); ?>" class="rounded-circle">
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php } ?>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">

            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center">

                  </div>
                </div>
              </div>

              <form method="post" enctype="multipart/form-data">
                <!-- Multiple -->
                <div class="custom-file">
                  <input type="file" name="fileToUpload" class="custom-file-input" id="fileToUpload" lang="id">
                  <label class="custom-file-label" for="fileToUpload">Pilih File</label>
                </div>
                <div class="text-right pt-4 pt-md-4 pb-0 pb-md-4">
                  <div>
                    <button type="submit" name="gambar" class="btn btn-sm btn-default float-right">Ubah Foto</button>
                  </div>
              </form>
            </div>
            </div>
          </div>
          <!-- Progress track -->
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <!-- Title -->
              <h5 class="h3 mb-0">Ubah Password</h5>
            </div>
            <!-- Card body -->


            <div class="card-body ">
              <form method="post" name="chngpwd" onSubmit="return valid();">
                <!-- List group -->
                <ul class="list-group list-group-flush list my--3">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label">Password Saat Ini</label>
                      <input type="password" name="password" class="form-control" placeholder="Masukkan Password saat ini" title="Masukkan Password" oninvalid="this.setCustomValidity('Selahkan masukkan Password anda.')" oninput="setCustomValidity('')" required>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label">Password Baru</label>
                      <input type="password" name="newpassword" class="form-control" placeholder="Masukkan Password Baru" title="Masukkan Password Baru" oninvalid="this.setCustomValidity('Selahkan masukkan Password baru anda.')" oninput="setCustomValidity('')" required>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-control-label">Ulangi Password Baru</label>
                      <input type="password" name="confirmpassword" class="form-control" placeholder="Ulangi Password Baru" title="Ulangi Masukkan Password Baru" oninvalid="this.setCustomValidity('Selahkan ulangi masukkan Password baru anda.')" oninput="setCustomValidity('')" required>
                    </div>
                  </div>

                </ul>
                <div class="text-right pt-4 pt-md-4 pb-0 pb-md-4">

                  <!-- <a href="#" class="btn btn-sm btn-warning float-right">Ubah Password</a> -->


                  <button type="button" class="btn btn-sm btn-warning float-right" data-toggle="modal" data-target="#modal-notification">Ubah Password</button>
                  <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                      <div class="modal-content bg-gradient-danger">
                        <div class="modal-header">
                          <h6 class="modal-title" id="modal-title-notification">Yakin ingin mengubah password?</h6>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="py-3 text-center">
                            <i class="ni ni-bell-55 ni-3x"></i>
                            <h4 class="heading mt-4">Ketentuan mengubah password</h4>
                            <p>Mengubah password kamu saat ini akan mengganti password akun kamu pada sistem termasuk pada proses login.
                              Setelah berhasil mengubah, kamu akan otomatis logout sistem dan dapat masuk kembali menggunakan password baru kamu.</p>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" name="changepsw" class="btn btn-white">Mengerti & Ganti Password</button>
                          <button class="btn btn-link text-white ml-auto" data-dismiss="modal">Batal</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            </form>
 
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          <div class="row">
            <?php $query10 = mysqli_query($con, "SELECT 
                                          ((CASE WHEN `nama_acc` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `gender` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `tgl_lahir` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `photo_acc` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `email` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `alamat` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `provinsi` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `kab_kota` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `kecamatan` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `kode_pos` IS NULL OR '' THEN 0 ELSE 1 END)
                                          + (CASE WHEN `no_telp` IS NULL OR '' THEN 0 ELSE 1 END)) AS sum_of_nulls

                                          FROM user_acc WHERE username='" . $_SESSION['acclogin'] . "'");
            $cnt = 1;
            while ($row2 = mysqli_fetch_array($query10)) {
            ?>
              <!-- <div class="col-lg-12">
                <div class="card bg-gradient-white border-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0 text-warning">Kelengkapan Profil</h5>
                        <span class="h3 font-weight-bold mb-0 text-white"> &nbsp </span>
                      </div>
                      <div class="col-auto">
                        <span class="h1 font-weight-bold mb-0 
                      <?php
                      $null = $row2['sum_of_nulls'];
                      $jumlah = $null / 11 * 100;
                      $presentase = round($jumlah);
                      if ($presentase >= '80') {
                        echo "text-success";
                      } else {
                        echo "text-warning";
                      };
                      ?>
                      
                      "><?php
                        $null = $row2['sum_of_nulls'];
                        $jumlah = $null / 11 * 100;
                        echo round($jumlah);
                        ?>%</span>
                      </div>
                    </div>
                    <div class="progress">
                      <div class="progress-bar  
                       <?php $presentase = round($jumlah);
                        if ($presentase >= '80') {
                          echo "bg-success";
                        } else {
                          echo "bg-warning";
                        };
                        ?>
                       " role="progressbar" aria-valuenow="<?php echo round($jumlah); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php $s = round($jumlah);
                                                                                                                                              echo  "$jumlah%"; ?>"></div>
                    </div>
                  </div>
                </div>
              </div> -->

            <?php } ?>


          </div>
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Edit profil </h3>
                </div>
                <div class="col-4 text-right">

                </div>
              </div>
            </div>
            <div class="card-body">
              <form name="dosen" method="post">
                <?php $query2 = mysqli_query($con, "select * from user_acc where username = '" . $_SESSION['acclogin'] . "'");
                $cnt = 1;
                while ($row = mysqli_fetch_array($query2)) {
                ?>
                  <h6 class="heading-small text-muted mb-4">Informasi Pengguna</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">Username</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><small class="font-weight-bold">@</small></span>
                            </div>
                            <input type="text" onBlur="userAvailability()" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo htmlentities($row['username']); ?>">
                            <div class="input-group-append">
                              <span class="input-group-text" id="user-availability-status1"></span>
                            </div>
                          </div>
                          <span id="user-availability-status1"></span>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-email">Email</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo htmlentities($row['email']); ?>">
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">Nama Lengkap</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" id="input-first-name" name="nama_acc" class="form-control" placeholder="Nama Lengkap" value="<?php echo htmlentities($row['nama_acc']); ?>">
                          </div>

                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-last-name">No. Telpon</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="tel" id="input-last-name" name="no_telp" maxlength="13" class="form-control" placeholder="No. Telpon" value="<?php echo htmlentities($row['no_telp']); ?>">
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">Tanggal Lahir</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input class="form-control" data-provide="datepicker" data-date-format="dd-mm-yyyy" name="tgl_lahir" id="tgl_lahir" placeholder="Pilih Tanggal" type="text" value="<?php $date = $row['tgl_lahir']; echo date('d-m-Y', strtotime($date)); ?>">
                          </div>

                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="pilihGender" for="input-gender">Gender</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                            </div>
                            <select class="form-control" name="gender" placeholder="Pilih Gender" id="exampleFormControlSelect1">
                              <option value="<?php echo htmlentities($row['gender']); ?>"><?php

                                                                                          $gender = $row['gender'];
                                                                                           if ($gender == "Pria") {
                                                                                            echo "Pria";
                                                                                          } elseif ($gender == "Wanita") {
                                                                                            echo "Wanita";
                                                                                          } else {
                                                                                            echo "Pilih Gender";
                                                                                          }
                                                                                          ?></option>
                                                                                          <div class="dropdown-divider"></div>
                              <option value="Pria">Pria</option>
                              <option value="Wanita">Wanita</option>
                            </select>
                          </div>


                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="my-4" />
                  <!-- Address -->
                  <h6 class="heading-small text-muted mb-4">Informasi Kontak</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-address">Alamat Saat Ini</label>
                          <input id="input-address" name="alamat" class="form-control" placeholder="Alamat Saat Ini" value="<?php echo htmlentities($row['alamat']); ?>" type="text">
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">Provinsi</label>

                        <select class="form-control" name="provinsi" title="provinsi" id="provinsi">
                          <?php
                          $sql_provinsi = mysqli_query($con, "select * from user_acc join provinces, regencies, districts where user_acc.provinsi=provinces.id AND user_acc.kab_kota=regencies.id and user_acc.kecamatan=districts.id and user_acc.username = '" . $_SESSION['acclogin'] . "'");
                          ?>

                          <?php
                          if (mysqli_num_rows($sql_provinsi) > 0) {
                            while ($rs_provinsi = mysqli_fetch_assoc($sql_provinsi)) {
                              echo '<option value="' . $rs_provinsi['provinsi'] . '">' . $rs_provinsi['name_province'] . '</option>';
                            }
                          } else {
                            echo '<option></option>';
                          }

                          ?>
                          <?php
                          $sql_provinsi = mysqli_query($con, "SELECT * FROM provinces ORDER BY name_province ASC");
                          ?>
                          <?php
                          while ($rs_provinsi = mysqli_fetch_assoc($sql_provinsi)) {
                            echo '<option value="' . $rs_provinsi['id'] . '">' . $rs_provinsi['name_province'] . '</option>';
                          }
                          ?>
                        </select>
                        <img src="../assets/img/loading.gif" width="35" id="load1" style="display:none;" />
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">Kab/Kota</label>
                        <select class="form-control" name="kab_kota" title="Pilih Kab/Kota" id="kota">
                          <?php
                          $sql_kota = mysqli_query($con, "select * from user_acc join provinces, regencies, districts where user_acc.provinsi=provinces.id AND user_acc.kab_kota=regencies.id and user_acc.kecamatan=districts.id and user_acc.username = '" . $_SESSION['acclogin'] . "'");
                          ?>

                          <?php
                          if (mysqli_num_rows($sql_kota) > 0) {
                            while ($rs_kota = mysqli_fetch_assoc($sql_kota)) {
                              echo '<option value="' . $rs_kota['kab_kota'] . '">' . $rs_kota['name_regency'] . '</option>';
                            }
                          } else {
                            echo '<option></option>';
                          }

                          ?>

                        </select>
                        <img src="../assets/img/loading.gif" width="35" id="load1" style="display:none;" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Kecamatan</label>
                        <select class="form-control" name="kecamatan" title="Pilih Kecamatan" id="kecamatan">
                          <?php
                          $sql_kecamatan = mysqli_query($con, "select * from user_acc join provinces, regencies, districts where user_acc.provinsi=provinces.id AND user_acc.kab_kota=regencies.id and user_acc.kecamatan=districts.id and user_acc.username = '" . $_SESSION['acclogin'] . "'");
                          ?>

                          <?php
                          if (mysqli_num_rows($sql_kecamatan) > 0) {
                            while ($rs_kecamatan = mysqli_fetch_assoc($sql_kecamatan)) {
                              echo '<option value="' . $rs_kecamatan['kecamatan'] . '">' . $rs_kecamatan['name_district'] . '</option>';
                            }
                          } else {
                            echo '<option></option>';
                          }

                          ?>

                        </select>
                        <img src="../assets/img/loading.gif" width="35" id="load1" style="display:none;" />
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Kode Pos</label>
                        <?php
                        $sql_kodepos = mysqli_query($con, "select * from user_acc where user_acc.username = '" . $_SESSION['acclogin'] . "'");
                        while ($row = mysqli_fetch_array($sql_kodepos)) {
                        ?>


                          <input type="tel" maxlength="5" name="kode_pos" class="form-control" placeholder="Kode Pos" value="<?php echo htmlentities($row['kode_pos']); ?>">
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="text-right pt-4 pt-md-4 pb-0 pb-md-4">
                  <button type="button" id="submit" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-primary">Ubah Data</button>
                  </div>


                  <!-- batas modal form validasi edit profil -->
                  <div class="col-md-4">
                    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                      <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-body p-0">
                            <div class="card bg-secondary border-0 mb-0">

                              <div class="card-body px-lg-5 py-lg-5">
                                <div class="text-center text-muted mb-4">
                                  <small>Masukkan password untuk mengubah data</small>
                                </div>

                                <div class="form-group">
                                  <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" name="password_valid" placeholder="Password" type="password" title="Masukkan Password" oninvalid="this.setCustomValidity('Selahkan masukkan Password anda.')" oninput="setCustomValidity('')" required>
                                  </div>
                                </div>
                                <div class="text-center">
                                  <button type="submit" id="submit" name="submit" class="btn btn-primary my-4">Ubah Data</button>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>



              </form>
            </div>
          </div>
        </div>
      </div>

      <?php
      include("include/footer.php"); //Edit topnav on this page
      ?>
      <script>
        $('.select2').select2();
      </script>
      <script src="js/app.js"></script>
      <script>
        $.fn.datepicker.defaults.format = "dd/mm/yyyy";
        $('.tgl_lahir').datepicker({
          format: "yyyy-mm-dd",
          language: "id",
          todayHighlight: true
        });
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