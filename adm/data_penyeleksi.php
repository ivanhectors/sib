<?php
session_start();

include("include/config.php");

if (strlen($_SESSION['admlogin']) == 0) {
  header('location:../login');
} else {
  date_default_timezone_set('Asia/Jakarta'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());
  // include("include/header.php");
  // include("include/sidebar.php");


  if (isset($_POST['submit'])) {
    //update info pribadi
    $password = $_POST["password_default"];
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);
    $username = $_POST["username"];
    $email = $_POST['email'];
    $status = 1;
    $role = $_POST['role'];
    $fakultas = $_POST['fakultas'];
    $prodi = $_POST['prodi'];


    //tambah acc
    $sql = mysqli_query($con, "INSERT INTO user_acc (username, password, email, status, kd_role, kd_fakultas, kd_prodi) VALUES ('$username', '$passwordhash', '$email', '$status', '$role', '$fakultas', '$prodi')");
    $_SESSION['msg'] = "1";
  } else {
    $_SESSION['msg'] = "0";
  }

  if (isset($_GET['del'])) {
    mysqli_query($con, "delete from user_acc where id_acc = '" . $_GET['id'] . "'");
    $_SESSION['delmsg'] = "1";
  } else {
    $_SESSION['delmsg'] = "0";
  }

  if (isset($_GET['on'])) {
    mysqli_query($con, "update user_acc set status='1' where id_acc = '" . $_GET['id'] . "'");
    $_SESSION['stsmsg1'] = "1";
  } else {
    $_SESSION['stsmsg1'] = "0";
  }

  if (isset($_GET['off'])) {
    mysqli_query($con, "update user_acc set status='0' where id_acc = '" . $_GET['id'] . "'");
    $_SESSION['stsmsg'] = "1";
  } else {
    $_SESSION['stsmsg'] = "0";
  }

  if (isset($_POST['resetpsw'])) {
    //update info pribadi
    $password_valid =  $_POST["password_valid"];
    $username_valid = $_SESSION['admlogin'];
    $id_user = $_POST['id_user'];

    //update password
    $password =  '1234';
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);

    //validasi password user
    $pass_valid = "SELECT * FROM user_admin WHERE username = '$username_valid'";
    $admin = mysqli_query($con, $pass_valid);

    if (mysqli_num_rows($admin) > 0) {
      while ($row = mysqli_fetch_array($admin)) {
        if (password_verify($password_valid, $row["password"])) {
          //return true;   
          $sql = mysqli_query($con, "update user_acc set password='$passwordhash' where id_acc='$id_user'");
          $_SESSION['pswmsg'] = "1";
          //$successmsg="Data profil anda berhasil diubah.";

        } else {
          //echo "<script>alert('Gagal! Password tidak cocok.');</script>";
          $_SESSION['pswmsg'] = "0";
          //$errormsg="Password lama tidak cocok! Gagal mengubah data.";
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
    <?php if (isset($_POST['submit'])) {
      if ($_SESSION['msg'] > 0) {

    ?>
        <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
            <span data-notify="message">Data Penyeleksi baru berhasil ditambahkan.</span>
          </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
      <?php } else { ?>
        <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
            <span data-notify="message">Terjadi kesalahan saat menambah Data Penyeleksi baru. Coba sesaat lagi.</span>
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
            <span data-notify="message">Penyeleksi berhasil dihapus.</span>
          </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
      <?php } else { ?>
        <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
            <span data-notify="message">Terjadi kesalahan saat menghapus Penyeleksi. Coba sesaat lagi.</span>
          </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
    <?php }
    } ?>


    <?php if (isset($_GET['on'])) {
      if ($_SESSION['stsmsg1'] > 0) {

    ?>
        <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
            <span data-notify="message">Akun Penyeleksi berhasil di aktifkan.</span>
          </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
      <?php } else { ?>
        <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
            <span data-notify="message">Terjadi kesalahan saat mengaktifkan akun Penyeleksi. Coba sesaat lagi.</span>
          </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
    <?php }
    } ?>


    <?php if (isset($_GET['off'])) {
      if ($_SESSION['stsmsg'] > 0) {

    ?>
        <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
            <span data-notify="message">Akun Penyeleksi berhasil di nonaktifkan.</span>
          </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
      <?php } else { ?>
        <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
            <span data-notify="message">Terjadi kesalahan saat me-nonaktifkan akun Penyeleksi. Coba sesaat lagi.</span>
          </div><button type="button" id="close_direct" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
    <?php }
    } ?>
    <?php if (isset($_POST['resetpsw'])) {
      if ($_SESSION['pswmsg'] > 0) {

    ?>
        <div data-notify="container" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Sukses!</span>
            <span data-notify="message">Password User berhasil di Reset ke Default.</span>
          </div><button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 5px; z-index: 1082;">
            <span aria-hidden="true">×</span></button>
        </div>
      <?php } else { ?>
        <div data-notify="container" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
          <span class="alert-icon ni ni-bell-55" data-notify="icon"></span>
          <div class="alert-text" div=""> <span class="alert-title" data-notify="title"> Gagal!</span>
            <span data-notify="message">Password tidak cocok. Reset Password User gagal dilakukan.</span>
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
                  <li class="breadcrumb-item"><a href="../adm">Data Akun</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Penyeleksi</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-sm btn-neutral"><i class="fas fa-user-plus" style="color:primary;"> </i> Tambah Penyeleksi</a>

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
                    <small>Form Tambah Penyeleksi Baru</small>
                  </div>
                  <form role="form" method="post">
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><small class="font-weight-bold">@</small></span>
                        </div>
                        <input onBlur="userAvailability()" id="username" name="username" class="form-control" placeholder="Username Penyeleksi Baru" type="text" title="Masukkan Username" oninvalid="this.setCustomValidity('Selahkan masukkan Username Penyeleksi baru.')" oninput="setCustomValidity('')" required>
                        <div class="input-group-append">
                          <span class="input-group-text" id="user-availability-status1"></span>
                        </div>
                      </div>
                      <span id="user-availability-status1"></span>
                    </div>
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                        </div>
                        <input class="form-control" id="email" name="email" placeholder="Email Penyeleksi Baru" type="email" title="Masukkan Email" oninvalid="this.setCustomValidity('Selahkan masukkan Email Penyeleksi baru.')" oninput="setCustomValidity('')" required>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <select class="form-control" name="role" placeholder="Pilih Akses Penyeleksi" title="Masukkan Hak Akses User" oninvalid="this.setCustomValidity('Selahkan masukkan Hak Akses User baru.')" oninput="setCustomValidity('')" required>
                          <option value="" selected>Pilih Hak Akses User</option>
                          <option value="2">Wakil Rektor III</option>
                          <option value="3">Wakil Dekan III Fakultas</option>
                          <option value="4">Dosen Wali</option>
                        </select>
                        <div class="input-group-prepend">
                          <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Selahkan masukkan Hak Akses User baru."><i class="fas fa-question-circle"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-building"></i></span>
                        </div>
                        <select class="form-control" name="fakultas" id="fakultas" placeholder="Pilih Fakultas" title="Masukkan Fakultas User" oninvalid="this.setCustomValidity('Selahkan masukkan Fakultas User. Jika tidak memiliki fakultas, silahkan pilih Fakultas Lainnya.')" oninput="setCustomValidity('')" required>
                          <option value="" selected>Pilih Fakultas</option>
                          <?php
                          $sql_fakultas = mysqli_query($con, "select * from ref_fakultas order by kd_fakultas ASC");
                          ?>
                          <?php
                          while ($rs_fakultas = mysqli_fetch_assoc($sql_fakultas)) {
                            echo '<option value="' . $rs_fakultas['kd_fakultas'] . '">Fakultas ' . $rs_fakultas['nama_fakultas'] . '</option>';
                          }
                          ?>
                          <img src="../assets/img/loading.gif" width="35" id="load1" style="display:none;" />
                        </select>
                        <div class="input-group-prepend">
                          <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Selahkan masukkan Fakultas User. Jika tidak memiliki fakultas, silahkan pilih Fakultas Lainnya."><i class="fas fa-question-circle"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-city"></i></span>
                        </div>
                        <select class="form-control" name="prodi" id="prodi" placeholder="Pilih Program Studi" title="Masukkan Program Studi Penyeleksi" id="exampleFormControlSelect1" oninvalid="this.setCustomValidity('Selahkan masukkan Program Studi User. Jika tidak memiliki Program Studi, silahkan pilih Program Studi Lainnya.')" oninput="setCustomValidity('')" required>
                          <option value="" selected>Pilih Program Studi</option>
                        </select>
                        <div class="input-group-prepend">
                          <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Selahkan masukkan Program Studi User. Jika tidak memiliki Program Studi, silahkan pilih Program Studi Lainnya."><i class="fas fa-question-circle"></i></span>
                        </div>
                        <img src="../assets/img/loading.gif" width="35" id="load1" style="display:none;" />
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control" type="password" name="password_default" placeholder="Password" value="1234" readonly="readonly">
                      </div>
                      <small>Password default Penyeleksi baru :</small><small style="color:red;"> 1234</small>
                    </div>
                    <div class="text-center pb-0">
                      <button type="submit" id="submit" name="submit" class="btn btn-primary my-4">Tambah Penyeleksi Baru</button>
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
            <div class="card-header">
              <h3 class="mb-0">Data Penyeleksi</h3>
              <p class="text-sm mb-0">
                Tabel ini merupakan data penyeksi beasiswa mulai dari <strong>Wakil Rektor III</strong>, <strong>Wakil Dekan Fakultas III</strong> dan <strong>Wali Studi</strong> Mahasiswa. Admin dapat menambah penyeleksi baru serta memiliki kontrol atas akun penyeleksi tersebut.
              </p>
            </div>
            <!-- Light table -->
            <div class="table-responsive py-4">
              <table class="table align-items-center table-flush table-striped" id="datatable-buttons">
                <thead class="thead-light">
                  <tr>
                    <th>Penyeleksi</th>
                    <th>Tgl Dibuat</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Hak Akses</th>
                    <th>Status</th>
                    <th>Pilihan</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Penyeleksi</th>
                    <th>Tgl Dibuat</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Hak Akses</th>
                    <th>Status</th>
                    <th>Pilihan</th>
                  </tr>
                </tfoot>

                <tbody>
                  <?php $query = "select * from user_acc order by username DESC";
                  $stmt = $con->prepare($query);
                  $stmt->execute();
                  $result = $stmt->get_result();
                  while ($row = $result->fetch_assoc()) {

                  ?>
                    <tr>
                      <td class="table-user">
                        <?php $userphoto = $row['photo_acc'];
                        if ($userphoto == "" || $userphoto == "NULL") :
                        ?>
                          <img src="img/profile.png" class="avatar rounded-circle mr-3">
                        <?php else : ?>
                          <img src="img/<?php echo htmlentities($userphoto); ?>" class="avatar rounded-circle mr-3">
                        <?php endif; ?>
                        <b>
                          <?php $nama_acc = $row['nama_acc'];
                          if ($userphoto == "" || $userphoto == "NULL") {
                            echo htmlentities($row['username']);
                          } else {
                            echo htmlentities($row['nama_acc']);
                          }


                          ?>
                        </b>
                      </td>
                      <td>
                        <span class="text-muted"><?php echo htmlentities($row['createDate']); ?></span>
                      </td>
                      <td>
                        <a href="mailto:<?php echo htmlentities($row['email']); ?>" class="font-weight-bold"><?php echo htmlentities($row['email']); ?></a>
                      </td>
                      <td>
                        <a href="tel:<?php echo htmlentities($row['no_telp']); ?>" class="font-weight-bold"><?php echo htmlentities($row['no_telp']); ?></a>
                      </td>
                      <td>
                        <?php $role = $row['kd_role'];
                        if ($role == 1) {
                          echo '<span class="badge badge-dot mr-4">
                          <i class="bg-danger"></i>
                          <span class="status">Administrator</span>
                          </span>';
                        } elseif ($role == 2) {
                          echo '<span class="badge badge-dot mr-4">
                          <i class="bg-warning"></i>
                          <span class="status">Wakil Rektor 3</span>
                          </span>';
                        } elseif ($role == 3) {
                          echo '<span class="badge badge-dot mr-4">
                          <i class="bg-info"></i>
                          <span class="status">Wakil Dekan 3 Fakultas</span>
                          </span>';
                        } elseif ($role == 4) {
                          echo '<span class="badge badge-dot mr-4">
                          <i class="bg-default"></i>
                          <span class="status">Dosen Wali</span>
                          </span>';
                        } elseif ($role == 5) {
                          echo '<span class="badge badge-dot mr-4">
                          <i class="bg-success"></i>
                          <span class="status">Mahasiswa</span>
                          </span>';
                        } else {
                          echo '';
                        }
                        ?>
                      </td>
                      <td>
                        <?php $status = $row['status'];
                        if ($status > 0) {
                          echo '<span class="badge badge-success">Aktif</span>';
                        } else {
                          echo '<span class="badge badge-danger">Tidak Aktif</span>';
                        }
                        ?>
                      </td>
                      <td class="text-right">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <?php $status = $row['status']; 
                            if ($status > 0) :
                            ?>
                              <a class="dropdown-item" href="data_penyeleksi?id=<?php echo $row['id_acc'] ?>&off=0"><i class="fas fa-lock" style="color:#fb6340;"></i> Nonaktifkan Akun</a>
                            <?php else : ?>
                              <a class="dropdown-item" href="data_penyeleksi?id=<?php echo $row['id_acc'] ?>&on=1"><i class="fas fa-lock-open" style="color:#2dce89;"></i> Aktifkan Akun</span></a>
                            <?php endif; ?>
                            <a class="dropdown-item" style="color: black;" type="button" data-toggle="modal" data-target="#modal-edit<?php echo $row['id_acc'] ?>"><i class="fas fa-pen" style="color:#172b4d;"></i> Edit Akun</a>
                            <a class="dropdown-item" style="color: black;" type="button" data-toggle="modal" data-target="#reset<?php echo $row['id_acc'] ?>" ><i class="fas fa-key" style="color:#5e72e4;"></i> Reset Password</a>
                            <a class="dropdown-item" href="data_penyeleksi?id=<?php echo $row['id_acc'] ?>&del=delete" onClick="return confirm('Yakin ingin menghapus penyeleksi, <?php echo htmlentities($row['username']); ?> ?')"><i class="fas fa-trash" style="color:#f5365c;"></i> Hapus Akun</a>
                          </div>
                        </div>
                      </td>
                      <div class="col-md-4">
      <div class="modal fade" id="modal-edit<?php echo $row['id_acc'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-body p-0">
              <div class="card bg-secondary border-0 mb-0">
                <div class="card-body px-lg-5 py-lg-5">
                  <div class="text-center text-muted mb-4">
                    <small>Form Tambah Penyeleksi Baru</small>
                  </div>
                  <form role="form" method="post">
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><small class="font-weight-bold">@</small></span>
                        </div>
                        <input onBlur="userAvailability()" id="username" name="username" class="form-control" placeholder="Username Penyeleksi Baru" type="text" title="Masukkan Username" oninvalid="this.setCustomValidity('Selahkan masukkan Username Penyeleksi baru.')" oninput="setCustomValidity('')" required>
                        <div class="input-group-append">
                          <span class="input-group-text" id="user-availability-status1"></span>
                        </div>
                      </div>
                      <span id="user-availability-status1"></span>
                    </div>
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                        </div>
                        <input class="form-control" id="email" name="email" placeholder="Email Penyeleksi Baru" type="email" title="Masukkan Email" oninvalid="this.setCustomValidity('Selahkan masukkan Email Penyeleksi baru.')" oninput="setCustomValidity('')" required>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <select class="form-control" name="role" placeholder="Pilih Akses Penyeleksi" title="Masukkan Hak Akses User" oninvalid="this.setCustomValidity('Selahkan masukkan Hak Akses User baru.')" oninput="setCustomValidity('')" required>
                          <option value="" selected>Pilih Hak Akses User</option>
                          <option value="2">Wakil Rektor III</option>
                          <option value="3">Wakil Dekan III Fakultas</option>
                          <option value="4">Dosen Wali</option>
                        </select>
                        <div class="input-group-prepend">
                          <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Selahkan masukkan Hak Akses User baru."><i class="fas fa-question-circle"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-building"></i></span>
                        </div>
                        <select class="form-control" name="fakultas" id="fakultasedit" placeholder="Pilih Fakultas" title="Masukkan Fakultas User" oninvalid="this.setCustomValidity('Selahkan masukkan Fakultas User. Jika tidak memiliki fakultas, silahkan pilih Fakultas Lainnya.')" oninput="setCustomValidity('')" required>
                          <option value="" selected>Pilih Fakultas</option>
                          <?php
                          $sql_fakultas = mysqli_query($con, "select * from ref_fakultas order by kd_fakultas ASC");
                          ?>
                          <?php
                          while ($rs_fakultas = mysqli_fetch_assoc($sql_fakultas)) {
                            echo '<option value="' . $rs_fakultas['kd_fakultas'] . '">Fakultas ' . $rs_fakultas['nama_fakultas'] . '</option>';
                          }
                          ?>
                          <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                        </select>
                        <div class="input-group-prepend">
                          <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Selahkan masukkan Fakultas User. Jika tidak memiliki fakultas, silahkan pilih Fakultas Lainnya."><i class="fas fa-question-circle"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-city"></i></span>
                        </div>
                        <select class="form-control" name="prodi" id="prodiedit" placeholder="Pilih Program Studi" title="Masukkan Program Studi Penyeleksi" id="exampleFormControlSelect1" oninvalid="this.setCustomValidity('Selahkan masukkan Program Studi User. Jika tidak memiliki Program Studi, silahkan pilih Program Studi Lainnya.')" oninput="setCustomValidity('')" required>
                          <option value="" selected>Pilih Program Studi</option>
                        </select>
                        <div class="input-group-prepend">
                          <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Selahkan masukkan Program Studi User. Jika tidak memiliki Program Studi, silahkan pilih Program Studi Lainnya."><i class="fas fa-question-circle"></i></span>
                        </div>
                        <img src="../assets/img/loading.gif" width="35" id="load2" style="display:none;" />
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group input-group-merge input-group-alternative">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                        </div>
                        <input class="form-control" type="password" name="password_default" placeholder="Password" value="1234" readonly="readonly">
                      </div>
                      <small>Password default Penyeleksi baru :</small><small style="color:red;"> 1234</small>
                    </div>
                    <div class="text-center pb-0">
                      <button type="submit" id="submit" name="submit" class="btn btn-primary my-4">Tambah Penyeleksi Baru</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
                      <!-- href="data_penyeleksi?id=<?php echo $row['id_acc'] ?>&reset=true" -->
                  <!-- batas modal form validasi edit profil -->
                  <div class="col-md-4">
                    <div class="modal fade" id="reset<?php echo $row['id_acc'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                      <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                          <div class="modal-body p-0">
                            <div class="card bg-secondary border-0 mb-0">
                            <form method="post">
                              <div class="card-body px-lg-5 py-lg-5">
                                <div class="text-center text-muted mb-4">
                                  <small>Masukkan password anda untuk mereset password user :  <b>
                          <?php $nama_acc = $row['nama_acc'];
                          if ($userphoto == "" || $userphoto == "NULL") {
                            echo htmlentities($row['username']);
                          } else {
                            echo htmlentities($row['nama_acc']);
                          }


                          ?>
                        </b></small>
                                </div>

                                <div class="form-group">
                                  <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input type="hidden" name="id_user" value="<?php echo $row['id_acc'] ?>">
                                    <input class="form-control" name="password_valid" placeholder="Password Anda" type="password" title="Masukkan Password" oninvalid="this.setCustomValidity('Selahkan masukkan Password anda.')" oninput="setCustomValidity('')" required>
                                  </div>

                                </div>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend text-left text-muted">
                                      <span ><i class="fas fa-info-circle"></i> <small>Reset Password Default User akan diubah menjadi <code style="font-size: 1rem;">1234</code>. Setelah user berhasil Login, User tersebut dapat mengubahnya pada pilihan Profil user tersebut. </small></span>
                                    </div>
                                  
                                  </div>
                                <div class="text-center">
                                  <button type="submit" name="resetpsw" class="btn btn-primary my-4">Reset Password</button>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </form>



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
      <script>
        function toggle_select(id) {
          var X = document.getElementById(id);
          if (X.checked == true) {
            X.value = "1";
          } else {
            X.value = "0";
          }
          //var sql="update clients set calendar='" + X.value + "' where cli_ID='" + X.id + "' limit 1";
          var who = X.id;
          var chk = X.value
          //alert("Joe is still debugging: (function incomplete/database record was not updated)\n"+ sql);
          $.ajax({
            //this was the confusing part...did not know how to pass the data to the script
            url: 'as_status_penyeleksi.php',
            type: 'post',
            data: 'who=' + who + '&chk=' + chk,
            success: function(output) {
              alert('success, server says ' + output);
            },
            error: function() {
              alert('something went wrong, save failed');
            }
          });
        }
      </script>
      <script type="text/javascript">
        document.getElementById("close_direct").onclick = function() {
          location.href = "data_penyeleksi";
        };
      </script>
      <script>
        $('.select2').select2();
      </script>
      <script src="js/fakultas-prodi.js"></script>

    </div>
  </div>

  </body>

  </html>
<?php } ?>