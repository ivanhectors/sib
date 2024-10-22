<?php

if (strlen($_SESSION['admlogin']) == 0) {
  header('location:../login');
} else {
  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());

?>


  <!-- Topnav -->
  <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search form -->
        <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
          <div class="form-group mb-0">
            <div class="input-group input-group-alternative input-group-merge">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
              </div>
              <input class="form-control" placeholder="Cari Halaman ..." onkeyup="showResult(this.value)" type="text">
            </div>

          </div>
          <div id="livesearch"></div>

          <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </form>

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
                $periode_tahun = intval($year - 1) . "/" . $year .  " " . " GENAP";
                echo $periode_tahun;
              } else {
                $periode_tahun = $year . "/" . intval($year + 1). " ". " GASAL ";
                echo $periode_tahun;
              } ?>
              <!-- <span class="badge badge-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Kamu Memiliki 13 Notifikasi"><i class="ni ni-bell-55 text-primary"></i> 13</span> -->
            </p>

          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ni ni-ungroup"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default dropdown-menu-right pilihan-menu">
              <div class="row shortcuts px-4">
                <a href="kalender" class="col-4 shortcut-item">
                  <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                    <i class="ni ni-calendar-grid-58"></i>
                  </span>
                  <small>Kalender</small>
                </a>
                <a href="pengumuman" class="col-4 shortcut-item">
                  <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                    <i class="fas fa-bullhorn"></i>
                  </span>
                  <small>Pengumuman</small>
                </a>
                <a href="slider" class="col-4 shortcut-item">
                  <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                    <i class="fas fa-images"></i>
                  </span>
                  <small>Slider</small>
                </a>
                <!-- <a href="#!" class="col-4 shortcut-item">
                  <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                    <i class="ni ni-books"></i>
                  </span>
                  <small>Reports</small>
                </a>
                <a href="#!" class="col-4 shortcut-item">
                  <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                    <i class="ni ni-pin-3"></i>
                  </span>
                  <small>Maps</small>
                </a>
                <a href="#!" class="col-4 shortcut-item">
                  <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                    <i class="ni ni-basket"></i>
                  </span>
                  <small>Shop</small>
                </a> -->
              </div>
            </div>
          </li>
        </ul>
        <ul class="navbar-nav align-items-center ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <?php $query = mysqli_query($con, "select * from user_admin where username='" . $_SESSION['admlogin'] . "'");
                while ($row = mysqli_fetch_array($query)) {
                ?>
                  <span class="avatar avatar-sm rounded-circle">
                    <?php $userphoto = $row['photo_admin'];
                    if ($userphoto == "") :
                    ?>
                      <img src="img/profile.png" alt="Image placeholder">
                    <?php else : ?>
                      <img alt="Image placeholder" src="img/<?php echo htmlentities($userphoto); ?>">
                    <?php endif; ?>

                  </span>
                  <div class="media-body ml-2 d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold"><?php echo htmlentities($row['nama_admin']); ?></span>
                  </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0" data-toggle="tooltip" data-placement="left" title="Username Anda">@<?php echo htmlentities($_SESSION['admlogin']); ?></h6>
              </div>
            <?php } ?>
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
            <!-- <a href="#!" class="dropdown-item">
              <i class="ni ni-support-16"></i>
              <span>Support</span>
            </a> -->

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