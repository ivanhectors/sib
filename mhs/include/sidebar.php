<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="../mhs?id">
          <img src="../assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "index" ? "active" : "") ?>" href="../mhs?id">
                <i class="ni ni-shop text-primary"></i>
                <span class="nav-link-text">Dashboards</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "pengajuan" ? "active" : "") ?>" href="pengajuan">
                <i class="ni ni-single-copy-04 text-danger"></i>
                <span class="nav-link-text">Pengajuan</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?php echo ($parentpage == "riwayat_pengajuan" ? "active" : "") ?>" href="riwayat_pengajuan">
                <i class="ni ni-money-coins text-primary"></i>
                <span class="nav-link-text">Riwayat Pengajuan</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($page == "kalender" ? "active" : "") ?>" href="kalender">
                <i class="ni ni-calendar-grid-58 text-red"></i>
                <span class="nav-link-text">Kalender</span>
              </a>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">Eksternal Link</h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-4">
            <li class="nav-item">
              <a class="nav-link" href="https://www.ukdw.ac.id/" target="_blank">
                <i class="fas fa-globe-asia"></i>
                <span class="nav-link-text">Website UKDW</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://eclass.ukdw.ac.id/id/" target="_blank">
                <i class="ni ni-laptop"></i>
                <span class="nav-link-text">E-class</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://ssat.ukdw.ac.id/" target="_blank">
              <i class="fab fa-envira"></i>
                <span class="nav-link-text">SSAT</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://eq.ukdw.ac.id/" target="_blank">
                <i class="fas fa-scroll"></i>
                <span class="nav-link-text">eqUKDW<strong>+</strong></span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>