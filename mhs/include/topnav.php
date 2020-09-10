<?php

if (strlen($_SESSION['mhslogin']) == 0) {
  header('location:../login');
} else {
  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());

?>


  <!-- Topnav -->
  <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center ml-md-auto">
          <li class="nav-item d-xl-none">
            <!-- Sidenav toggler -->
            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">

              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <p class="nav-link mb-0 text-sm  font-weight-bold text-white" href="#">

              <i class="ni ni-calendar-grid-58"></i>
              <?php
              // Mengambil data Genap/Ganjil berdasarkan Tahun saat ini dan Bulan saat ini
              // Membuat periode tahun ajaran seperti 2020/2021 pada inputan database
              $year = date('Y');
              $periode_tahun = date('n');
              if ($periode_tahun <= 6) {
                $periode_tahun = "GENAP" . " " . intval($year - 1) . "/" . $year;
                echo $periode_tahun;
              } else {
                $periode_tahun = "GANJIL" . " " . $year . "/" . intval($year + 1);
                echo $periode_tahun;
              } ?>
              <!-- <span class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Kamu Memiliki 13 Notifikasi"><i class="ni ni-bell-55 text-primary"></i> 13</span> -->
            </p>

          </li>
        </ul>
        <ul class="navbar-nav align-items-center ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <?php $query = mysqli_query($con, "select * from user_mhs where username='" . $_SESSION['mhslogin'] . "'");
                while ($row = mysqli_fetch_array($query)) {
                ?>
                  <span class="avatar avatar-sm rounded-circle">
                    <?php $userphoto = $row['photo_mhs'];
                    if ($userphoto == "") :
                    ?>
                      <img src="img/profile.png" alt="Image placeholder">
                    <?php else : ?>
                      <img alt="Image placeholder" src="img/<?php echo htmlentities($userphoto); ?>">
                    <?php endif; ?>

                  </span>
                  <div class="media-body ml-2 d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold"><?php echo htmlentities($_SESSION['mhslogin']); ?></span>
                  </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0" title="Username Anda"><?php echo htmlentities($row['nama_mhs']); ?></h6>
              </div>
            <?php } ?>
            <?php
            $mhs = $_SESSION['mhslogin'];
            $query = "select * from user_mhs join ref_fakultas, ref_prodi where user_mhs.kd_fakultas=ref_fakultas.kd_fakultas AND user_mhs.kd_prodi=ref_prodi.kd_prodi and user_mhs.username =?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $mhs);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {

              while ($row = $result->fetch_assoc()) {
            ?>
                <a href="#" class="dropdown-item">
                  <span>Fakultas <?php echo htmlentities($row['nama_fakultas']); ?></span>
                </a>
                <p href="#" class="dropdown-item">
                  <span>Program Studi <?php echo htmlentities($row['nama_prodi']); ?></span>
                </p>
            <?php }
            } else{"";} ?>
            <div class="dropdown-divider"></div>
            <a href="profile" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>Profil Saya</span>
            </a>
            <!-- <a href="#!" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Settings</span>
            </a> -->
            <a href="kalender" class="dropdown-item">
              <i class="ni ni-calendar-grid-58"></i>
              <span>Kalender</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ni ni-support-16"></i>
              <span>Support</span>
            </a>

            <a href="logout" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<?php } ?>